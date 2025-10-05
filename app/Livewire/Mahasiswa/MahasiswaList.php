<?php

namespace App\Livewire\Mahasiswa;

use App\Exports\MahasiswaExport;
use App\Helpers\Setting;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class MahasiswaList extends Component
{
    use WithPagination;
    public $search = '';
    public $searchProdi = '';
    public $perPage = 10;

    public $kolomcheck = [];
    public $kolomcheckopen = true;

    public $filterKustom = "";
    // public $filterKustom = "nama_program_studi = 'S1 Pendidikan Agama Kristen'";

    public $offset = 0;
    public $limit = 2;
    public $done = 0;
    public $total = 0;
    public $percent = 0;
    public $running = false;
    public $datanew = 0;
    public $dataold = 0;


    public function cekJumlah()
    {
        if ($this->searchProdi) {
            $this->filterKustom = "nama_program_studi = '" . $this->searchProdi . "'";
        }
        $setting = new Setting();
        $getMhs = $setting->getData(
            "GetListMahasiswa",
            '',
            $this->filterKustom
            // "nama_program_studi = 'S1 Pendidikan Agama Kristen' AND id_periode = '20241'"
        );

        if ($getMhs['jumlah'] == 0) {
            $this->reset();
            session()->flash('message', 'Gagal mengambil data dari Neo Feeder: ' . ($getMhs['error_msg'] ?? 'Isi Kolom Prodi dengan benar!'));
            return;
        }

        $all = $getMhs['data'] ?? [];
        // total di neo feeder
        $this->total = count($all);
        // total di database
        if ($this->searchProdi) {
            $this->done = Mahasiswa::where('nama_program_studi', $this->searchProdi)->count();
        } else {
            $this->done = Mahasiswa::count();
        }
        if ($this->done == $this->total) {
            session()->flash('message', 'Total Mahasiswa : ' . $this->total) . ' (Sudah lengkap, tidak perlu import)';
        } else {
            session()->flash('message', 'Total Mahasiswa di Neo Feeder: ' . $this->total . ', di Database: ' . $this->done . ' (Perlu import: ' . ($this->total - $this->done) . ')');
        }
    }

    public function startImport()
    {
        if ($this->searchProdi) {
            $this->filterKustom = "nama_program_studi = '" . $this->searchProdi . "'";
        }
        $setting = new Setting();
        $getMhs = $setting->getData(
            "GetListMahasiswa",
            '',
            $this->filterKustom
            // "nama_program_studi = 'S1 Pendidikan Agama Kristen'"
            // "nama_program_studi = 'S1 Pendidikan Agama Kristen' AND id_periode = '20241'"
        );

        if ($getMhs['jumlah'] == 0) {
            $this->reset();
            session()->flash('message', 'Gagal mengambil data dari Neo Feeder: ' . ($getMhs['error_msg'] ?? 'Isi Kolom Prodi dengan benar!'));
            return;
        }

        // --- Ambil semua data mahasiswa dari API ---
        $allApi = $getMhs['data'] ?? [];

        // --- Ambil semua data mahasiswa di DB yang sudah ada ---
        $localData = Mahasiswa::select('id_registrasi_mahasiswa', 'updated_at')
            ->get()
            ->keyBy('id_registrasi_mahasiswa'); // jadikan key id_registrasi_mahasiswa untuk akses cepat

        // --- Filter hanya data yang terbaru atau belum ada ---
        $filtered = collect($allApi)->filter(function ($item) use ($localData) { // item = satu data mahasiswa
            // cek apakah data sudah ada di DB
            $id = $item['id_registrasi_mahasiswa']; // gunakan id_registrasi_mahasiswa sebagai identifier unik
            $apiLastUpdate = isset($item['last_update']) ? Carbon::parse($item['last_update']) : null; // waktu last_update dari API

            if (!isset($localData[$id])) { // jika data belum ada di DB
                // data belum ada di DB → import
                return true;
            }

            $localUpdatedAt = $localData[$id]->updated_at ?? null; // waktu updated_at di DB
            if ($apiLastUpdate && $localUpdatedAt) { // jika kedua waktu ada
                return $apiLastUpdate->gt($localUpdatedAt); // jika API lebih baru
            }

            return false;
        })->values()->toArray();

        // --- Simpan hasil filter ke session ---
        if (empty($filtered)) {
            session()->flash('message', 'Tidak ada data baru untuk diimport.');
            return;
        }

        session(['all_mahasiswa' => $filtered]);

        $this->total = count($filtered);
        $this->offset = 0;
        $this->done = 0;
        $this->percent = 0;
        $this->running = true;
    }

    public function processBatch()
    {
        // if (!$this->running) return;

        $all = session('all_mahasiswa', []);
        // cek index pada array, offset selalu bertambah
        if (!isset($all[$this->offset])) {
            $this->running = false;
            session()->flash('message', 'Import selesai! Mahasiswa Ditambahkan: ' . $this->total . ' Orang. ');
            return;
        }

        $mhs = $all[$this->offset];
        if (Mahasiswa::where('id_registrasi_mahasiswa', $mhs['id_registrasi_mahasiswa'])->doesntExist()) {
            $setting = new Setting();
            $getBio = $setting->getData("GetBiodataMahasiswa", '1', "id_mahasiswa = '" . $mhs['id_mahasiswa'] . "'");
            $bio = $getBio['data'][0] ?? [];
            $data = array_merge($mhs, $bio);
            foreach (['tanggal_lahir', 'tanggal_keluar', 'tanggal_lahir_ayah', 'tanggal_lahir_ibu', 'tanggal_lahir_wali'] as $field) {
                if (!empty($data[$field])) {
                    try {
                        $data[$field] = Carbon::createFromFormat('d-m-Y', $data[$field])->format('Y-m-d');
                    } catch (\Exception $e) {
                        $data[$field] = null;
                    }
                }
            }

            Mahasiswa::updateOrCreate(['id_registrasi_mahasiswa' => $mhs['id_registrasi_mahasiswa']], $data);
            $this->datanew++;
        } else {
            $this->dataold++;
        }

        $this->done++;
        $this->offset++;
        $this->percent = $this->total > 0 ? round($this->done / $this->total * 100, 2) : 0;

        if ($this->done >= $this->total) {
            $this->running = false;
            session()->flash('message', 'Import selesai! Mahasiswa Ditambahkan: ' . $this->total . ' Orang. ');
        }
    }

    public function stopImport()
    {
        $this->running = false;
        session()->flash('message', 'Import dihentikan. Total yang diimport: ' . $this->done);
    }

    public function resetTable()
    {
        if ($this->kolomcheck) {
            Mahasiswa::destroy($this->kolomcheck);
            session()->flash('message', 'Data Mahasiswa yang dipilih telah hapus.');
            $this->kolomcheck = [];
            return;
        } else {
            Mahasiswa::truncate();
            session()->flash('message', 'Seluruh Data Mahasiswa telah direset.');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSearchProdi()
    {
        $this->resetPage();
    }

    public function deleteMahasiswa($id)
    {
        $mhs = Mahasiswa::find($id);
        if ($mhs) {
            $mhs->delete();
            session()->flash('message', 'Mahasiswa Nama ' . $mhs['nama_mahasiswa'] . ' | ' . $mhs['nim'] . ' telah dihapus.');
            $this->resetPage();
        } else {
            session()->flash('error', 'Mahasiswa Nama ' . $mhs['nama_mahasiswa'] . ' | ' . $mhs['nim']  . ' tidak ditemukan.');
        }
    }

    public function thisreset()
    {
        $this->reset();
        $this->resetPage();
    }

    public function exportexcel()
    {
        if ($this->searchProdi) {
            return (new MahasiswaExport($this->searchProdi))->download('mahasiswa_' . $this->searchProdi . '.xlsx');
        } else {
            return (new MahasiswaExport('all'))->download('mahasiswa_all.xlsx');
        }
    }

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
        return view('livewire.mahasiswa.mahasiswa-list', [
            'mahasiswa' => Mahasiswa::search($this->search)
                ->searchProdi($this->searchProdi)
                ->paginate($this->perPage),
            'prodis' => Prodi::orderBy('nama_program_studi')->get(),
            'chartData' => $chartData,
        ]);
    }
}
