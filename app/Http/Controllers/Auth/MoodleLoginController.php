<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MoodleUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

use App\Helpers\MoodlePasswordHelper;

class MoodleLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.moodle_login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = MoodleUser::where('username', $request->username)->first();

        if ($user && MoodlePasswordHelper::verifyMoodlePassword($request->password, $user->password)) {
            Session::put('moodle_user', [
                'id' => $user->id,
                'username' => $user->username,
                'fullname' => $user->firstname . ' ' . $user->lastname,
                'email' => $user->email,
            ]);

            return redirect()->route('dashboard');
        }


        return back()->withErrors(['login' => 'Username atau password salah.']);
    }

    public function logout()
    {
        Session::forget('moodle_user');
        return redirect()->route('moodle.login');
    }
}
