<?php

use App\Livewire\Grafik\Grafikmhs;
use App\Livewire\Mahasiswa\MahasiswaList;
use App\Livewire\Prodi\ProdiList;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', MahasiswaList::class)->name('mahasiswa.index');
Route::get('/prodi', ProdiList::class)->name('prodi.index');
Route::get('/grafik', Grafikmhs::class)->name('grafik.index');
