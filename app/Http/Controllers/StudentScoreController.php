<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentScoreController extends Controller
{
    public function index()
    {
        try {
            $data = DB::connection('moodle')->select("
                SELECT
                    u.id AS userid,
                    CONCAT(u.firstname, ' ', u.lastname) AS nama_siswa,
                    c.fullname AS nama_course,
                    qz.name AS nama_quiz,
                    qc.name AS question_category,
                    qs.state AS status
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
                WHERE qz.name LIKE '%Siap%'
                  AND qs.state IN ('gradedright', 'gradedwrong')
                ORDER BY u.firstname, c.fullname, qz.name
            ");

            // Bersihkan kategori & ubah status di PHP
            foreach ($data as $row) {
                $raw = $row->question_category;

                // 1️⃣ Hapus kode di awal seperti (A01) atau C02
                $clean = preg_replace('/^(\([A-Za-z0-9]+\)\s*|[A-Za-z]\d{2}\s*)/', '', $raw);

                // 2️⃣ Hapus akhiran seperti "- Mudah bin" atau "- Sedang mat"
                $clean = preg_replace('/\s*-\s*(Mudah|Sedang|Sulit)\s+[A-Za-z]+$/i', '', $clean);

                // 3️⃣ Hapus tanda minus ganda atau spasi berlebih
                $clean = preg_replace('/\s*-\s*$/', '', $clean);
                $clean = trim(preg_replace('/\s+/', ' ', $clean));

                $row->category_clean = $clean;

                // Tambahkan status_label
                $row->status_label = $row->status === 'gradedright' ? 'Benar' : 'Salah';
            }

        } catch (\Throwable $e) {
            Log::error('Error fetching student scores: ' . $e->getMessage());
            $data = [];
        }

        return view('students.scores', compact('data'));
    }
}
