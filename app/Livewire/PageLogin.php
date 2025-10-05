<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.login')]
class PageLogin extends Component
{
    public $email = '';
    public $password = '';
    public $errorMessage = '';

    public function login()
    {
        if ($this->password == '177K@limantan') {
            // Simpan cache menandakan sudah login
            $cacheKey = 'user_logged_in';
            // Simpan nilai true dengan masa aktif 1 jam
            Cache::put($cacheKey, true, now()->addHour());

            return redirect()->route('mahasiswa.index');
        }

        session()->flash('errorMessage', 'Login gagal. Silakan coba lagi.');
    }

    public function logout()
    {
        Cache::forget('user_logged_in');
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.page-login');
    }
}
