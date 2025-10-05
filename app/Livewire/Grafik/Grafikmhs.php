<?php

namespace App\Livewire\Grafik;

use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Grafikmhs extends Component
{
    public function render()
    {
        // === DATA UTAMA: Jumlah Mahasiswa per Prodi ===
        $result = Mahasiswa::select('nama_program_studi', DB::raw('COUNT(*) as total'))
            ->groupBy('nama_program_studi')
            ->get();

        $seriesData = $result->map(function ($row) {
            return [
                'name'      => $row->nama_program_studi ?? 'Tidak Ada Prodi',
                'y'         => (int) $row->total,
                'drilldown' => $row->nama_program_studi,
            ];
        });

        // === DATA DRILLDOWN: Jumlah Mahasiswa per Angkatan ===
        $drilldownData = Mahasiswa::select('nama_program_studi', 'id_periode', DB::raw('COUNT(*) as total'))
            ->groupBy('nama_program_studi', 'id_periode')
            ->get()
            ->groupBy('nama_program_studi')
            ->map(function ($rows, $prodi) {
                return [
                    'name' => $prodi,
                    'id'   => $prodi,
                    'data' => $rows->map(function ($r) {
                        return [
                            (string) $r->id_periode,
                            (int) $r->total,
                        ];
                    })->values(),
                ];
            })
            ->values();

        // Gabungkan ke satu variabel
        $chartData = [
            'series' => [[
                'name' => 'Jumlah Mahasiswa',
                'colorByPoint' => true,
                'data' => $seriesData,
            ]],
            'drilldown' => [
                'series' => $drilldownData,
            ],
        ];
        return view('livewire.grafik.grafikmhs', [
            'chartData' => $chartData,
        ]);
    }
}
