<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\CollapseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\LaporanBulananController;
use App\Http\Controllers\LaporanHarian;
use App\Http\Controllers\MahasiswaAdminController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\SuperAdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['logged']], function(){
    Route::get('/', [HomeController::class, 'index']);
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('login/store', [AuthController::class, 'store']);

    Route::post('/pea', [AuthController::class, 'pea']);
});

Route::group(['middleware' => ['auth','accessSuperAdmin']], function(){
    Route::get('super-admin', [SuperAdminController::class, 'index']);
    Route::get('super-admin/ambil-data', [SuperAdminController::class, 'ambilData']);
    Route::get('super-admin/detail/{id}', [SuperAdminController::class, 'detail']);
    Route::post('super-admin/tambah', [SuperAdminController::class, 'tambah']);
    Route::post('super-admin/edit/{id}', [SuperAdminController::class, 'edit']);
    Route::delete('super-admin/hapus/{id}', [SuperAdminController::class, 'hapus']);
});

Route::group(['middleware' => ['auth','accessAdmin']], function(){
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::get('dashboard/ambilData', [DashboardController::class, 'ambilData']);
    
    Route::get('mahasiswa-admin', [MahasiswaAdminController::class, 'index']);
    Route::post('mahasiswa-admin/tambah', [MahasiswaAdminController::class, 'tambah']);
    Route::get('mahasiswa-admin/detail/{id}', [MahasiswaAdminController::class, 'detail']);
    Route::post('mahasiswa-admin/edit/{id}', [MahasiswaAdminController::class, 'edit']);
    Route::delete('mahasiswa-admin/hapus/{id}', [MahasiswaAdminController::class, 'hapus']);

    Route::get('buku', [BukuController::class, 'index']);
    Route::post('buku/tambah', [BukuController::class, 'tambah']);
    Route::get('buku/detail/{id}', [BukuController::class, 'detail']);
    Route::post('buku/edit/{id}', [BukuController::class, 'edit']);
    Route::delete('buku/hapus/{id}', [BukuController::class, 'hapus']);

    Route::get('jurusan', [JurusanController::class, 'index']);
    Route::get('jurusan/ambilData', [JurusanController::class, 'ambilData']);
    Route::post('jurusan/tambah', [JurusanController::class, 'tambah']);
    Route::delete('jurusan/hapus/{id}', [JurusanController::class, 'hapus']);

    Route::get('collapse', [CollapseController::class, 'index']);
    Route::get('collapse/ambil', [CollapseController::class, 'ambilData']);
    Route::get('collapse/detail/{id}', [CollapseController::class, 'detail']);
    Route::post('collapse/kembalikan/{id}', [CollapseController::class, 'kembalikan']);

    Route::get('laporan-harian', [LaporanHarian::class, 'index']);
    Route::get('laporan-harian/excel', [LaporanHarian::class, 'exportExcel']);
    Route::get('laporan-harian/pdf', [LaporanHarian::class, 'exportPdf']);

    Route::get('laporan-bulanan', [LaporanBulananController::class, 'index']);
    Route::get('laporan-bulanan/excel', [LaporanBulananController::class, 'exportExcel']);
    Route::get('laporan-bulanan/pdf', [LaporanBulananController::class, 'exportPdf']);

    Route::get('transaksi', [TransaksiController::class, 'index']);
    Route::get('transaksi/{id}', [TransaksiController::class, 'detail']);
    Route::patch('transaksi/{id}', [TransaksiController::class, 'kembalikan']);
    Route::patch('transaksi/perpanjang/{id}', [TransaksiController::class, 'perpanjang']);
    Route::get('transaksi-ambil-data', [TransaksiController::class, 'ambilData']);
    Route::get('transaksi-tambah', [TransaksiController::class, 'viewTambah']);
    Route::post('transaksi-tambah/tambah', [TransaksiController::class, 'tambahBuku']);
    Route::get('transaksi-tambah/tampil/{kode}', [TransaksiController::class, 'tampilBuku']);
    Route::delete('transaksi-tambah/hapus/{id}/{kode_buku}/{kode_transaksi}', [TransaksiController::class, 'hapusBuku']);
    Route::post('transaksi-tambah/update/{kode}', [TransaksiController::class, 'updateTransaksi']);
});

Route::group(['middleware' => ['auth','accessMahasiswa']], function(){
    Route::get('mahasiswa', [MahasiswaController::class, 'index']); 
    Route::get('mahasiswa/data', [MahasiswaController::class, 'ambilData']); 
    Route::get('mahasiswa/detail/{id}', [MahasiswaController::class, 'detail']); 
});

Route::group(['middleware' => ['auth']], function(){
    Route::get('profil-dan-password', [ProfilController::class, 'index']);
    Route::post('ubah-password', [ProfilController::class, 'ubahPassword']);
    Route::get('logout', [AuthController::class, 'logout']);
});