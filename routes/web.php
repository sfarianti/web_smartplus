<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DokumentasiController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\PengumumanController; 
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EditProfilController;
use App\Http\Controllers\EditProfilAdminController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\ReportController;
use App\Exports\ActivitiesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ForgotPasswordController;
use Illuminate\Support\Str;



Route::get('/', function () { 
    return redirect('/login');
});

// Route::get('/', function () {
//     return redirect()->route('today.course');
// });

Route::get('/login', [LoginController::class, 'form'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/get-user-by-password', [LoginController::class, 'getUserByPassword']);

// Route::get('/register', [RegisterController::class, 'show'])->name('register');
// Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/register', [RegisterController::class, 'show'])->name('register');
// Register Action
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/dashboard/admin', [DashboardAdminController::class, 'index'])->name('dashboardAdmin');
Route::get('/dashboard/tentor', [DashboardController::class, 'index'])->name('dashboard');

// Dashboard setelah login berhasil
// Route::get('/dashboard/admin', function () {
//     return view('dashboardAdmin');
// })->name('dashboardAdmin');

Route::get('/course', [CourseController::class, 'index'])->name('course.index');
Route::get('/course/view', [CourseController::class, 'index'])->name('course.view');
Route::get('/today-course', [JadwalController::class, 'todayCourse'])->name('today.course'); 
Route::get('/monthly-course', [JadwalController::class, 'monthlyCourse'])->name('monthly.course');
Route::get('/history-course', [JadwalController::class, 'history'])->name('history.course');
Route::get('/report', [ReportController::class, 'report'])->name('report');
Route::get('/course/create', [CourseController::class, 'create'])->name('course.create'); 
Route::post('/course/store', [CourseController::class, 'store'])->name('course.store'); 
Route::get('/course/edit/{id_kursus}', [CourseController::class, 'edit'])->name('course.edit'); 
Route::put('/course/update/{id_kursus}', [CourseController::class, 'update'])->name('course.update'); 
Route::delete('/course/{id_kursus}', [CourseController::class, 'destroy'])->name('course.destroy');

Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
Route::get('/pengumuman/create', [PengumumanController::class, 'create'])->name('pengumuman.create');
Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');
Route::get('/pengumuman/{id}/edit', [PengumumanController::class, 'edit'])->name('pengumuman.edit');
Route::put('/pengumuman/{id}', [PengumumanController::class, 'update'])->name('pengumuman.update');
Route::delete('/pengumuman/{id}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');

Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
Route::get('/jadwal/{id_jadwal}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
Route::put('/jadwal/{id_jadwal}', [JadwalController::class, 'update'])->name('jadwal.update');
Route::delete('/jadwal/{id_jadwal}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
Route::get('jadwal', [JadwalController::class, 'index'])->name('jadwal.index');


Route::get('/profile/edit', [EditProfilController::class, 'edit'])->name('profile.edit');
Route::post('/profile/update', [EditProfilController::class, 'updateProfile'])->name('profile.update');
Route::get('/profileadmin/edit', [EditProfilAdminController::class, 'edit'])->name('profileadmin.edit');
Route::post('/profileadmin/update', [EditProfilAdminController::class, 'updateProfile'])->name('profileadmin.update');

// Course actions
Route::post('/course/mulai/{id}', [JadwalController::class, 'startCourse'])->name('course.start');
// Route::post('/course/finish/{id}', [JadwalController::class, 'finishCourse'])->name('course.finish');
// Tambahkan route untuk start (mulai)
Route::post('/jadwals/{jadwal}/mulai', [JadwalController::class, 'start'])->name('jadwals.start');

// // Route::get('/dokumentasi/create', [DokumentasiController::class, 'create'])->name('dokumentasi');  
// Route::get('/dokumentasi/create/{jadwal}', [DokumentasiController::class, 'create'])->name('dokumentasi.create');
// Route::post('/dokumentasi/store', [DokumentasiController::class, 'store'])->name('dokumentasi.store'); 

// Selesai course (dipakai tombol SELESAI → langsung ke dokumentasi)
Route::post('/jadwals/{jadwal}/complete', [JadwalController::class, 'complete'])->name('jadwals.complete');
Route::post('/dokumentasi/create/{jadwal}', [DokumentasiController::class, 'create'])->name('dokumentasi.create');
Route::post('/dokumentasi/store', [DokumentasiController::class, 'store'])->name('dokumentasi.store');

Route::get('/myschedule', [JadwalController::class, 'mySchedule'])->name('jadwals.myschedule');

//report
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/export', [ReportController::class, 'exportActivities'])->name('reports.export');
Route::get('/reports/autocomplete', [ReportController::class, 'autocomplete'])->name('reports.autocomplete');
Route::get('/export-activities', function () {
    return Excel::download(new ActivitiesExport, 'activities.xlsx');
});

Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');


