<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class StudentTryoutWhatsappController extends Controller
{
    public function index()
    {
        try {
            // Group by User and Course to show student-centric list
            $data = DB::connection('moodle')->select("
                SELECT
                    u.id AS userid,
                    c.id AS courseid,
                    CONCAT(u.firstname, ' ', u.lastname) AS nama_siswa,
                    c.fullname AS nama_course,
                    COUNT(qa2.id) AS total_attempts,
                    FROM_UNIXTIME(MAX(qa2.timefinish), '%d-%m-%Y %H:%i') AS terakhir_akses
                FROM mdlax_quiz_attempts qa2
                JOIN mdlax_user u ON u.id = qa2.userid
                JOIN mdlax_quiz qz ON qz.id = qa2.quiz
                JOIN mdlax_course c ON c.id = qz.course
                WHERE c.fullname LIKE '%WhatsApp%'
                GROUP BY u.id, c.id, nama_siswa, c.fullname
                ORDER BY MAX(qa2.timefinish) DESC
            ");

            if (!empty($data)) {
                $userids = array_column($data, 'userid');

                // Ambil mapping field (shortname -> id)
                $fields = DB::connection('moodle')
                    ->table('user_info_field')
                    ->whereIn('shortname', ['parent_name', 'student_WA', 'parent_wa'])
                    ->pluck('id', 'shortname');

                // Ambil data user_info_data
                $infoData = DB::connection('moodle')
                    ->table('user_info_data')
                    ->whereIn('userid', $userids)
                    ->whereIn('fieldid', $fields->values())
                    ->get();

                // Map data ke user id
                $extraMap = [];
                foreach ($infoData as $idat) {
                    $fieldname = $fields->search($idat->fieldid);
                    if ($fieldname) {
                        $extraMap[$idat->userid][$fieldname] = $idat->data;
                    }
                }

                // Masukkan ke data utama
                foreach ($data as $row) {
                    $row->parent_name = $extraMap[$row->userid]['parent_name'] ?? '-';
                    $row->student_WA = $extraMap[$row->userid]['student_WA'] ?? '-';
                    $row->parent_wa = $extraMap[$row->userid]['parent_wa'] ?? '-';
                }
            }

        } catch (\Throwable $e) {
            Log::error('Error fetching Whatsapp index: ' . $e->getMessage());
            $data = [];
        }

        return view('students.whatsapp.index', compact('data'));
    }

    public function select($userid, $courseid)
    {
        try {
            $student = DB::connection('moodle')->selectOne("SELECT id, firstname, lastname FROM mdlax_user WHERE id = ?", [$userid]);
            $course = DB::connection('moodle')->selectOne("SELECT id, fullname FROM mdlax_course WHERE id = ?", [$courseid]);

            $attempts = DB::connection('moodle')->select("
                SELECT 
                    qa.id, 
                    qz.name as quiz_name, 
                    FROM_UNIXTIME(qa.timefinish, '%d-%m-%Y %H:%i') as tanggal,
                    qa.sumgrades,
                    qz.sumgrades as max_grade
                FROM mdlax_quiz_attempts qa
                JOIN mdlax_quiz qz ON qz.id = qa.quiz
                WHERE qa.userid = ? AND qz.course = ?
                ORDER BY qa.timefinish DESC
            ", [$userid, $courseid]);

            return view('students.whatsapp.select', compact('student', 'course', 'attempts'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat pilihan kuis: ' . $e->getMessage());
        }
    }

    public function show(Request $request)
    {
        // Handle both multiple IDs (from selector) and single ID (historical support/direct links)
        $ids = $request->input('ids');
        if (!$ids) {
            $singleId = $request->route('id');
            if ($singleId) {
                $ids = [$singleId];
            }
        }

        if (empty($ids)) {
            return back()->with('error', 'Pilih minimal satu kuis untuk dianalisis.');
        }

        // Ensure $ids is an array
        if (!is_array($ids)) {
            $ids = explode(',', $ids);
        }

        try {
            // 1) Info attempt pertama (sebagai referensi nama & course)
            $firstId = $ids[0];
            $result = DB::connection('moodle')->selectOne("
                SELECT
                    u.id as userid,
                    u.firstname,
                    u.lastname,
                    c.id as courseid,
                    c.fullname AS course,
                    FROM_UNIXTIME(MAX(qa.timefinish), '%d-%m-%Y %H:%i') AS tanggal
                FROM mdlax_quiz_attempts qa
                JOIN mdlax_user u ON u.id = qa.userid
                JOIN mdlax_quiz qz ON qz.id = qa.quiz
                JOIN mdlax_course c ON c.id = qz.course
                WHERE qa.id = ?
                GROUP BY u.id, u.firstname, u.lastname, c.id, c.fullname
                LIMIT 1
            ", [$firstId]);

            if (!$result) {
                return back()->with('error', 'Data raport tidak ditemukan.');
            }

            // 2) Ambil nilai subkategori (AGGREGATE FROM ALL SELECTED IDS)
            $placeholders = implode(',', array_fill(0, count($ids), '?'));

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

                WHERE qa2.id IN ($placeholders)
                GROUP BY s.basic, s.keterangan
                ORDER BY s.keterangan, s.basic;
            ", $ids);

            // 3) Inisialisasi
            $result->detail_math = [];
            $result->detail_bin = [];

            $result->math_score = 0;
            $result->math_total = 0;

            $result->bin_score = 0;
            $result->bin_total = 0;

            // 4) Olah setiap subkategori
            foreach ($subkategori as $row) {
                $skor = (float) $row->skor;
                $total = (int) $row->jumlah_soal;

                $persen = $total > 0 ? round(($skor * 100 / $total), 2) : 0;

                $grade = DB::connection('moodle')->selectOne("
                    SELECT label, kategori AS description
                    FROM mdlax_grade_description
                    WHERE :p BETWEEN range_min AND range_max
                    LIMIT 1
                ", ['p' => $persen]);

                $label = $grade ? $grade->label : '-';
                $desc = $grade ? $grade->description : '-';

                $kolom = match (strtolower($label)) {
                    'kurang' => 'rekom_basic_kurang',
                    'bisa' => 'rekom_basic_bisa',
                    'kompeten' => 'rekom_basic_kompeten',
                    'excellent' => 'rekom_basic_excelent',
                    default => 'rekom_basic_kurang'
                };

                $rekom = DB::connection('moodle')->selectOne("
                    SELECT $kolom AS rekom
                    FROM mdlax_siap
                    WHERE id = ?
                ", [$row->siapid]);

                $dataItem = [
                    'nama' => $row->subkategori_nama,
                    'persen' => $persen,
                    'label' => $label,
                    'desc' => $desc,
                    'rekom' => $rekom ? $rekom->rekom : '-',
                    'total' => $total
                ];

                if (stripos($row->bidang, 'Matematika') !== false) {
                    $result->detail_math[] = $dataItem;
                    $result->math_score += $persen;
                    $result->math_total += 100;
                }

                if (stripos($row->bidang, 'Bahasa Indonesia') !== false) {
                    $result->detail_bin[] = $dataItem;
                    $result->bin_score += $persen;
                    $result->bin_total += 100;
                }
            }

            $result->math_final = $result->math_total > 0 ? round(($result->math_score / $result->math_total) * 100, 2) : 0;
            $result->bin_final = $result->bin_total > 0 ? round(($result->bin_score / $result->bin_total) * 100, 2) : 0;
            $result->nilai = round(($result->math_final + $result->bin_final) / 2, 2);

            $totalGrade = DB::connection('moodle')->selectOne("
                SELECT label, keseluruhan AS description
                FROM mdlax_grade_description
                WHERE :p BETWEEN range_min AND range_max
                LIMIT 1
            ", ['p' => $result->nilai]);

            $result->total_label = $totalGrade ? $totalGrade->label : '-';
            $result->total_desc = $totalGrade ? $totalGrade->description : '-';

            $mathGrade = DB::connection('moodle')->selectOne("
                SELECT label, matematika AS description
                FROM mdlax_grade_description
                WHERE :p BETWEEN range_min AND range_max
                LIMIT 1
            ", ['p' => $result->math_final]);

            $result->math_label = $mathGrade ? $mathGrade->label : '-';
            $result->math_desc = $mathGrade ? $mathGrade->description : '-';

            $binGrade = DB::connection('moodle')->selectOne("
                SELECT label, bahasa_indonesia AS description
                FROM mdlax_grade_description
                WHERE :p BETWEEN range_min AND range_max
                LIMIT 1
            ", ['p' => $result->bin_final]);

            $result->bin_label = $binGrade ? $binGrade->label : '-';
            $result->bin_desc = $binGrade ? $binGrade->description : '-';


        } catch (\Throwable $e) {
            Log::error('Error fetching Try Out Whatsapp report: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengambil data raport: ' . $e->getMessage());
        }

        return view('students.whatsapp.report', compact('result', 'ids'));
    }

    // WA Report History Methods
    public function history()
    {
        try {
            $data = DB::connection('moodle')->select("
                SELECT 
                    wr.id,
                    u.id as userid,
                    CONCAT(u.firstname, ' ', u.lastname) as nama_siswa,
                    c.id as courseid,
                    c.fullname as nama_course,
                    wr.tanggal_kirim
                FROM mdlax_wa_report wr
                JOIN mdlax_user u ON u.id = wr.id_user
                JOIN mdlax_course c ON c.id = wr.id_course
                ORDER BY wr.tanggal_kirim DESC
            ");
            return view('students.whatsapp.history', compact('data'));
        } catch (\Exception $e) {
            Log::error('Error fetching WA History: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat riwayat: ' . $e->getMessage());
        }
    }

    public function storeReport(Request $request)
    {
        $request->validate([
            'id_user' => 'required',
            'id_course' => 'required',
            'tanggal_kirim' => 'required|date'
        ]);

        try {
            DB::connection('moodle')->table('wa_report')->insert([
                'id_user' => $request->id_user,
                'id_course' => $request->id_course,
                'tanggal_kirim' => Carbon::parse($request->tanggal_kirim),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            return redirect()->route('students.tryoutwhatsapp.history')->with('success', 'Laporan berhasil dicatat.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mencatat laporan: ' . $e->getMessage());
        }
    }

    public function updateReport(Request $request, $id)
    {
        $request->validate([
            'tanggal_kirim' => 'required|date'
        ]);

        try {
            DB::connection('moodle')->table('wa_report')
                ->where('id', $id)
                ->update([
                    'tanggal_kirim' => Carbon::parse($request->tanggal_kirim),
                    'updated_at' => now()
                ]);
            return back()->with('success', 'Laporan berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui laporan: ' . $e->getMessage());
        }
    }

    public function destroyReport($id)
    {
        try {
            DB::connection('moodle')->table('wa_report')->where('id', $id)->delete();
            return back()->with('success', 'Laporan berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus laporan: ' . $e->getMessage());
        }
    }
}
