<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class MahasiswaExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;

    public $nama_program_studi;
    protected $rowNumber = 0;

    // 🛑 Kolom yang tidak mau disertakan
    protected $excludedColumns = [
        // Identitas umum
        'id',
        'id_prodi',
        'id_periode',
        'id_jenis_kelamin',

        // Alamat & kontak
        'nama_wilayah',
        'nama_jenis_tinggal',
        'nama_alat_transportasi',
        'penerima_kps',
        'nomor_kps',

        // Data Ayah
        'nik_ayah',
        'nama_ayah',
        'tanggal_lahir_ayah',
        'nama_pendidikan_ayah',
        'nama_pekerjaan_ayah',
        'nama_penghasilan_ayah',

        // Data Ibu
        'nik_ibu',
        'tanggal_lahir_ibu',
        'nama_pendidikan_ibu',
        'nama_pekerjaan_ibu',
        'nama_penghasilan_ibu',

        // Data Wali
        'nama_wali',
        'tanggal_lahir_wali',
        'nama_pendidikan_wali',
        'nama_pekerjaan_wali',
        'nama_penghasilan_wali',

        // Kebutuhan khusus
        'nama_kebutuhan_khusus_mahasiswa',

        'created_at',
        'updated_at',
    ];

    public function __construct($nama_program_studi)
    {
        $this->nama_program_studi = $nama_program_studi;
    }

    public function query()
    {
        $columns = Schema::getColumnListing('mahasiswa');

        // Hapus kolom yang mengandung 'id' atau ada di daftar excluded
        $filtered = collect($columns)
            ->reject(function ($col) {
                return Str::contains($col, 'id') || in_array($col, $this->excludedColumns);
            })
            ->values()
            ->toArray();

        $query = Mahasiswa::select($filtered);

        if ($this->nama_program_studi != 'all') {
            $query->where('nama_program_studi', $this->nama_program_studi);
        }

        return $query;
    }

    public function headings(): array
    {
        $columns = Schema::getColumnListing('mahasiswa');

        $filtered = collect($columns)
            ->reject(function ($col) {
                return Str::contains($col, 'id') || in_array($col, $this->excludedColumns);
            });

        $titles = $filtered->map(function ($col) {
            return Str::of($col)->replace('_', ' ')->title();
        })->toArray();

        return array_merge(['No'], $titles);
    }

    public function map($row): array
    {
        $this->rowNumber++;

        $data = collect($row->toArray())
            ->reject(function ($value, $key) {
                return Str::contains($key, 'id') || in_array($key, $this->excludedColumns);
            })
            ->values()
            ->toArray();

        return array_merge([$this->rowNumber], $data);
    }
}
