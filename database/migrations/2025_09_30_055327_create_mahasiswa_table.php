<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mahasiswa');
            $table->char('jenis_kelamin', 1)->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();

            $table->uuid('id_mahasiswa');

            $table->string('nama_agama')->nullable();

            $table->uuid('id_prodi')->nullable();
            $table->string('nama_program_studi')->nullable();

            $table->string('id_status_mahasiswa')->nullable();
            $table->string('nama_status_mahasiswa')->nullable();

            $table->string('nim')->nullable();
            $table->string('id_periode')->nullable();
            $table->string('nama_periode_masuk')->nullable();

            $table->uuid('id_registrasi_mahasiswa')->nullable();
            $table->string('id_periode_keluar')->nullable();
            $table->date('tanggal_keluar')->nullable();

            $table->string('nik')->nullable();
            $table->string('nisn')->nullable();
            $table->string('npwp')->nullable();

            $table->string('id_negara', 10)->nullable();
            $table->string('kewarganegaraan')->nullable();

            $table->text('jalan')->nullable();
            $table->string('dusun')->nullable();
            $table->string('rt', 10)->nullable();
            $table->string('rw', 10)->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('id_wilayah')->nullable();
            $table->string('nama_wilayah')->nullable();

            $table->string('id_jenis_tinggal')->nullable();
            $table->string('nama_jenis_tinggal')->nullable();
            $table->string('id_alat_transportasi')->nullable();
            $table->string('nama_alat_transportasi')->nullable();

            $table->string('telepon')->nullable();
            $table->string('handphone')->nullable();
            $table->string('email')->nullable();

            $table->boolean('penerima_kps')->default(false);
            $table->string('nomor_kps')->nullable();

            // Data Ayah
            $table->string('nik_ayah')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->date('tanggal_lahir_ayah')->nullable();
            $table->string('id_pendidikan_ayah')->nullable();
            $table->string('nama_pendidikan_ayah')->nullable();
            $table->integer('id_pekerjaan_ayah')->nullable();
            $table->string('nama_pekerjaan_ayah')->nullable();
            $table->integer('id_penghasilan_ayah')->nullable();
            $table->string('nama_penghasilan_ayah')->nullable();

            // Data Ibu
            $table->string('nik_ibu')->nullable();
            $table->string('nama_ibu_kandung')->nullable();
            $table->date('tanggal_lahir_ibu')->nullable();
            $table->string('id_pendidikan_ibu')->nullable();
            $table->string('nama_pendidikan_ibu')->nullable();
            $table->integer('id_pekerjaan_ibu')->nullable();
            $table->string('nama_pekerjaan_ibu')->nullable();
            $table->integer('id_penghasilan_ibu')->nullable();
            $table->string('nama_penghasilan_ibu')->nullable();

            // Data Wali
            $table->string('nama_wali')->nullable();
            $table->date('tanggal_lahir_wali')->nullable();
            $table->string('id_pendidikan_wali')->nullable();
            $table->string('nama_pendidikan_wali')->nullable();
            $table->integer('id_pekerjaan_wali')->nullable();
            $table->string('nama_pekerjaan_wali')->nullable();
            $table->integer('id_penghasilan_wali')->nullable();
            $table->string('nama_penghasilan_wali')->nullable();

            // Kebutuhan Khusus
            $table->integer('id_kebutuhan_khusus_mahasiswa')->nullable();
            $table->string('nama_kebutuhan_khusus_mahasiswa')->nullable();

            // Status
            $table->string('status_sync')->nullable();
            $table->text('keterangan')->nullable();

            // Kolom PTKK
            $table->string('ptkk')->nullable();
            $table->string('provinsi_ptkk')->nullable();
            $table->string('kabupaten_kota_ptkk')->nullable();
            $table->string('alamat')->nullable();
            $table->string('status_ptkk')->nullable();

            // Kolom KIP
            $table->string('status_kip')->nullable();
            $table->string('nomor_kip')->nullable();
            $table->year('tahun_angkatan_kip')->nullable();
            $table->year('tahun_anggaran_kip')->nullable();
            $table->string('status_penerima_kip')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
