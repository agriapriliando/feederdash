<?php

namespace App\Livewire\Prodi;

use App\Helpers\Setting;
use App\Models\Prodi;
use Livewire\Component;
use Livewire\WithPagination;

class ProdiList extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 10;

    public $offset = 0;
    public $limit = 2;
    public $done = 0;
    public $total = 0;
    public $percent = 0;
    public $running = false;

    public function cekJumlah()
    {
        $setting = new Setting();
        $getProdi = $setting->getData(
            "GetProdi",
            '',
            // "nama_program_studi = 'S1 Pendidikan Agama Kristen'"
            // "nama_program_studi = 'S1 Pendidikan Agama Kristen' AND id_periode = '20241'"
        );

        $all = $getProdi['data'] ?? [];
        $this->total = count($all);
        session()->flash('message', 'Total Prodi di Neo Feeder: ' . $this->total);
    }

    public function startImport()
    {
        $setting = new Setting();
        $getProdi = $setting->getData(
            "GetProdi",
            '',
            ""
        );

        $all = $getProdi['data'] ?? [];

        session(['all_prodi' => $all]);

        $this->total = count($all);
        $this->offset = 0;
        $this->done = 0;
        $this->percent = 0;
        $this->running = true;
    }

    public function stopImport()
    {
        $this->running = false;
        session()->flash('message', 'Import dihentikan. Total yang diimport: ' . $this->done);
    }

    public function processBatch()
    {
        if (!$this->running) return;

        $all = session('all_prodi', []);
        if (!isset($all[$this->offset])) {
            $this->running = false;
            session()->flash('message', 'Import selesai! Total: ' . $this->total);
            return;
        }

        $prodi = $all[$this->offset];
        $prodi['jenjang_nama_prodi'] = $prodi['nama_jenjang_pendidikan'] . ' ' . $prodi['nama_program_studi'];

        Prodi::updateOrCreate(['id_prodi' => $prodi['id_prodi']], $prodi);

        $this->done++;
        $this->offset++;
        $this->percent = $this->total > 0 ? round($this->done / $this->total * 100, 2) : 0;

        if ($this->done >= $this->total) {
            $this->running = false;
            session()->flash('message', 'Import selesai! Total prodi: ' . $this->total);
        }
    }

    public function resetTable()
    {
        Prodi::truncate();
        session()->flash('message', 'Data prodi telah direset.');
    }


    public function render()
    {
        return view('livewire.prodi.prodi-list', [
            'prodi' => Prodi::orderBy('status', 'asc')
                ->search($this->search)
                ->paginate($this->perPage),
        ]);
    }
}
