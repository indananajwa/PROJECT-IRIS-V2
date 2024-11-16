<?php

use Monolog\Registry;
use App\Http\Middleware\RegistFirst;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IrsController;
use App\Http\Controllers\KhsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AjuanRuangController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\BuatIrsController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/login',[LoginController::class,'index'])->name('login')->middleware('guest');
Route::post('/login',[LoginController::class,'authenticate']);

Route::get('dashboard', function() {
    if (auth()->user()->mhs == 1) {
        return app('App\Http\Controllers\DashboardController')->index();
    } else if (auth()->user()->ba == 1) {
        return app('App\Http\Controllers\RuangController')->dashboard();
    } else if (auth()->user()->dk == 1) {
        return view('dkDashboard');
    } else if (auth()->user()->kp == 1) {
        return view('kpDashboard');
    } else if (auth()->user()->pa == 1) {
        return view('paDashboard');
    }
    
})->name('dashboard')->middleware('auth');


Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('product/{product}/delete',[ProductsController::class,'destroy']);

Route::get('/maintenance',function(){
    return view('maintenance');
});
Route::get('/tes',function(){
    return view('tes');
});

//IRS
Route::get('/irs',[IrsController::class,'all']) -> name('irs');
Route::get('/irs/{id}/{email}',[IrsController::class,'index']);


//KHS
Route::get('/khs',[KhsController::class,'all']) -> name('khs');
Route::get('/khs/{id}',[KhsController::class,'index']);


//Transkrip
Route::get('m/transkrip', function () {
    return view('mhsTranskrip');
})->name('transkrip');
Route::get('m/make-irs', function () {
    return view('mhsBuatIrs');
})->name('transkrip');

//Buat IRS
Route::get('/buat-irs',[BuatIrsController::class,'index']) -> name('buat-irs')->middleware([RegistFirst::class]);
Route::post('/buat-irstest',[BuatIrsController::class,'createIrs']) -> name('buat-irstest');
Route::post('/viewirs',[BuatIrsController::class,'viewIrs']) -> name('viewirs');
Route::post('/deleteirs',[BuatIrsController::class,'deleteIrs']) -> name('deleteirs');

Route::get('/ajuanIrs', [BuatIrsController::class, 'index2'])->name('ajuanIrs');
Route::post('/irs/approve', [BuatIrsController::class, 'approve'])->name('irs.approve');
Route::post('/irs/reject', [BuatIrsController::class, 'reject'])->name('irs.reject');

//Registrasi
Route::get('m/registrasi', function () {
    return view('mhsRegistrasi');
})->name('registration');


//Ruang
Route::resource('/ruang', RuangController::class)->names([
    'index' => 'ruang',
]);
Route::get('/plotruang',[RuangController::class,'index2'])->name('plotruang');
Route::post('/plotruang/{id}',[RuangController::class,'editProdi']);
Route::get('/prodi',[RuangController::class,'plotProdi']);

Route::get('/ajuanRuang', [RuangController::class, 'index3'])->name('ajuanruang');
Route::post('/ruang/{id}/update-status', [RuangController::class, 'updateStatus'])->name('ruang.updateStatus');


//Jadwal
Route::get('/buatjadwal',[JadwalController::class,'index'])->name('buatjadwal');
Route::post('/buatjadwal/{id}',[JadwalController::class,'update']);
Route::post('/checkjadwal',[JadwalController::class,'isJadwalExist']);


Route::get('/ajuanJadwal', [JadwalController::class, 'index3'])->name('ajuanjadwal');
Route::post('/jadwal/approve', [JadwalController::class, 'approve'])->name('jadwal.approve');
Route::post('/jadwal/reject', [JadwalController::class, 'reject'])->name('jadwal.reject');

//Perwalian
Route::get('p/daftarmahasiswa', function () {
    $data = Mahasiswa::all(); // Ambil semua data mahasiswa dari model
    return view('paDaftarMahasiswa', compact('data')); // Kirim data ke view
})->name('daftarmahasiswa');

Route::get('p/irs/{id}', function ($id) {
    // Ambil data mahasiswa berdasarkan ID
    $mahasiswa = Mahasiswa::find($id);

    // Kirim data mahasiswa ke halaman IRS
    return view('paHalamanIRS', compact('mahasiswa'));
})->name('halamanIRS');

// Daftar Mahasiswa PA
Route::get('/paHalamanIRS/{id}', [IrsController::class, 'show'])->name('paHalamanIRS');
Route::post('/irs/save', [IrsController::class, 'save'])->name('irs.save');


Route::post('p/irs/{id}/approve', function ($id) {
    $mahasiswa = Mahasiswa::findOrFail($id);
    if ($mahasiswa->jadwal) {
        $mahasiswa->jadwal->status = 'Disetujui';
        $mahasiswa->jadwal->save();
    }
    return redirect()->route('daftarmahasiswa');
});

Route::get('/daftarmahasiswa', function () {
    return view('paDaftarMahasiswa'); // Ganti dengan nama view yang sesuai
})->name('paDaftarMahasiswa');

// Upload Tanda Tangan IRS
Route::post('/upload-irs', function (Request $request) {
    foreach ($request->file('file') as $file) {
        $filename = $file->getClientOriginalName(); // Ambil nama asli file
        $file->storeAs('irs_files', $filename, 'public'); // Simpan di folder public/irs_files
    }
    return response()->json(['success' => true]);
});

Route::get('/view-irs/{name}', function ($name) {
    $filePath = storage_path("app/public/irs_files/{$name}.pdf");

    if (file_exists($filePath)) {
        return response()->file($filePath);
    }

    abort(404, 'File tidak ditemukan');
});

Route::get('/irs/{id}', [IrsController::class, 'show'])->name('irs.show');
Route::post('irs/update-status/{id}', [IrsController::class, 'updateStatus'])->name('update-status-irs');
Route::get('/paHalamanIRS/{id}', [IrsController::class, 'show'])->name('paHalamanIRS');

// Menyetujui/Menolak IRS
Route::post('/irs/save', [IrsController::class, 'save'])->name('irs.save');

Route::get('/p/daftarmahasiswa', [IrsController::class, 'indexMahasiswa'])->name('daftarmahasiswa');

Route::get('/daftarmahasiswa', function() {
    $allApproved = Mahasiswa::where('irs_status', 'Disetujui')->get();
    return view('paDaftarMahasiswa', compact('allApproved'));
});


// Route::get('/daftarmahasiswa', [DaftarMahasiswaController::class, 'index'])->name('daftarmahasiswa');

Route::resource('/matakuliah', MatakuliahController::class)->names([
    'index' => 'matakuliah',
]);


Route::get('k/rombel', function () {
    return view('kpRombel');
})->name('rombel');


Route::get('/reviewjadwal',[JadwalController::class,'index2']);
Route::get('/reviewjadwal/{prodi}',[JadwalController::class,'reviewJadwalProdi']);

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');


Route::put('/ruang/{id}', [RuangController::class, 'update'])->name('ruang.update');

Route::delete('/plotruang/{id}', [RuangController::class, 'destroy'])->name('plotruang.destroy');
Route::delete('/pembuatan-ruang/{id}', [RuangController::class, 'destroyruang'])->name('ruang.destroyruang');

Route::post('/ruang', [RuangController::class, 'store'])->name('ruang.store');



