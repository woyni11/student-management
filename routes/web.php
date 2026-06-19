<?php

use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\TeacherController as AdminTeacherController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\StudentPanel\DashboardController as StudentPanelController;
use App\Http\Controllers\Teacher\AttendanceController as TeacherAttendanceController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Teacher\GradeController as TeacherGradeController;
use App\Http\Controllers\Teacher\StudentController as TeacherStudentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Root: send the visitor to their dashboard, or to the login page.
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (Auth::check()) {
        return redirect(match (Auth::user()->role) {
            'admin' => route('admin.dashboard'),
            'teacher' => route('teacher.dashboard'),
            'student' => route('student.profile'),
            default => route('login'),
        });
    }

    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Auth routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('students', AdminStudentController::class);
    Route::resource('teachers', AdminTeacherController::class)->except(['show']);
    Route::resource('courses', AdminCourseController::class)->except(['show']);

    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{course}/attendance', [AdminReportController::class, 'attendance'])->name('reports.attendance');
    Route::get('/reports/{course}/grades', [AdminReportController::class, 'grades'])->name('reports.grades');
});

/*
|--------------------------------------------------------------------------
| Teacher routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');

    Route::get('/students', [TeacherStudentController::class, 'index'])->name('students.index');

    Route::get('/attendance', [TeacherAttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/create', [TeacherAttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendance', [TeacherAttendanceController::class, 'store'])->name('attendance.store');

    Route::get('/grades', [TeacherGradeController::class, 'index'])->name('grades.index');
    Route::get('/grades/create', [TeacherGradeController::class, 'create'])->name('grades.create');
    Route::post('/grades', [TeacherGradeController::class, 'store'])->name('grades.store');
    Route::get('/grades/{grade}/edit', [TeacherGradeController::class, 'edit'])->name('grades.edit');
    Route::put('/grades/{grade}', [TeacherGradeController::class, 'update'])->name('grades.update');
});

/*
|--------------------------------------------------------------------------
| Student routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/profile', [StudentPanelController::class, 'profile'])->name('profile');
    Route::get('/courses', [StudentPanelController::class, 'courses'])->name('courses');
    Route::get('/attendance', [StudentPanelController::class, 'attendance'])->name('attendance');
    Route::get('/grades', [StudentPanelController::class, 'grades'])->name('grades');
});
