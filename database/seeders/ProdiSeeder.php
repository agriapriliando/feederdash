<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    public function run(): void
    {
        $prodi = array(
            0 =>
            array(
                'id_prodi' => '04000824-8add-43c3-aab7-af27a4fe06cb',
                'kode_program_studi' => '87121',
                'nama_program_studi' => 'Pendidikan Musik Gereja',
                'status' => 'A',
                'id_jenjang_pendidikan' => '30',
                'nama_jenjang_pendidikan' => 'S1',
                'jenjang_nama_prodi' => 'S1 Pendidikan Musik Gereja',
            ),
            1 =>
            array(
                'id_prodi' => '0baee651-026b-4a18-b00f-82e74079145b',
                'kode_program_studi' => '86238',
                'nama_program_studi' => 'Manajemen Pendidikan Kristen',
                'status' => 'A',
                'id_jenjang_pendidikan' => '30',
                'nama_jenjang_pendidikan' => 'S1',
                'jenjang_nama_prodi' => 'S1 Manajemen Pendidikan Kristen',
            ),
            2 =>
            array(
                'id_prodi' => '0c2585c5-9d4b-4f14-86aa-1e81283b5c26',
                'kode_program_studi' => '77202',
                'nama_program_studi' => 'Misiologi',
                'status' => 'H',
                'id_jenjang_pendidikan' => '30',
                'nama_jenjang_pendidikan' => 'S1',
                'jenjang_nama_prodi' => 'S1 Misiologi',
            ),
            3 =>
            array(
                'id_prodi' => '1568c951-1d05-47be-b4b6-29cad50dd762',
                'kode_program_studi' => '95206',
                'nama_program_studi' => 'Kepemimpinan Kristen',
                'status' => 'A',
                'id_jenjang_pendidikan' => '30',
                'nama_jenjang_pendidikan' => 'S1',
                'jenjang_nama_prodi' => 'S1 Kepemimpinan Kristen',
            ),
            4 =>
            array(
                'id_prodi' => '1bdea44f-da22-4b2c-b479-4a6c94c78368',
                'kode_program_studi' => '70138',
                'nama_program_studi' => 'Manajemen Pendidikan Kristen',
                'status' => 'H',
                'id_jenjang_pendidikan' => '35',
                'nama_jenjang_pendidikan' => 'S2',
                'jenjang_nama_prodi' => 'S2 Manajemen Pendidikan Kristen',
            ),
            5 =>
            array(
                'id_prodi' => '664aa5b8-da52-46cf-b086-1d54c265a2d1',
                'kode_program_studi' => '86212',
                'nama_program_studi' => 'Pastoral Konseling',
                'status' => 'A',
                'id_jenjang_pendidikan' => '30',
                'nama_jenjang_pendidikan' => 'S1',
                'jenjang_nama_prodi' => 'S1 Pastoral Konseling',
            ),
            6 =>
            array(
                'id_prodi' => '684a59f3-af52-453b-aabd-202cd85044f0',
                'kode_program_studi' => '86013',
                'nama_program_studi' => 'Pendidikan Agama Kristen',
                'status' => 'A',
                'id_jenjang_pendidikan' => '40',
                'nama_jenjang_pendidikan' => 'S3',
                'jenjang_nama_prodi' => 'S3 Pendidikan Agama Kristen',
            ),
            7 =>
            array(
                'id_prodi' => '8d1fb143-1c27-481e-bed0-feda8aa0671f',
                'kode_program_studi' => '73204',
                'nama_program_studi' => 'Psikologi Kristen',
                'status' => 'A',
                'id_jenjang_pendidikan' => '30',
                'nama_jenjang_pendidikan' => 'S1',
                'jenjang_nama_prodi' => 'S1 Psikologi Kristen',
            ),
            8 =>
            array(
                'id_prodi' => '94d28e8f-3cb1-45b0-8346-13eb1df80206',
                'kode_program_studi' => '86225',
                'nama_program_studi' => 'Bimbingan dan Konseling Kristen',
                'status' => 'A',
                'id_jenjang_pendidikan' => '30',
                'nama_jenjang_pendidikan' => 'S1',
                'jenjang_nama_prodi' => 'S1 Bimbingan dan Konseling Kristen',
            ),
            9 =>
            array(
                'id_prodi' => '96dce625-6e71-4d37-ac10-7f4093613edb',
                'kode_program_studi' => '86236',
                'nama_program_studi' => 'Pendidikan Kristen Anak Usia Dini',
                'status' => 'A',
                'id_jenjang_pendidikan' => '30',
                'nama_jenjang_pendidikan' => 'S1',
                'jenjang_nama_prodi' => 'S1 Pendidikan Kristen Anak Usia Dini',
            ),
            10 =>
            array(
                'id_prodi' => 'a2ad42a4-3301-4ed9-9117-a5b63a553925',
                'kode_program_studi' => '86101',
                'nama_program_studi' => 'Pastoral Konseling',
                'status' => 'A',
                'id_jenjang_pendidikan' => '35',
                'nama_jenjang_pendidikan' => 'S2',
                'jenjang_nama_prodi' => 'S2 Pastoral Konseling',
            ),
            11 =>
            array(
                'id_prodi' => 'a3b29570-1c7b-4e32-983c-01913ab1df60',
                'kode_program_studi' => '77004',
                'nama_program_studi' => 'Teologi (Akademik)',
                'status' => 'H',
                'id_jenjang_pendidikan' => '40',
                'nama_jenjang_pendidikan' => 'S3',
                'jenjang_nama_prodi' => 'S3 Teologi (Akademik)',
            ),
            12 =>
            array(
                'id_prodi' => 'b24ac1b2-9dc1-43d2-a034-bb793844db8c',
                'kode_program_studi' => '88214',
                'nama_program_studi' => 'Seni Pertunjukan Keagamaan',
                'status' => 'A',
                'id_jenjang_pendidikan' => '30',
                'nama_jenjang_pendidikan' => 'S1',
                'jenjang_nama_prodi' => 'S1 Seni Pertunjukan Keagamaan',
            ),
            13 =>
            array(
                'id_prodi' => 'b46a4622-8598-4423-9a90-269da2d2ade1',
                'kode_program_studi' => '86113',
                'nama_program_studi' => 'Pendidikan Agama Kristen',
                'status' => 'A',
                'id_jenjang_pendidikan' => '35',
                'nama_jenjang_pendidikan' => 'S2',
                'jenjang_nama_prodi' => 'S2 Pendidikan Agama Kristen',
            ),
            14 =>
            array(
                'id_prodi' => 'b78bd7da-7a1a-488b-85e7-443eec80d9c2',
                'kode_program_studi' => '77201',
                'nama_program_studi' => 'Teologi (Akademik)',
                'status' => 'A',
                'id_jenjang_pendidikan' => '30',
                'nama_jenjang_pendidikan' => 'S1',
                'jenjang_nama_prodi' => 'S1 Teologi (Akademik)',
            ),
            15 =>
            array(
                'id_prodi' => 'ce532c30-b185-49ae-8de7-e633b5564af2',
                'kode_program_studi' => '86213',
                'nama_program_studi' => 'Pendidikan Agama Kristen',
                'status' => 'A',
                'id_jenjang_pendidikan' => '30',
                'nama_jenjang_pendidikan' => 'S1',
                'jenjang_nama_prodi' => 'S1 Pendidikan Agama Kristen',
            ),
            16 =>
            array(
                'id_prodi' => 'd79d737f-6cd7-4c74-a2ff-ae2d438aa30c',
                'kode_program_studi' => '77101',
                'nama_program_studi' => 'Teologi (Akademik)',
                'status' => 'A',
                'id_jenjang_pendidikan' => '35',
                'nama_jenjang_pendidikan' => 'S2',
                'jenjang_nama_prodi' => 'S2 Teologi (Akademik)',
            ),
            17 =>
            array(
                'id_prodi' => 'd813c0d0-8a3e-4f39-a57d-e838074908a8',
                'kode_program_studi' => '69202',
                'nama_program_studi' => 'Sosiologi Agama',
                'status' => 'A',
                'id_jenjang_pendidikan' => '30',
                'nama_jenjang_pendidikan' => 'S1',
                'jenjang_nama_prodi' => 'S1 Sosiologi Agama',
            ),
            18 =>
            array(
                'id_prodi' => 'e4e8746a-5b46-4ed5-8353-0b03783153ae',
                'kode_program_studi' => '91221',
                'nama_program_studi' => 'Musik Gereja',
                'status' => 'A',
                'id_jenjang_pendidikan' => '30',
                'nama_jenjang_pendidikan' => 'S1',
                'jenjang_nama_prodi' => 'S1 Musik Gereja',
            ),
        );
        DB::table('prodis')->delete();
        DB::table('prodis')->insert($prodi);
    }
}
