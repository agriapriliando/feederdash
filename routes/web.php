<?php

use App\Http\Middleware\CheckCacheLogin;
use App\Livewire\Grafik\Grafikmhs;
use App\Livewire\Mahasiswa\MahasiswaList;
use App\Livewire\PageLogin;
use App\Livewire\Prodi\ProdiList;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', PageLogin::class)->name('login');
Route::middleware([CheckCacheLogin::class])->group(function () {
    Route::get('/logout', function () {
        Cache::forget('user_logged_in');
        return redirect()->route('login');
    })->name('logout');
    Route::get('/mahasiswa', MahasiswaList::class)->name('mahasiswa.index');
    Route::get('/prodi', ProdiList::class)->name('prodi.index');
    Route::get('/grafik', Grafikmhs::class)->name('grafik.index');
});
