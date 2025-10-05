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
        Schema::create('prodis', function (Blueprint $table) {
            $table->uuid('id_prodi')->primary();
            $table->string('kode_program_studi', 20)->unique();
            $table->string('nama_program_studi');
            $table->char('status', 1)->default('H');
            $table->string('id_jenjang_pendidikan', 50);
            $table->string('nama_jenjang_pendidikan');
            $table->string('jenjang_nama_prodi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prodis');
    }
};
