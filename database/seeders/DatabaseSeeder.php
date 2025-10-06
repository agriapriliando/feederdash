<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Agri Apriliando',
        //     'email' => 'upttipdiaknpky@gmail.com',
        //     'password' => bcrypt('123'),
        // ]);
        $this->call([
            // ProdiSeeder::class,
            // MahasiswaSeeder::class,
        ]);
    }
}
