<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Load data dari file PHP
        $data = include database_path('datamahasiswa.php');

        // Bagi data menjadi potongan kecil (chunk)
        $chunks = array_chunk($data, 100); // 500 per batch agar tidak overload
        DB::table('mahasiswa')->delete(); // hapus dulu jika ada data sebelumnya
        DB::disableQueryLog();
        foreach ($chunks as $chunk) {
            DB::table('mahasiswa')->insert($chunk);
        }
    }
}
