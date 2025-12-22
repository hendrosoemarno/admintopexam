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
    Route::get('/tryoutfull/{userid}/{courseid}', [StudentTryoutFullController::class, 'show'])->name('students.tryoutfull.show');
    Route::get('/tryout-data', [App\Http\Controllers\StudentTryoutDataController::class, 'index'])->name('students.tryout_data');

    // Data Try Out Lengkap (Checklist)
    Route::get('/tryout-complete', [App\Http\Controllers\StudentTryoutCompleteController::class, 'index'])->name('students.tryout_complete');
    Route::post('/tryout-complete/toggle', [App\Http\Controllers\StudentTryoutCompleteController::class, 'toggleStatus'])->name('students.tryout_complete.toggle');

    Route::get('/{id}', [StudentController::class, 'show'])->name('students.show');
});

// Temporary route to create table if migration fails via CLI
Route::get('/setup-db-report-status', function () {
    try {
        if (!Illuminate\Support\Facades\Schema::hasTable('report_statuses')) {
            Illuminate\Support\Facades\Schema::create('report_statuses', function (Illuminate\Database\Schema\Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('quiz_attempt_id')->unique();
                $table->boolean('is_report_created')->default(false);
                $table->timestamps();
            });
            return "Table 'report_statuses' created successfully.";
        }
        return "Table 'report_statuses' already exists.";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});
