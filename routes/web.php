<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;

Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});

Route::middleware(\App\Http\Middleware\SetLocale::class)->group(function() {
    // ----------------------------
    // Default home redirect - show register page for non-logged-in users
    Route::get('/', function () {
        if (session()->has('school')) {
            return redirect('/dashboard');
        }
        return redirect('/register');
    });


    // ----------------------------
    // AUTH ROUTES (Principal Login/Register)
    // ----------------------------
    // Principal Registration
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Principal Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Logout
    Route::get('/logout', [AuthController::class, 'logout']);


    // ----------------------------
    // PROTECTED ROUTES (Only for logged-in principals)
    // ----------------------------
    Route::middleware('school.auth')->group(function () {
        
        // Dashboard
        Route::get('/dashboard', function () {
            $school = session('school');
            return view('dashboard', compact('school'));
        });
        
        // Student Routes
        Route::get('/student/register', [StudentController::class, 'register'])->name('student.register');
        Route::post('/student/store', [StudentController::class, 'store'])->name('student.store');
        Route::get('/students', [StudentController::class, 'index'])->name('students.index');
        Route::get('/student/{id}', [StudentController::class, 'show'])->name('student.show');
        Route::get('/student/{id}/edit', [StudentController::class, 'edit'])->name('student.edit');
        Route::put('/student/{id}', [StudentController::class, 'update'])->name('student.update');
        Route::delete('/student/{id}', [StudentController::class, 'destroy'])->name('student.destroy');
        
        // Attendance Routes
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('/attendance/mark/{class}/{division}', [AttendanceController::class, 'markAttendance'])->name('attendance.mark');
        Route::post('/attendance/store', [AttendanceController::class, 'storeAttendance'])->name('attendance.store');
        Route::get('/attendance/history', [AttendanceController::class, 'history'])->name('attendance.history');
        Route::get('/attendance/view/{id}', [AttendanceController::class, 'viewAttendance'])->name('attendance.view');
    });


    // ----------------------------
    // ADMIN PANEL ROUTES
    // ----------------------------
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/schools', [AdminController::class, 'schools'])->name('admin.schools');
        Route::get('/schools/approve/{id}', [AdminController::class, 'approve'])->name('admin.schools.approve');
        Route::get('/schools/reject/{id}', [AdminController::class, 'reject'])->name('admin.schools.reject');
        Route::get('/schools/details/{id}', [AdminController::class, 'show'])->name('admin.schools.show');
        Route::get('/schools/edit/{id}', [AdminController::class, 'edit'])->name('admin.schools.edit');
        Route::put('/schools/{id}', [AdminController::class, 'update'])->name('admin.schools.update');
        Route::delete('/schools/{id}', [AdminController::class, 'destroy'])->name('admin.schools.destroy');
    });
});
