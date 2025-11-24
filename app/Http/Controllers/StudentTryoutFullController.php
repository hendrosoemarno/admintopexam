<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentTryoutFullController extends Controller
{
    public function index()
    {
        try {
            $data = DB::connection('moodle')->select("
                SELECT
                    u.id AS userid,
                    c.id AS courseid,
                    CONCAT(u.firstname, ' ', u.lastname) AS nama_siswa,
                    c.fullname AS nama_course,
                    FROM_UNIXTIME(MAX(qa2.timefinish), '%d-%m-%Y %H:%i') AS tanggal_akses,
                    MAX(qa2.id) AS last_quizattemptsid
                FROM mdlax_quiz_attempts qa2
                JOIN mdlax_user u ON u.id = qa2.userid
                JOIN mdlax_quiz qz ON qz.id = qa2.quiz
                JOIN mdlax_course c ON c.id = qz.course
                JOIN mdlax_question_attempts qa ON qa.questionusageid = qa2.uniqueid
                JOIN mdlax_question_attempt_steps qs ON qs.questionattemptid = qa.id
                WHERE qz.name LIKE '%Full%'
                AND qs.state IN ('gradedright','gradedwrong','gradedpartial')
                GROUP BY u.id, c.id, nama_siswa, c.fullname
                ORDER BY MAX(qa2.timefinish) DESC
            ");

        } catch (\Throwable $e) {
            Log::error('Error fetching Try Out Full data: '.$e->getMessage());
            $data = [];
        }

        return view('students.tryoutfull.index', compact('data'));
    }


public function show($userid, $courseid)
{
    try {
        // (1) Ambil info user + course
        $result = DB::connection('moodle')->selectOne("
            SELECT
                u.firstname,
                u.lastname,
                c.fullname AS course
            FROM mdlax_user u
            JOIN mdlax_role_assignments ra ON ra.userid = u.id
            JOIN mdlax_context ctx ON ctx.id = ra.contextid
            JOIN mdlax_course c ON c.id = ctx.instanceid
            WHERE u.id = ?
              AND c.id = ?
            LIMIT 1
        ", [$userid, $courseid]);

        if (!$result) {
            return back()->with('error', 'Data raport tidak ditemukan.');
        }

        // (2) Ambil tanggal attempt terakhir di course Full
        $lastAttempt = DB::connection('moodle')->selectOne("
            SELECT FROM_UNIXTIME(MAX(qa.timefinish), '%d-%m-%Y %H:%i') AS tanggal
            FROM mdlax_quiz_attempts qa
            JOIN mdlax_quiz qz ON qz.id = qa.quiz
            WHERE qa.userid = ?
              AND qz.course = ?
              AND qz.name LIKE '%Full%'
        ", [$userid, $courseid]);

        $result->tanggal = $lastAttempt ? $lastAttempt->tanggal : '-';

        // (3) Ambil nilai per subkategori (s.full) — gunakan nilai final tiap questionattempt (MAX fraction)
        $subkategori = DB::connection('moodle')->select("
            SELECT
                MIN(s.id) AS siapid,
                s.full AS subkategori_nama,
                s.keterangan AS bidang,
                COUNT(qaq.questionattemptid) AS jumlah_soal,
                ROUND(SUM(qaq.max_fraction), 6) AS skor
            FROM (
                SELECT
                    qas.questionattemptid,
                    MAX(qas.fraction) AS max_fraction
                FROM mdlax_question_attempt_steps qas
                WHERE qas.state IN ('gradedright','gradedwrong','gradedpartial')
                GROUP BY qas.questionattemptid
            ) AS qaq
            JOIN mdlax_question_attempts qa ON qa.id = qaq.questionattemptid
            JOIN mdlax_quiz_attempts qa2 ON qa2.uniqueid = qa.questionusageid
            JOIN mdlax_quiz qz ON qz.id = qa2.quiz

            JOIN mdlax_question q ON q.id = qa.questionid
            JOIN mdlax_question_versions qv ON qv.questionid = q.id
            JOIN mdlax_question_bank_entries qbe ON qbe.id = qv.questionbankentryid
            JOIN mdlax_question_categories qc ON qc.id = qbe.questioncategoryid

            JOIN mdlax_question_categories_siap qcs ON qcs.questioncategoriesid = qc.id
            JOIN mdlax_siap s ON s.id = qcs.siapid

            WHERE qa2.userid = ?
              AND qz.course = ?
              AND qz.name LIKE '%Full%'
            GROUP BY s.full, s.keterangan
            ORDER BY s.keterangan, s.full
        ", [$userid, $courseid]);

        // (4) Inisialisasi hasil
        $result->detail_math = [];
        $result->detail_bin  = [];

        // Untuk menghitung rata-rata subkategori: kita akan menjumlahkan persen tiap subkategori
        // dan menghitung total maksimal (100 * jumlah_subkategori) lalu ambil persentase akhir.
        $result->math_score_sum = 0.0;
        $result->math_subcount = 0;

        $result->bin_score_sum = 0.0;
        $result->bin_subcount = 0;

        // (5) Olah subkategori
        foreach ($subkategori as $row) {
            $skor  = (float) $row->skor;            // jumlah fraction (0..1 per soal) total untuk subkategori
            $total = (int) $row->jumlah_soal;      // jumlah soal di subkategori

            // persen subkategori (0..100)
            $persen = $total > 0 ? round($skor * 100 / $total, 2) : 0.0;

            // Ambil deskripsi/keterangan dari mdlax_grade_description:
            // untuk subkategori gunakan kolom 'kategori'
            $gradeDesc = DB::connection('moodle')->selectOne("
                SELECT label, kategori AS keterangan
                FROM mdlax_grade_description
                WHERE :p BETWEEN range_min AND range_max
                LIMIT 1
            ", ['p' => $persen]);

            $label = $gradeDesc ? $gradeDesc->label : '-';
            $desc  = $gradeDesc ? $gradeDesc->keterangan : '-';

                // Tentukan kolom rekomendasi berdasarkan label
                $kolom = match(strtolower($label)) {
                    'kurang'     => 'rekom_full_kurang',
                    'bisa'       => 'rekom_full_bisa',
                    'kompeten'   => 'rekom_full_kompeten',
                    'excellent'  => 'rekom_full_excelent',
                    default      => 'rekom_full_kurang'
                };

                // Ambil rekomendasi dari tabel mdlax_siap
                $rekom = DB::connection('moodle')->selectOne("
                    SELECT $kolom AS rekom
                    FROM mdlax_siap
                    WHERE id = ?
                ", [$row->siapid]);

                $item = [
                'nama'   => $row->subkategori_nama,
                'skor'   => $skor,
                'total'  => $total,
                'persen' => $persen,
                'label'  => $label,
                'rekom'  => $rekom ? $rekom->rekom : '-',
                'desc'   => $desc,
            ];

            if (stripos($row->bidang, 'Matematika') !== false) {
                $result->detail_math[] = $item;
                $result->math_score_sum += $persen;
                $result->math_subcount++;
            } elseif (stripos($row->bidang, 'Bahasa Indonesia') !== false) {
                $result->detail_bin[] = $item;
                $result->bin_score_sum += $persen;
                $result->bin_subcount++;
            } else {
                // jika ada bidang lain, bisa diabaikan atau ditampung sesuai kebutuhan
            }
        }

        // (6) Hitung nilai akhir per mata pelajaran sebagai rata-rata persen subkategori (jika ada)
        $result->math_final = $result->math_subcount > 0
            ? round($result->math_score_sum / $result->math_subcount, 2)
            : 0.0;

        $result->bin_final = $result->bin_subcount > 0
            ? round($result->bin_score_sum / $result->bin_subcount, 2)
            : 0.0;

        // (7) Hitung nilai keseluruhan sebagai rata-rata antara math_final dan bin_final (jika kedua ada),
        // atau jika hanya satu mapel ada, ambil nilai mapel tersebut.
        if ($result->math_subcount > 0 && $result->bin_subcount > 0) {
            $result->nilai = round(($result->math_final + $result->bin_final) / 2, 2);
        } elseif ($result->math_subcount > 0) {
            $result->nilai = $result->math_final;
        } elseif ($result->bin_subcount > 0) {
            $result->nilai = $result->bin_final;
        } else {
            $result->nilai = 0.0;
        }

        // (8) Ambil keterangan label & teks untuk matematika, bahasa, dan keseluruhan
        $totalGrade = DB::connection('moodle')->selectOne("
            SELECT label, keseluruhan AS keterangan
            FROM mdlax_grade_description
            WHERE :p BETWEEN range_min AND range_max
            LIMIT 1
        ", ['p' => $result->nilai]);

        $mathGrade = DB::connection('moodle')->selectOne("
            SELECT label, matematika AS keterangan
            FROM mdlax_grade_description
            WHERE :p BETWEEN range_min AND range_max
            LIMIT 1
        ", ['p' => $result->math_final]);

        $binGrade = DB::connection('moodle')->selectOne("
            SELECT label, bahasa_indonesia AS keterangan
            FROM mdlax_grade_description
            WHERE :p BETWEEN range_min AND range_max
            LIMIT 1
        ", ['p' => $result->bin_final]);

        $result->total_label = $totalGrade ? $totalGrade->label : '-';
        $result->total_desc  = $totalGrade ? $totalGrade->keterangan : '-';

        $result->math_label = $mathGrade ? $mathGrade->label : '-';
        $result->math_desc  = $mathGrade ? $mathGrade->keterangan : '-';

        $result->bin_label = $binGrade ? $binGrade->label : '-';
        $result->bin_desc  = $binGrade ? $binGrade->keterangan : '-';

    } catch (\Throwable $e) {
        Log::error('Error fetching Try Out Full report: '.$e->getMessage());
        return back()->with('error', 'Gagal mengambil data raport.');
    }

    return view('students.tryoutfull.report', compact('result'));
}
 



}
