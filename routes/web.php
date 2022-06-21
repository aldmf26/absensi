<?php

use App\Http\Controllers\AbsensiAgrilaras;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AbsensiRestoController;
use App\Http\Controllers\AbsensiSalonController;
use App\Http\Controllers\DaftarMenuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InputJqController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PemakaiController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\TabelAbsensiController;
use App\Http\Controllers\tabelAgrilaras;
use App\Http\Controllers\TabelRestoController;
use App\Http\Controllers\TabelSalonController;
use App\Http\Controllers\UserController;
use App\Models\Absensi_Agrilaras;
use Illuminate\Support\Facades\Route;

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

// route karyawan
Route::get('/karyawan',[KaryawanController::class,'index'])->name('karyawan')->middleware('auth');
Route::post('/karyawan',[KaryawanController::class,'addKaryawan'])->name('addKaryawan')->middleware('auth');
Route::patch('/karyawan',[KaryawanController::class,'editKaryawan'])->name('editKaryawan')->middleware('auth');
Route::post('/delete-karyawan',[KaryawanController::class,'deleteKaryawan'])->name('deleteKaryawan')->middleware('auth');
Route::get('/excelKaryawan',[KaryawanController::class,'excelKaryawan'])->name('excelKaryawan')->middleware('auth');
Route::get('/excelKaryawanAgrilaras',[KaryawanController::class,'excelKaryawanAgrilaras'])->name('excelKaryawanAgrilaras')->middleware('auth');
Route::post('/importKaryawan',[KaryawanController::class,'importKaryawan'])->name('importKaryawan')->middleware('auth');
// -----

// route karyawan agrilaras
Route::get('/karyawanAgrilaras',[KaryawanController::class,'karyawanAgrilaras'])->name('karyawanAgrilaras')->middleware('auth');
// -----

// route jenis pekerjaan
Route::get('/jenis',[JenisController::class,'index'])->name('jenis')->middleware('auth');
Route::post('/jenis',[JenisController::class,'addJenis'])->name('addJenis')->middleware('auth');
Route::patch('/jenis',[JenisController::class,'editJenis'])->name('editJenis')->middleware('auth');
Route::post('/delete-jenis',[jenisController::class,'deleteJenis'])->name('deleteJenis')->middleware('auth');
// -----

// route pemakai
Route::get('/shift',[ShiftController::class,'index'])->name('shift')->middleware('auth');
Route::post('/shift',[ShiftController::class,'addShift'])->name('addShift')->middleware('auth');
Route::patch('/shift',[ShiftController::class,'editShift'])->name('editShift')->middleware('auth');
Route::post('/delete-shift',[ShiftController::class,'deleteShift'])->name('deleteShift')->middleware('auth');
// -----

// route shift
Route::get('/pemakai',[PemakaiController::class,'index'])->name('pemakai')->middleware('auth');
Route::post('/pemakai',[PemakaiController::class,'addPemakai'])->name('addPemakai')->middleware('auth');
Route::patch('/pemakai',[PemakaiController::class,'editPemakai'])->name('editPemakai')->middleware('auth');
Route::post('/delete-pemakai',[PemakaiController::class,'deletePemakai'])->name('deletePemakai')->middleware('auth');
// -----

// route absensi anak laki
Route::get('/absensi',[AbsensiController::class,'index'])->name('absensi')->middleware('auth');
Route::get('/detail-absensi',[AbsensiController::class,'detailAbsensi'])->name('detailAbsensi')->middleware('auth');
Route::post('/absensi',[AbsensiController::class,'addAbsensi'])->name('addAbsensi')->middleware('auth');
Route::patch('/absensi',[AbsensiController::class,'editAbsensi'])->name('editAbsensi')->middleware('auth');
Route::post('/delete-absensi',[AbsensiController::class,'deleteAbsensi'])->name('deleteAbsensi')->middleware('auth');
Route::get('/excel',[AbsensiController::class,'excel'])->name('excel')->middleware('auth');
Route::get('/exportPertanggal',[AbsensiController::class,'exportPertanggal'])->name('exportPertanggal')->middleware('auth');
Route::get('/hapusPertanggal',[AbsensiController::class,'hapusPertanggal'])->name('hapusPertanggal')->middleware('auth');
// -----

// absensi resto
Route::get('/absensi_resto',[AbsensiRestoController::class,'detail_resto'])->name('absensi_resto')->middleware('auth');
Route::post('/input_resto',[AbsensiRestoController::class,'input_resto'])->name('input_resto')->middleware('auth');
Route::post('/update_resto',[AbsensiRestoController::class,'update_resto'])->name('update_resto')->middleware('auth');
Route::get('/delete_resto',[AbsensiRestoController::class,'delete_resto'])->name('delete_resto')->middleware('auth');
Route::get('/detail_resto',[AbsensiRestoController::class,'detail_resto'])->name('detail_resto')->middleware('auth');
Route::post('/add_resto',[AbsensiRestoController::class,'add_resto'])->name('add_resto')->middleware('auth');
Route::patch('/edit_resto',[AbsensiRestoController::class,'edit_resto'])->name('edit_resto')->middleware('auth');
Route::post('/delete_resto',[AbsensiRestoController::class,'delete_resto'])->name('delete_resto')->middleware('auth');
Route::get('/add_edit_resto',[AbsensiRestoController::class,'add_edit_resto'])->name('add_edit_resto')->middleware('auth');
// -----


