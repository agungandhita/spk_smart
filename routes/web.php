<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\DosenRegisterController;
use App\Http\Controllers\Auth\MahasiswaRegisterController;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;
use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;
use App\Http\Controllers\Dosen\ProfileController as DosenProfileController;
use App\Http\Controllers\mahasiswa\NilaiController;
use App\Http\Controllers\mahasiswa\ProfileController as MahasiswaProfileController;
use App\Http\Controllers\mahasiswa\PembimbingController as MahasiswaPembimbingController;
use App\Http\Controllers\dosen\PembimbingController as DosenPembimbingController;
use App\Http\Controllers\dosen\RekomendasiController as DosenRekomendasiController;
use App\Http\Controllers\mahasiswa\RekomendasiController as MahasiswaRekomendasiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    Route::get('/register', function() {
        return view('auth.register.choose');
    })->name('register');

    // Specific Registration Routes
    Route::get('/register/dosen', [DosenRegisterController::class, 'showRegistrationForm'])->name('dosen.register.form');
    Route::post('/register/dosen', [DosenRegisterController::class, 'register'])->name('dosen.register');

    Route::get('/register/mahasiswa', [MahasiswaRegisterController::class, 'showRegistrationForm'])->name('mahasiswa.register.form');
    Route::post('/register/mahasiswa', [MahasiswaRegisterController::class, 'register'])->name('mahasiswa.register');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Mahasiswa Routes
    Route::middleware(['role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])->name('dashboard');
        
        // Nilai Routes
        Route::resource('nilai', NilaiController::class);
        Route::get('/nilai/{nilai}/download', [NilaiController::class, 'downloadKhs'])->name('nilai.download');
        
        // Profile Routes
        Route::get('/profile', [MahasiswaProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [MahasiswaProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [MahasiswaProfileController::class, 'update'])->name('profile.update');
        
        // Pembimbing Routes
        Route::get('/pembimbing', [MahasiswaPembimbingController::class, 'index'])->name('pembimbing.index');
        Route::get('/pembimbing/create', [MahasiswaPembimbingController::class, 'create'])->name('pembimbing.create');
        Route::post('/pembimbing', [MahasiswaPembimbingController::class, 'store'])->name('pembimbing.store');
        Route::get('/pembimbing/{pengajuan}', [MahasiswaPembimbingController::class, 'show'])->name('pembimbing.show');
        Route::delete('/pembimbing/{pengajuan}', [MahasiswaPembimbingController::class, 'cancel'])->name('pembimbing.cancel');
        
        // Rekomendasi Routes
        Route::get('/rekomendasi', [MahasiswaRekomendasiController::class, 'index'])->name('rekomendasi.index');
        Route::get('/rekomendasi/{rekomendasi}', [MahasiswaRekomendasiController::class, 'show'])->name('rekomendasi.show');
        Route::get('/rekomendasi/{rekomendasi}/respond', [MahasiswaRekomendasiController::class, 'respond'])->name('rekomendasi.respond');
        Route::patch('/rekomendasi/{rekomendasi}/accept', [MahasiswaRekomendasiController::class, 'accept'])->name('rekomendasi.accept');
        Route::patch('/rekomendasi/{rekomendasi}/reject', [MahasiswaRekomendasiController::class, 'reject'])->name('rekomendasi.reject');
    });

    // Dosen Routes
    Route::middleware(['role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
        Route::get('/dashboard', [DosenDashboardController::class, 'index'])->name('dashboard');
        
        // Profile Routes
        Route::get('/profile', [DosenProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [DosenProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [DosenProfileController::class, 'update'])->name('profile.update');
        
        // Pembimbing Routes
        Route::get('/pembimbing', [DosenPembimbingController::class, 'index'])->name('pembimbing.index');
        Route::get('/pembimbing/{pengajuan}', [DosenPembimbingController::class, 'show'])->name('pembimbing.show');
        Route::get('/pembimbing/{pengajuan}/respond', [DosenPembimbingController::class, 'respond'])->name('pembimbing.respond');
        Route::post('/pembimbing/{pengajuan}/approve', [DosenPembimbingController::class, 'approve'])->name('pembimbing.approve');
        Route::post('/pembimbing/{pengajuan}/reject', [DosenPembimbingController::class, 'reject'])->name('pembimbing.reject');
        
        // Rekomendasi Routes
        Route::get('/rekomendasi', [DosenRekomendasiController::class, 'index'])->name('rekomendasi.index');
        Route::get('/rekomendasi/create/{mahasiswa?}', [DosenRekomendasiController::class, 'create'])->name('rekomendasi.create');
        Route::post('/rekomendasi', [DosenRekomendasiController::class, 'store'])->name('rekomendasi.store');
        Route::get('/rekomendasi/{rekomendasi}', [DosenRekomendasiController::class, 'show'])->name('rekomendasi.show');
        Route::patch('/rekomendasi/{rekomendasi}/send', [DosenRekomendasiController::class, 'send'])->name('rekomendasi.send');
        Route::delete('/rekomendasi/{rekomendasi}', [DosenRekomendasiController::class, 'destroy'])->name('rekomendasi.destroy');
        Route::post('/rekomendasi/auto-generate', [DosenRekomendasiController::class, 'autoGenerate'])->name('rekomendasi.auto-generate');
        Route::get('/rekomendasi/templates/{bidang}', [DosenRekomendasiController::class, 'getTemplates'])->name('rekomendasi.templates');
    });
});

// Admin Routes (existing routes)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Add existing admin routes here if any
});
