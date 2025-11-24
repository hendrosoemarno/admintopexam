<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\MoodleLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentScoreController;
use App\Http\Controllers\StudentTryoutQuickController;
use App\Http\Controllers\StudentTryoutBasicController;
use App\Http\Controllers\StudentTryoutFullController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [MoodleLoginController::class, 'showLoginForm'])->name('moodle.login');
Route::post('/login', [MoodleLoginController::class, 'login'])->name('moodle.login.submit');
Route::get('/logout', [MoodleLoginController::class, 'logout'])->name('moodle.logout');

Route::get('/dashboard', function () {
    if (!session()->has('moodle_user')) {
        return redirect()->route('moodle.login');
    }
    $user = session('moodle_user');
    return view('dashboard', compact('user'));
})->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::prefix('students')->group(function () {
    Route::get('/', [StudentController::class, 'index'])->name('students.index');
    Route::get('/scores', [StudentScoreController::class, 'index'])->name('students.scores');
    Route::get('/tryoutquick', [StudentTryoutQuickController::class, 'index'])->name('students.tryoutquick');
    Route::get('/tryoutquick/{id}', [StudentTryoutQuickController::class, 'show'])->name('students.tryoutquick.report');
    Route::get('/tryoutbasic', [StudentTryoutBasicController::class, 'index'])->name('students.tryoutbasic');
    Route::get('/tryoutbasic/{id}', [StudentTryoutBasicController::class, 'show'])->name('students.tryoutbasic.report');
    Route::get('/tryoutfull', [StudentTryoutFullController::class, 'index'])->name('students.tryoutfull');
    Route::get('/tryoutfull/{userid}/{courseid}', [StudentTryoutFullController::class, 'show'] )->name('students.tryoutfull.show');
    Route::get('/{id}', [StudentController::class, 'show'])->name('students.show');
});