// tabel resto
Route::get('/tabelResto',[TabelRestoController::class,'index'])->name('tabelResto')->middleware('auth');
// tabel salon
Route::get('/tabelSalon',[TabelSalonController::class,'index'])->name('tabelSalon')->middleware('auth');
// tabel agrilaras
Route::get('/tabelAgrilaras',[tabelAgrilaras::class,'index'])->name('tabelAgrilaras')->middleware('auth');

// absensi salon
Route::get('/absensi_salon',[AbsensiSalonController::class,'detail_salon'])->name('absensi_salon')->middleware('auth');
Route::post('/input_salon',[AbsensiSalonController::class,'input_salon'])->name('input_salon')->middleware('auth');
Route::get('/update_salon',[AbsensiSalonController::class,'update_salon'])->name('update_salon')->middleware('auth');
Route::get('/delete_salon',[AbsensiSalonController::class,'delete_salon'])->name('delete_salon')->middleware('auth');
Route::get('/detail_salon',[AbsensiSalonController::class,'detail_salon'])->name('detail_salon')->middleware('auth');
Route::post('/add_salon',[AbsensiSalonController::class,'add_salon'])->name('add_salon')->middleware('auth');
Route::patch('/edit_salon',[AbsensiSalonController::class,'edit_salon'])->name('edit_salon')->middleware('auth');
Route::post('/delete_salon',[AbsensiSalonController::class,'delete_salon'])->name('delete_salon')->middleware('auth');
Route::get('/add_edit_salon',[AbsensiSalonController::class,'add_edit_salon'])->name('add_edit_salon')->middleware('auth');
// -----

// absensi agrilaras
Route::get('/tabelAbsenM', [AbsensiAgrilaras::class, 'tabelAbsenM'])->name('tabelAbsenM')->middleware('auth');
Route::get('/addAbsenM', [AbsensiAgrilaras::class, 'addAbsenM'])->name('addAbsenM')->middleware('auth');
Route::post('/updateAbsenM', [AbsensiAgrilaras::class, 'updateAbsenM'])->name('updateAbsenM')->middleware('auth');
Route::post('/deleteAbsenM', [AbsensiAgrilaras::class, 'deleteAbsenM'])->name('deleteAbsenM')->middleware('auth');
Route::get('/absensi_agrilaras',[AbsensiAgrilaras::class,'detail_agrilaras'])->name('absensi_agrilaras')->middleware('auth');
Route::get('/downloadAbsAgri',[AbsensiAgrilaras::class,'downloadAbsAgri'])->name('downloadAbsAgri')->middleware('auth');
Route::get('/detail_agrilaras',[AbsensiAgrilaras::class,'detail_agrilaras'])->name('detail_agrilaras')->middleware('auth');
Route::post('/delete_agrilaras',[AbsensiAgrilaras::class,'delete_agrilaras'])->name('delete_agrilaras')->middleware('auth');
Route::post('/input_agrilaras',[AbsensiAgrilaras::class,'input_agrilaras'])->name('input_agrilaras')->middleware('auth');
Route::get('/ubah_bulan',[AbsensiAgrilaras::class,'ubah_bulan'])->name('ubah_bulan')->middleware('auth');
// -----

Route::get('/gajiAgrilaras',[AbsensiAgrilaras::class,'gajiAgrilaras'])->name('gajiAgrilaras')->middleware('auth');
Route::get('/exportGaji',[AbsensiAgrilaras::class,'exportGaji'])->name('exportGaji')->middleware('auth');


// Route User Permission
Route::get('/users',[UserController::class,'index'])->name('users')->middleware('auth');
Route::post('/users',[UserController::class,'addUser'])->name('addUser')->middleware('auth');
Route::patch('/users',[UserController::class,'editUser'])->name('editUser')->middleware('auth');
Route::post('/delete-users',[UserController::class,'deleteUser'])->name('deleteUser')->middleware('auth');
// -----

// route login
Route::get('/',[LoginController::class,'index'])->name('login');
Route::post('/askiLogin',[ LoginController::class,'aksiLogin'])->name('aksiLogin');
Route::get('/register',[LoginController::class,'register'])->name('register');
Route::post('/aksiReg',[LoginController::class,'aksiReg'])->name('aksiReg');
Route::get('/aksiLogout',[LoginController::class,'aksiLogout'])->name('aksiLogout');
// -----

// dashboard
Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');


Route::get('/menu',[MenuController::class,'index'])->name('menu');
Route::post('/menu',[MenuController::class,'tambahMenu'])->name('tambahMenu');

Route::get('/home',[HomeController::class,'index'])->name('home')->middleware('auth');
Route::get('/input',[InputJqController::class,'index'])->name('input');
Route::post('/simpan',[InputJqController::class,'simpan'])->name('simpan');

// Route::get('/', function () {
//     return view('welcome');
// });
