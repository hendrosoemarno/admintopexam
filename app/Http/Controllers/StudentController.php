<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        // Ambil semua user dengan role siswa (roleid 5)
        $students = DB::connection('moodle')
            ->table('user as u')
            ->join('role_assignments as ra', 'ra.userid', '=', 'u.id')
            ->where('ra.roleid', 5)
            ->select('u.id', 'u.firstname', 'u.lastname', 'u.email')
            ->orderBy('u.firstname')
            ->get();

        // Ambil semua data field Moodle (mapping shortname ke id)
        $fields = DB::connection('moodle')
            ->table('user_info_field')
            ->select('id', 'shortname')
            ->pluck('shortname', 'id');

        // Ambil semua data user_info_data
        $infoData = DB::connection('moodle')
            ->table('user_info_data')
            ->select('userid', 'fieldid', 'data')
            ->get();

        // Buat array userData[userid][shortname] = data
        $userData = [];
        foreach ($infoData as $item) {
            if (isset($fields[$item->fieldid])) {
                $userData[$item->userid][$fields[$item->fieldid]] = $item->data;
            }
        }

        return view('students.index', compact('students', 'userData'));
    }

    public function show($id)
    {
        $student = DB::connection('moodle')->table('user')->where('id', $id)->first();

        // Mapping field
        $fields = DB::connection('moodle')
            ->table('user_info_field')
            ->select('id', 'shortname', 'name')
            ->pluck('shortname', 'id');

        $infoData = DB::connection('moodle')
            ->table('user_info_data')
            ->where('userid', $id)
            ->get();

        $extra = [];
        foreach ($infoData as $item) {
            if (isset($fields[$item->fieldid])) {
                $extra[$fields[$item->fieldid]] = $item->data;
            }
        }

        return view('students.show', compact('student', 'extra'));
    }
}
