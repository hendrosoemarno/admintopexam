<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class StudentTryoutDataController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Default filter: Current Month
            $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
            $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

            // Convert to timestamp for Moodle
            $startTimestamp = Carbon::parse($startDate)->startOfDay()->timestamp;
            $endTimestamp = Carbon::parse($endDate)->endOfDay()->timestamp;

            $query = "
                SELECT
                    u.id AS userid,
                    c.id AS courseid,
                    qa2.id AS quizattemptsid,
                    CONCAT(u.firstname, ' ', u.lastname) AS nama_siswa,
                    c.fullname AS nama_course,
                    qz.name AS nama_quiz,
                    qa2.timestart AS tanggal_akses_ts
                FROM mdlax_quiz_attempts qa2
                JOIN mdlax_user u ON u.id = qa2.userid
                JOIN mdlax_quiz qz ON qz.id = qa2.quiz
                JOIN mdlax_course c ON c.id = qz.course
                WHERE qz.name LIKE '%Try Out%'
                  AND qa2.timestart BETWEEN ? AND ?
                ORDER BY qa2.timestart DESC
            ";

            $data = DB::connection('moodle')->select($query, [$startTimestamp, $endTimestamp]);

            foreach ($data as $row) {
                $row->tanggal_akses = Carbon::createFromTimestamp($row->tanggal_akses_ts)->format('d-m-Y H:i');
            }

        } catch (\Throwable $e) {
            Log::error('Error fetching Try Out Data: ' . $e->getMessage());
            $data = [];
        }

        return view('students.tryout_data', compact('data', 'startDate', 'endDate'));
    }
}
