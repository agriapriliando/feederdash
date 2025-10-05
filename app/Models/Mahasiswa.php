<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';

    protected $fillable = [
        'nama_mahasiswa',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',

        'id_mahasiswa',

        'nama_agama',

        'id_prodi',
        'nama_program_studi',

        'id_status_mahasiswa',
        'nama_status_mahasiswa',

        'nim',
        'id_periode',
        'nama_periode_masuk',

        'id_registrasi_mahasiswa',
        'id_periode_keluar',
        'tanggal_keluar',

        'nik',
        'nisn',
        'npwp',

        'id_negara',
        'kewarganegaraan',

        'jalan',
        'dusun',
        'rt',
        'rw',
        'kelurahan',
        'kode_pos',
        'id_wilayah',
        'nama_wilayah',

        'id_jenis_tinggal',
        'nama_jenis_tinggal',
        'id_alat_transportasi',
        'nama_alat_transportasi',

        'telepon',
        'handphone',
        'email',

        'penerima_kps',
        'nomor_kps',

        // Data Ayah
        'nik_ayah',
        'nama_ayah',
        'tanggal_lahir_ayah',
        'id_pendidikan_ayah',
        'nama_pendidikan_ayah',
        'id_pekerjaan_ayah',
        'nama_pekerjaan_ayah',
        'id_penghasilan_ayah',
        'nama_penghasilan_ayah',

        // Data Ibu
        'nik_ibu',
        'nama_ibu_kandung',
        'tanggal_lahir_ibu',
        'id_pendidikan_ibu',
        'nama_pendidikan_ibu',
        'id_pekerjaan_ibu',
        'nama_pekerjaan_ibu',
        'id_penghasilan_ibu',
        'nama_penghasilan_ibu',

        // Data Wali
        'nama_wali',
        'tanggal_lahir_wali',
        'id_pendidikan_wali',
        'nama_pendidikan_wali',
        'id_pekerjaan_wali',
        'nama_pekerjaan_wali',
        'id_penghasilan_wali',
        'nama_penghasilan_wali',

        // Kebutuhan Khusus
        'id_kebutuhan_khusus_mahasiswa',
        'nama_kebutuhan_khusus_mahasiswa',

        // Status
        'status_sync',
        'keterangan',

        // tambahan kolom PTKK
        'ptkk',
        'provinsi_ptkk',
        'kabupaten_kota_ptkk',
        'alamat',
        'status_ptkk',

        // tambahan kolom KIP
        'status_kip',
        'nomor_kip',
        'tahun_angkatan_kip',
        'tahun_anggaran_kip',
        'status_penerima_kip',
    ];

    protected $casts = [
        'tanggal_lahir'       => 'date:Y-m-d',
        'tanggal_keluar'      => 'date:Y-m-d',
        'tanggal_lahir_ayah'  => 'date:Y-m-d',
        'tanggal_lahir_ibu'   => 'date:Y-m-d',
        'tanggal_lahir_wali'  => 'date:Y-m-d',

        'penerima_kps'        => 'boolean',

        'id_penghasilan_ayah' => 'integer',
        'id_penghasilan_ibu'  => 'integer',
        'id_penghasilan_wali' => 'integer',

        'id_pekerjaan_ayah'   => 'integer',
        'id_pekerjaan_ibu'    => 'integer',
        'id_pekerjaan_wali'   => 'integer',

        'id_kebutuhan_khusus_mahasiswa' => 'integer',
    ];

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($q) use ($term) {
            $q->where('nama_mahasiswa', 'like', $term)
                ->orWhere('nim', 'like', $term);
        });
    }
    public function scopeSearchProdi($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($q) use ($term) {
            $q->where('nama_program_studi', 'like', $term);
        });
    }
}
