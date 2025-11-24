<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentTryoutQuickController extends Controller
{
    public function index()
    {
        try {
            // 🔹 Ambil daftar siswa yang pernah mengerjakan Tryout Quick
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
                WHERE qz.name LIKE '%Quick%'
                  AND qs.state IN ('gradedright', 'gradedwrong', 'gradedpartial')
                GROUP BY u.id, qa2.id, nama_siswa, c.fullname, qz.name
                ORDER BY MAX(qa2.timefinish) DESC
            ");

        } catch (\Throwable $e) {
            Log::error('Error fetching Try Out Quick data: ' . $e->getMessage());
            $data = [];
        }

        return view('students.tryoutquick.index', compact('data'));
    }

    public function show($quizattemptsid)
    {
        try {
            // 🔹 Ambil skor total attempt terakhir
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
                  AND qz.name LIKE '%Quick%'
                ORDER BY qa.timefinish DESC
                LIMIT 1
            ", [$quizattemptsid]);

            if (!$result) {
                return back()->with('error', 'Data raport tidak ditemukan untuk siswa ini.');
            }

            // 🔹 Ambil data nilai per kategori (mat & bin)
            $kategori = DB::connection('moodle')->select("
                SELECT
                    qc.name AS category,
                    SUM(qs.fraction) AS skor_kategori,
                    COUNT(*) AS jumlah_soal,
                    ROUND((SUM(qs.fraction) / COUNT(*)) , 2) AS nilai
                FROM mdlax_quiz_attempts qa2
                JOIN mdlax_question_attempts qa ON qa.questionusageid = qa2.uniqueid
                JOIN mdlax_question_attempt_steps qs ON qs.questionattemptid = qa.id
                JOIN mdlax_question q ON q.id = qa.questionid
                JOIN mdlax_question_versions qv ON qv.questionid = q.id
                JOIN mdlax_question_bank_entries qbe ON qbe.id = qv.questionbankentryid
                JOIN mdlax_question_categories qc ON qc.id = qbe.questioncategoryid
                JOIN mdlax_quiz qz ON qz.id = qa2.quiz
                WHERE qa2.id = ?
                  AND qz.name LIKE '%Quick%'
                  AND qs.state IN ('gradedright','gradedwrong','gradedpartial')
                  AND (qc.name LIKE '%mat%' OR qc.name LIKE '%bin%')
                GROUP BY qc.name
            ", [$quizattemptsid]);

            // 🔹 Default 0
            $result->math_score = 0;
            $result->bin_score = 0;
            $result->math_total = 0;
            $result->bin_total = 0;
            $result->total_soal = 0;
            $result->skor = 0;
            $result->nilai = 0;

            // 🔹 Masukkan hasil ke variabel
            foreach ($kategori as $row) {
                if (stripos($row->category, 'mat') !== false) {
                    $result->math_score = $result->math_score + $row->nilai; // nilai matematika
                    $result->math_total = $result->math_total + $row->jumlah_soal; // jumlah soal matematika
                }
                if (stripos($row->category, 'bin') !== false) {
                    $result->bin_score = $result->bin_score + $row->nilai;  // nilai bahasa indonesia
                    $result->bin_total = $result->bin_total + $row->jumlah_soal;  // jumlah soal bahasa indonesia
                }
            }

            $result->total_soal = $result->math_total + $result->bin_total; // total soal
            $result->skor = $result->bin_score + $result->math_score; // total benar
            $result->nilai = $result->skor * 100 / $result->total_soal; //nilai akhir

        } catch (\Throwable $e) {
            Log::error('Error fetching Try Out Quick report: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengambil data raport.');
        }

        return view('students.tryoutquick.report', compact('result'));
    }
}
