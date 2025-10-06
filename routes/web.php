<?php

use App\Http\Middleware\CheckCacheLogin;
use App\Livewire\Grafik\Grafikmhs;
use App\Livewire\Mahasiswa\MahasiswaList;
use App\Livewire\PageLogin;
use App\Livewire\Prodi\ProdiList;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

// fungsi untuk menampilkan data dalam format array PHP siap copy ke seeder untuk backup data awal
Route::get('/data/{jenisdata}', function ($jenisdata) {
    switch ($jenisdata) {
        case 'prodi':
            $model = Prodi::class;
            break;
        case 'mahasiswa':
            $model = Mahasiswa::class;
            break;
        default:
            abort(404, 'Data tidak ditemukan');
    }

    $alldata = $model::all()
        ->map(function ($item) {
            $array = $item->toArray();
            unset($array['created_at'], $array['updated_at']); // hapus kolom waktu
            return $array;
        })
        ->values()
        ->toArray();

    echo "<pre>";
    echo var_export($alldata, true);
    echo "</pre>";
    exit;
})->name('data');
// Route::get('/data', function () {
//     // ambil data awal
//     $setting = new Setting();
//     $getMhs = $setting->getData("GetListMahasiswa", "20", "");
//     foreach ($getMhs['data'] as $mhs) {
//         $getBio = $setting->getData("GetBiodataMahasiswa", '1', "id_mahasiswa = '" . $mhs['id_mahasiswa'] . "'");
//         $bio = $getBio['data'][0] ?? [];
//         // Gabungkan dua sumber data
//         $merged = array_merge($mhs, $bio);

//         // Pilih kolom penting untuk seeder
//         $dataall[] = [
//             'id_mahasiswa'           => $merged['id_mahasiswa'] ?? null,
//             'nim'                    => $merged['nim'] ?? $merged['nipd'] ?? null,
//             'nama_mahasiswa'         => $merged['nama_mahasiswa'] ?? null,
//             'jenis_kelamin'          => $merged['jenis_kelamin'] ?? null,
//             'tempat_lahir'           => $merged['tempat_lahir'] ?? null,
//             'tanggal_lahir'          => isset($merged['tanggal_lahir'])
//                 ? \Carbon\Carbon::parse(str_replace('/', '-', $merged['tanggal_lahir']))->format('Y-m-d')
//                 : null,
//             'id_prodi'               => $merged['id_prodi'] ?? null,
//             'nama_program_studi'     => $merged['nama_program_studi'] ?? null,
//             'id_status_mahasiswa'    => $merged['id_status_mahasiswa'] ?? null,
//             'nama_status_mahasiswa'  => $merged['nama_status_mahasiswa'] ?? null,
//             'id_periode_masuk'       => $merged['id_periode'] ?? null,
//             'nama_periode_masuk'     => $merged['nama_periode_masuk'] ?? null,
//             'id_periode_keluar'      => $merged['id_periode_keluar'] ?? null,
//             'tanggal_keluar'         => isset($merged['tanggal_keluar'])
//                 ? \Carbon\Carbon::parse(str_replace('/', '-', $merged['tanggal_keluar']))->format('Y-m-d')
//                 : null,
//             'id_agama'               => $merged['id_agama'] ?? null,
//             'nama_agama'             => $merged['nama_agama'] ?? null,
//             'nik'                    => $merged['nik'] ?? null,
//             'kewarganegaraan'        => $merged['kewarganegaraan'] ?? null,
//             'nama_wilayah'           => $merged['nama_wilayah'] ?? null,
//             'jalan'                  => $merged['jalan'] ?? null,
//             'dusun'                  => $merged['dusun'] ?? null,
//             'rt'                     => $merged['rt'] ?? null,
//             'rw'                     => $merged['rw'] ?? null,
//             'kelurahan'              => $merged['kelurahan'] ?? null,
//             'kode_pos'               => $merged['kode_pos'] ?? null,
//             'nama_jenis_tinggal'     => $merged['nama_jenis_tinggal'] ?? null,
//             'handphone'              => $merged['handphone'] ?? null,
//             'email'                  => $merged['email'] ?? null,
//             'ipk'                    => $merged['ipk'] ?? null,
//             'total_sks'              => $merged['total_sks'] ?? null,
//             'nama_ibu_kandung'       => $merged['nama_ibu_kandung'] ?? null,
//             'nama_ayah'              => $merged['nama_ayah'] ?? null,
//             'nama_wali'              => $merged['nama_wali'] ?? null,
//             'status_sync'            => $merged['status_sync'] ?? null,
//         ];
//     }
//     // tampilkan hasil dalam format array PHP siap copy ke seeder
//     echo "<pre>";
//     echo var_export($dataall, true);
//     echo "</pre>";
//     exit;
//     // dd($dataall);
// });
Route::get('/', function () {
    return redirect()->route('mahasiswa.index');
})->name('home');
Route::get('/login', PageLogin::class)->name('login');
Route::middleware([CheckCacheLogin::class])->group(function () {
    Route::get('/logout', function () {
        Cache::forget('user_logged_in');
        return redirect()->route('login');
    })->name('logout');
    Route::get('/mahasiswa', MahasiswaList::class)->name('mahasiswa.index');
    Route::get('/prodi', ProdiList::class)->name('prodi.index');
    Route::get('/grafik', Grafikmhs::class)->name('grafik.index');
});
