<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\MoodleLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentScoreController;
use App\Http\Controllers\StudentTryoutQuickController;
use App\Http\Controllers\StudentTryoutBasicController;
use App\Http\Controllers\StudentTryoutFullController;
use App\Http\Controllers\StudentTryoutWhatsappController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [MoodleLoginController::class, 'showLoginForm'])->name('moodle.login');
Route::post('/login', [MoodleLoginController::class, 'login'])->name('moodle.login.submit');
Route::get('/logout', [MoodleLoginController::class, 'logout'])->name('moodle.logout');

Route::middleware('moodle.auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
});

Route::prefix('packages')->name('packages.')->group(function () {
    Route::get('/', [App\Http\Controllers\PackageController::class, 'index'])->name('index');
});

Route::prefix('register')->name('register.')->group(function () {
    Route::get('/{package}', [App\Http\Controllers\RegistrationController::class, 'showForm'])->name('form');
    Route::post('/', [App\Http\Controllers\RegistrationController::class, 'submit'])->name('submit');
});

Route::prefix('payment')->name('payment.')->group(function () {
    Route::post('/callback', [App\Http\Controllers\PaymentController::class, 'callback'])->name('callback');
    Route::get('/finish', [App\Http\Controllers\PaymentController::class, 'finish'])->name('finish');
});

Route::middleware('moodle.auth')->prefix('settings')->name('settings.')->group(function () {
    Route::get('/', [App\Http\Controllers\SettingsController::class, 'index'])->name('index');
    Route::post('/packages', [App\Http\Controllers\SettingsController::class, 'storePackage'])->name('packages.store');
    Route::put('/packages/{package}', [App\Http\Controllers\SettingsController::class, 'updatePackage'])->name('packages.update');
    Route::delete('/packages/{package}', [App\Http\Controllers\SettingsController::class, 'destroyPackage'])->name('packages.destroy');
    Route::post('/coupons', [App\Http\Controllers\SettingsController::class, 'storeCoupon'])->name('coupons.store');
    Route::put('/coupons/{coupon}', [App\Http\Controllers\SettingsController::class, 'updateCoupon'])->name('coupons.update');
    Route::delete('/coupons/{coupon}', [App\Http\Controllers\SettingsController::class, 'destroyCoupon'])->name('coupons.destroy');
    Route::post('/save', [App\Http\Controllers\SettingsController::class, 'saveSettings'])->name('save');
});

Route::prefix('students')->group(function () {
    Route::get('/', [StudentController::class, 'index'])->name('students.index');
    Route::get('/scores', [StudentScoreController::class, 'index'])->name('students.scores');
    Route::get('/tryoutquick', [StudentTryoutQuickController::class, 'index'])->name('students.tryoutquick');
    Route::get('/tryoutquick/{id}', [StudentTryoutQuickController::class, 'show'])->name('students.tryoutquick.report');
    Route::get('/tryoutbasic', [StudentTryoutBasicController::class, 'index'])->name('students.tryoutbasic');
    Route::get('/tryoutbasic/{id}', [StudentTryoutBasicController::class, 'show'])->name('students.tryoutbasic.report');
    Route::get('/tryoutfull', [StudentTryoutFullController::class, 'index'])->name('students.tryoutfull');
    Route::get('/tryoutfull/{userid}/{courseid}', [StudentTryoutFullController::class, 'show'])->name('students.tryoutfull.show');
    Route::get('/tryoutwhatsapp', [StudentTryoutWhatsappController::class, 'index'])->name('students.tryoutwhatsapp');
    Route::get('/tryoutwhatsapp/select/{userid}/{courseid}', [StudentTryoutWhatsappController::class, 'select'])->name('students.tryoutwhatsapp.select');
    Route::get('/tryoutwhatsapp/report/{id?}', [StudentTryoutWhatsappController::class, 'show'])->name('students.tryoutwhatsapp.report');

    // WA Report History
    Route::get('/tryoutwhatsapp/history', [StudentTryoutWhatsappController::class, 'history'])->name('students.tryoutwhatsapp.history');
    Route::post('/tryoutwhatsapp/store-report', [StudentTryoutWhatsappController::class, 'storeReport'])->name('students.tryoutwhatsapp.store_report');
    Route::post('/tryoutwhatsapp/update-report/{id}', [StudentTryoutWhatsappController::class, 'updateReport'])->name('students.tryoutwhatsapp.update_report');
    Route::delete('/tryoutwhatsapp/delete-report/{id}', [StudentTryoutWhatsappController::class, 'destroyReport'])->name('students.tryoutwhatsapp.delete_report');
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
Route::get('/check-siap-cols', function () {
    try {
        $cols = DB::connection('moodle')->select("SHOW COLUMNS FROM mdlax_siap");
        return response()->json($cols);
    } catch (\Exception $e) {
        return $e->getMessage();
    }
});
