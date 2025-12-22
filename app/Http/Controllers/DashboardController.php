<?php

namespace App\Http\Controllers;

use App\Models\MoodleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil semua siswa dan kursusnya
        // Roleid=5 → role student (default Moodle)
        $students = DB::connection('moodle')->table('user AS u')
            ->join('role_assignments AS ra', 'ra.userid', '=', 'u.id')
            ->join('context AS c', 'c.id', '=', 'ra.contextid')
            ->join('course AS co', 'co.id', '=', 'c.instanceid')
            ->where('ra.roleid', 5)
            ->select('u.id AS userid', 'u.firstname', 'u.lastname', 'u.email', 'co.fullname AS course', 'u.timecreated', 'u.lastaccess')
            ->orderBy('u.firstname')
            ->get();

        return view('dashboard.index', compact('students'));
    }
}
