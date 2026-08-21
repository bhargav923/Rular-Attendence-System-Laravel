<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

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
        Route::get('/student/{id}/idcard', [StudentController::class, 'idcard'])->name('student.idcard');
        Route::get('/student/{id}/gidcard', [StudentController::class, 'gidcard'])->name('student.gidcard');
        Route::get('/attendance/mark/{id}', [StudentController::class, 'markAttendance'])->name('attendance.mark');
    });


    // ----------------------------
    // ADMIN PANEL ROUTES
    // ----------------------------
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/schools', [AdminController::class, 'schools'])->name('admin.schools');
        Route::get('/schools/approve/{id}', [AdminController::class, 'approve'])->name('admin.schools.approve');
        Route::get('/schools/reject/{id}', [AdminController::class, 'reject'])->name('admin.schools.reject');
    });
});
