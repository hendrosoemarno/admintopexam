<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentTryoutBasicController extends Controller
{
    public function index()
    {
        try {
            $data = DB::connection('moodle')->select("
                SELECT
                    u.id AS userid,
                    qa2.id AS quizattemptsid,
                    CONCAT(u.firstname, ' ', u.lastname) AS nama_siswa,
                    c.fullname AS nama_course,
                    qz.name AS nama_quiz,
                    FROM_UNIXTIME(MAX(qa2.timefinish), '%d-%m-%Y %H:%i') AS tanggal_akses
                FROM mdlax_quiz_attempts qa2
                JOIN mdlax_user u ON u.id = qa2.userid
                JOIN mdlax_quiz qz ON qz.id = qa2.quiz
                JOIN mdlax_course c ON c.id = qz.course
                JOIN mdlax_question_attempts qa ON qa.questionusageid = qa2.uniqueid
                JOIN mdlax_question q ON q.id = qa.questionid
                JOIN mdlax_question_versions qv ON qv.questionid = q.id
                JOIN mdlax_question_bank_entries qbe ON qbe.id = qv.questionbankentryid
                JOIN mdlax_question_categories qc ON qc.id = qbe.questioncategoryid
                JOIN mdlax_question_attempt_steps qs ON qs.questionattemptid = qa.id
                WHERE qz.name LIKE '%Basic%'
                  AND qs.state IN ('gradedright','gradedwrong','gradedpartial')
                GROUP BY u.id, qa2.id, nama_siswa, c.fullname, qz.name
                ORDER BY MAX(qa2.timefinish) DESC
            ");

        } catch (\Throwable $e) {
            Log::error('Error fetching Try Out Basic data: '.$e->getMessage());
            $data = [];
        }

        return view('students.tryoutbasic.index', compact('data'));
    }

    public function show($quizattemptsid)
    {
        try {
            // 1) Info attempt
            $result = DB::connection('moodle')->selectOne("
                SELECT
                    u.firstname,
                    u.lastname,
                    c.fullname AS course,
                    qz.name AS quiz_name,
                    FROM_UNIXTIME(qa.timefinish, '%d-%m-%Y %H:%i') AS tanggal
                FROM mdlax_quiz_attempts qa
                JOIN mdlax_user u ON u.id = qa.userid
                JOIN mdlax_quiz qz ON qz.id = qa.quiz
                JOIN mdlax_course c ON c.id = qz.course
                WHERE qa.id = ?
                AND qz.name LIKE '%Basic%'
                LIMIT 1
            ", [$quizattemptsid]);

            if (!$result) {
                return back()->with('error', 'Data raport tidak ditemukan.');
            }

            // 2) Ambil nilai subkategori (aggregate)
            $subkategori = DB::connection('moodle')->select("
                SELECT
                    MIN(s.id) AS siapid,
                    s.basic AS subkategori_nama,
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
                JOIN mdlax_question q ON q.id = qa.questionid
                JOIN mdlax_question_versions qv ON qv.questionid = q.id
                JOIN mdlax_question_bank_entries qbe ON qbe.id = qv.questionbankentryid
                JOIN mdlax_question_categories qc ON qc.id = qbe.questioncategoryid

                JOIN mdlax_question_categories_siap qcs ON qcs.questioncategoriesid = qc.id
                JOIN mdlax_siap s ON s.id = qcs.siapid

                JOIN mdlax_quiz qz ON qz.id = qa2.quiz
                WHERE qa2.id = ?
                AND qz.name LIKE '%Basic%'
                GROUP BY s.basic, s.keterangan
                ORDER BY s.keterangan, s.basic;
            ", [$quizattemptsid]);

            // 3) Inisialisasi
            $result->detail_math = [];
            $result->detail_bin  = [];

            $result->math_score  = 0;
            $result->math_total  = 0;

            $result->bin_score   = 0;
            $result->bin_total   = 0;

            // 4) Olah setiap subkategori
            foreach ($subkategori as $row) {
                $skor   = (float) $row->skor;
                $total  = (int) $row->jumlah_soal;

                // skor subkategori (%)
                $persen = $total > 0 ? round(($skor * 100 / $total), 2) : 0;

                // Ambil deskripsi label
                $grade = DB::connection('moodle')->selectOne("
                    SELECT label, kategori AS description
                    FROM mdlax_grade_description
                    WHERE :p BETWEEN range_min AND range_max
                    LIMIT 1
                ", ['p' => $persen]);

                $label = $grade ? $grade->label : '-';
                $desc  = $grade ? $grade->description : '-';

                // Tentukan kolom rekomendasi berdasarkan label
                $kolom = match(strtolower($label)) {
                    'kurang'     => 'rekom_basic_kurang',
                    'bisa'       => 'rekom_basic_bisa',
                    'kompeten'   => 'rekom_basic_kompeten',
                    'excellent'  => 'rekom_basic_excelent',
                    default      => 'rekom_basic_kurang'
                };

                // Ambil rekomendasi dari tabel mdlax_siap
                $rekom = DB::connection('moodle')->selectOne("
                    SELECT $kolom AS rekom
                    FROM mdlax_siap
                    WHERE id = ?
                ", [$row->siapid]);

                $dataItem = [
                    'nama'  => $row->subkategori_nama,
                    'persen'=> $persen,      // <---- nilai /100
                    'label' => $label,
                    'desc'  => $desc,
                    'rekom'  => $rekom ? $rekom->rekom : '-',
                    'total' => $total
                ];

                // Matematika
                if (stripos($row->bidang, 'Matematika') !== false) {
                    $result->detail_math[] = $dataItem;
                    $result->math_score += $persen;
                    $result->math_total += 100;   // setiap subkategori bernilai maksimal 100
                }

                // Bahasa Indonesia
                if (stripos($row->bidang, 'Bahasa Indonesia') !== false) {
                    $result->detail_bin[] = $dataItem;
                    $result->bin_score += $persen;
                    $result->bin_total += 100;
                }
            }

            // 5) Hitung nilai akhir /100
            $result->math_final  = $result->math_total > 0 ? round(($result->math_score / $result->math_total) * 100, 2) : 0;
            $result->bin_final   = $result->bin_total > 0 ? round(($result->bin_score / $result->bin_total) * 100, 2) : 0;

            // Total keseluruhan
            $result->nilai = round(($result->math_final + $result->bin_final) / 2, 2);

            // 6) Label untuk total
            $totalGrade = DB::connection('moodle')->selectOne("
                SELECT label, keseluruhan AS description
                FROM mdlax_grade_description
                WHERE :p BETWEEN range_min AND range_max
                LIMIT 1
            ", ['p' => $result->nilai]);

            $result->total_label = $totalGrade ? $totalGrade->label : '-';
            $result->total_desc  = $totalGrade ? $totalGrade->description : '-';

            // label math
            $mathGrade = DB::connection('moodle')->selectOne("
                SELECT label, matematika AS description
                FROM mdlax_grade_description
                WHERE :p BETWEEN range_min AND range_max
                LIMIT 1
            ", ['p' => $result->math_final]);

            $result->math_label = $mathGrade ? $mathGrade->label : '-';
            $result->math_desc  = $mathGrade ? $mathGrade->description : '-';

            // label bin
            $binGrade = DB::connection('moodle')->selectOne("
                SELECT label, bahasa_indonesia AS description
                FROM mdlax_grade_description
                WHERE :p BETWEEN range_min AND range_max
                LIMIT 1
            ", ['p' => $result->bin_final]);

            $result->bin_label = $binGrade ? $binGrade->label : '-';
            $result->bin_desc  = $binGrade ? $binGrade->description : '-';


        } catch (\Throwable $e) {
            Log::error('Error fetching Try Out Basic report: '.$e->getMessage());
            return back()->with('error', 'Gagal mengambil data raport.');
        }

        return view('students.tryoutbasic.report', compact('result'));
    }


}
