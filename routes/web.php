<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DivisiController;
use App\Http\Controllers\Admin\KnowledgeBaseController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\PublicController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'divisi'])->name('public.divisi');
Route::get('/informasi', [PublicController::class, 'informasi'])->name('public.informasi');
Route::get('/syarat', [PublicController::class, 'syarat'])->name('public.syarat');
Route::get('/alur', [PublicController::class, 'alur'])->name('public.alur');

// 🔥 CHATBOT ROUTE
Route::get('/chatbot', [PublicController::class, 'chatbot'])->name('public.chatbot');

// 📊 DASHBOARD EVALUASI & PENGUJIAN CHATBOT (AKADEMIK / SKRIPSI)
Route::get('/evaluasi-chatbot', [\App\Http\Controllers\EvaluasiChatbotController::class, 'index'])->name('evaluasi.index');
Route::post('/evaluasi-chatbot/run-benchmark', [\App\Http\Controllers\EvaluasiChatbotController::class, 'runBenchmarkAjax'])->name('evaluasi.run');
Route::post('/evaluasi-chatbot/test-single', [\App\Http\Controllers\EvaluasiChatbotController::class, 'testSingleQuery'])->name('evaluasi.test-single');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Routes (Protected)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('divisi', DivisiController::class);
    Route::get('/divisi/cek-nama', [DivisiController::class, 'cekNama'])->name('divisi.cek-nama');
    
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::patch('/mahasiswa/{mahasiswa}/toggle-status', [MahasiswaController::class, 'toggleStatus'])
        ->name('mahasiswa.toggle-status');
    Route::get('/mahasiswa/cek-nim', [MahasiswaController::class, 'cekNim'])->name('mahasiswa.cek-nim');
    
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/export-page', [LaporanController::class, 'exportPage'])->name('export.page');
        Route::get('/export-pdf', [LaporanController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/export-excel', [LaporanController::class, 'exportExcel'])->name('export.excel');
    });

    Route::resource('knowledge-base', KnowledgeBaseController::class);
});