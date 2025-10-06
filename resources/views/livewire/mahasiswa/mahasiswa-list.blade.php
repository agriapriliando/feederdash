<div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12">
        <!-- ====== Chart Three Start -->
        <div class="space-y-5 sm:space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div>
                    @session('message')
                        <div class="px-5 py-4 sm:px-6 sm:py-5 text-center text-gray-50 bg-lime-600 rounded-t-2xl">
                            <span>{{ session('message') }}</span>
                        </div>
                    @endsession
                </div>
                <div wire:loading wire:target="cekJumlah" class="w-full px-5 py-2 sm:px-6 sm:py-4 text-center text-gray-50 bg-orange-400 rounded-t-2xl">
                    <span>Checking data... Harap tunggu.</span>
                </div>
                <div wire:loading wire:target="startImport" class="w-full px-5 py-2 sm:px-6 sm:py-4 text-center text-gray-50 bg-orange-400 rounded-t-2xl">
                    <span>Memproses data... Harap tunggu.</span>
                </div>
                <div wire:loading wire:target="exportexcel" class="w-full px-5 py-2 sm:px-6 sm:py-4 text-center text-gray-50 bg-orange-400 rounded-t-2xl">
                    <span>Memproses Excel... Harap tunggu.</span>
                </div>
                @if ($running)
                    <div @if ($running) wire:poll.1000ms="processBatch" @endif class="mt-4">
                        <div class="w-full px-5 py-2 sm:px-6 sm:py-4 text-center text-gray-50 bg-orange-400 rounded-t-2xl">
                            <span>Memproses data... Harap tunggu. Total : {{ $total }} Mahasiswa</span>
                        </div>
                        <div class="w-full bg-blue-700 rounded-full h-6 overflow-hidden">
                            <div class="h-6 bg-green-600 text-gray-200 text-center transition-all duration-300" style="width: {{ $percent }}%">
                                {{ $percent }}%
                            </div>
                            <small>{{ $done }} / {{ $total }} data selesai</small>
                        </div>
                    </div>
                @endif

                <div class="px-5 py-4 sm:px-6 sm:py-5 flex flex-wrap gap-2 justify-between">
                    <h3 class="font-medium text-gray-300">
                        Daftar Mahasiswa
                    </h3>
                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">Pilih Prodi sebelum Sinkron Data Neo Feeder, untuk sinkron per Prodi</p>
                    <!-- Elements -->
                    <div class="flex flex-wrap items-center gap-2" x-data="{ reset: false, openImport: false }">
                        <div class="flex flex-wrap items-center gap-2">
                            <button wire:click="exportexcel()" class="text-white flex items-center gap-2 me-2 pb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                <span>Excel</span>
                            </button>
                            <button wire:click="cekJumlah()" class="text-white flex items-center gap-2 me-2 pb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                                <span>Check</span>
                            </button>
                            <button x-show="!reset" @click="reset = true" class="text-white me-2 pb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                            <div class="flex" x-show="reset" x-transition @click.outside="reset = false">
                                @if ($kolomcheck == null)
                                    <button @click="reset = false" type="button" wire:click="resetTable()" class="text-red-400 pb-1 me-2 whitespace-nowrap">Ya Kosongkan Data</button>\
                                @else
                                    <button @click="reset = false" type="button" wire:click="resetTable()" class="text-red-400 pb-1 me-2 whitespace-nowrap">Hapus Data Dipilih</button>\
                                @endif
                                <button type="button" class="text-orange-400 pb-1 me-2" x-on:click="reset = false">Batalkan</button>
                            </div>
                            <button @click="openImport = true" x-show="!openImport" class="text-white flex items-center gap-2 me-2 pb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m6.75 12-3-3m0 0-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                                <span>Sinkron Neo</span>
                            </button>
                            <div class="flex" x-show="openImport" x-transition @click.outside="openImport = false">
                                <button @click="openImport = false" type="button" wire:click="startImport()" class="text-red-400 pb-1 me-2 whitespace-nowrap">Ya, Sinkron</button>
                                <button type="button" class="text-orange-400 pb-1 me-2" x-on:click="openImport = false">Batalkan</button>
                            </div>
                            @if ($running)
                                <button wire:click="stopImport()" class="text-white pb-1 me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            @endif
                            <a target="_blank" href="{{ route('data', ['jenisdata' => 'mahasiswa']) }}" class="text-white flex items-center gap-2 me-2 pb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m6.75 12-3-3m0 0-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                                <span>Backup Data</span>
                            </a>
                        </div>
                        <div class="flex flex-wrap md:flex-nowrap gap-2">
                            <input wire:model.live.debounce.500ms="search" placeholder="Cari Nama / NIM" type="text"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-8 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                            <div class="w-full">
                                {{-- filter prodi --}}
                                <div class="relative">
                                    <input {{ $running ? 'disabled' : '' }} wire:model.live="searchProdi" list="prodiList" id="prodiInput" placeholder="Pilih atau ketik Prodi..."
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-8 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-base text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                    <datalist id="prodiList">
                                        @foreach ($prodis as $item)
                                            <option value="{{ $item->jenjang_nama_prodi }}"></option>
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>
                            <div class="w-full">
                                {{-- filter status mahasiswa --}}
                                <div class="relative">
                                    <input {{ $running ? 'disabled' : '' }} wire:model.live="searchNamaStatusMahasiswa" list="statusMahasiswaList" id="statusMahasiswaInput"
                                        placeholder="Pilih atau ketik Status Mahasiswa..."
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-8 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-base text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                    <datalist id="statusMahasiswaList">
                                        @foreach ($namaStatusMahasiswaList as $status)
                                            <option value="{{ $status }}"></option>
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>

                        </div>
                        <button wire:click="thisreset()" class="text-white pb-1 me-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 0 0-3.7-3.7 48.678 48.678 0 0 0-7.324 0 4.006 4.006 0 0 0-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 0 0 3.7 3.7 48.656 48.656 0 0 0 7.324 0 4.006 4.006 0 0 0 3.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3-3 3" />
                            </svg>
                        </button>

                    </div>
                </div>
                <div class="p-5 border-t border-gray-100 dark:border-gray-800 sm:p-6">
                    <!-- ====== Table Six Start -->
                    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                        <div class="max-w-full overflow-x-auto">
                            <table class="min-w-full">
                                <!-- table header start -->
                                <thead>
                                    <tr class="border-b border-gray-100 dark:border-gray-800">
                                        <th class="px-5 py-3 sm:px-6 max-w-[50px]">
                                            <div class="flex items-center">
                                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                                    No
                                                </p>
                                            </div>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6">
                                            <div class="flex items-center">
                                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400 whitespace-nowrap">
                                                    Nama Mahasiswa | NIM
                                                </p>
                                            </div>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6">
                                            <div class="flex items-center">
                                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                                    Tempat, Tgl Lahir
                                                </p>
                                            </div>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6">
                                            <div class="flex items-center">
                                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                                    Angkatan
                                                </p>
                                            </div>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6">
                                            <div class="flex">
                                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                                    Prodi
                                                </p>
                                            </div>
                                        </th>
                                        <th class="px-5 py-3 sm:px-6">
                                            <div class="flex">
                                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                                    Status
                                                </p>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <!-- table header end -->
                                <!-- table body start -->
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                    @foreach ($mahasiswa as $item)
                                        <tr wire:key="mahasiswa-{{ $item->id }}">
                                            <td class="px-5 py-4 sm:px-6">
                                                <div class="flex items-center">
                                                    <input type="checkbox" class="me-2" value="{{ $item->id }}" wire:model.live="kolomcheck" />
                                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                                        {{ ($mahasiswa->currentPage() - 1) * $mahasiswa->perPage() + $loop->index + 1 }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4 sm:px-6">
                                                <div>
                                                    <span class="block font-medium text-gray-800 text-theme-sm dark:text-gray-400">
                                                        {{ $item->nama_mahasiswa }}
                                                    </span>
                                                    <span class="block text-gray-500 text-theme-xs dark:text-gray-400">
                                                        NIM {{ $item->nim }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4 sm:px-6">
                                                <div class="flex items-center">
                                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400 whitespace-nowrap">
                                                        {{ Str::title($item->tempat_lahir) }}, {{ $item->tanggal_lahir->format('d M Y') }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4 sm:px-6">
                                                <div class="flex items-center">
                                                    <p class="rounded-full bg-yellow-50 px-2 py-0.5 text-theme-xs font-medium text-black dark:bg-yellow-500/15 dark:text-white">
                                                        {{ $item->id_periode }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4 sm:px-6">
                                                <p class="text-gray-500 text-theme-sm dark:text-gray-400 whitespace-nowrap">
                                                    {{ $item->nama_program_studi }}
                                                </p>
                                            </td>
                                            <td class="px-5 py-4 sm:px-6">
                                                <div class="flex items-center">
                                                    <p class="rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-500">
                                                        {{ $item->nama_status_mahasiswa }}
                                                    </p>
                                                    <div class="flex flex-grow" x-data
                                                        ="{ openDelete: false }">
                                                        <button type="button" class="ms-2 text-red-400 text-theme-xs" @click="openDelete = !openDelete" x-show="!openDelete">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                            </svg>
                                                        </button>
                                                        <div class="flex" x-show="openDelete" x-transition @click.outside="openDelete = false">
                                                            <button @click="openDelete = false" type="button" wire:click="deleteMahasiswa({{ $item->id }})"
                                                                class="text-red-400 pb-1 me-2 whitespace-nowrap">Ya,
                                                                Hapus</button>
                                                            <button type="button" class="text-orange-400 pb-1 me-2" x-on:click="openDelete = false">Batalkan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                {{-- pagination --}}
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="px-5 py-3 sm:px-6">
                                            {!! $mahasiswa->links() !!}
                                        </td>
                                    </tr>
                            </table>
                        </div>
                    </div>
                    <!-- ====== Table Six End -->
                </div>
            </div>
        </div>
        <!-- ====== Chart Three End -->
    </div>
    <div class="hidden col-span-12 space-y-6">
        <!-- Metric Group One -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6">
            <!-- Metric Item Start -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                    <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M8.80443 5.60156C7.59109 5.60156 6.60749 6.58517 6.60749 7.79851C6.60749 9.01185 7.59109 9.99545 8.80443 9.99545C10.0178 9.99545 11.0014 9.01185 11.0014 7.79851C11.0014 6.58517 10.0178 5.60156 8.80443 5.60156ZM5.10749 7.79851C5.10749 5.75674 6.76267 4.10156 8.80443 4.10156C10.8462 4.10156 12.5014 5.75674 12.5014 7.79851C12.5014 9.84027 10.8462 11.4955 8.80443 11.4955C6.76267 11.4955 5.10749 9.84027 5.10749 7.79851ZM4.86252 15.3208C4.08769 16.0881 3.70377 17.0608 3.51705 17.8611C3.48384 18.0034 3.5211 18.1175 3.60712 18.2112C3.70161 18.3141 3.86659 18.3987 4.07591 18.3987H13.4249C13.6343 18.3987 13.7992 18.3141 13.8937 18.2112C13.9797 18.1175 14.017 18.0034 13.9838 17.8611C13.7971 17.0608 13.4132 16.0881 12.6383 15.3208C11.8821 14.572 10.6899 13.955 8.75042 13.955C6.81096 13.955 5.61877 14.572 4.86252 15.3208ZM3.8071 14.2549C4.87163 13.2009 6.45602 12.455 8.75042 12.455C11.0448 12.455 12.6292 13.2009 13.6937 14.2549C14.7397 15.2906 15.2207 16.5607 15.4446 17.5202C15.7658 18.8971 14.6071 19.8987 13.4249 19.8987H4.07591C2.89369 19.8987 1.73504 18.8971 2.05628 17.5202C2.28015 16.5607 2.76117 15.2906 3.8071 14.2549ZM15.3042 11.4955C14.4702 11.4955 13.7006 11.2193 13.0821 10.7533C13.3742 10.3314 13.6054 9.86419 13.7632 9.36432C14.1597 9.75463 14.7039 9.99545 15.3042 9.99545C16.5176 9.99545 17.5012 9.01185 17.5012 7.79851C17.5012 6.58517 16.5176 5.60156 15.3042 5.60156C14.7039 5.60156 14.1597 5.84239 13.7632 6.23271C13.6054 5.73284 13.3741 5.26561 13.082 4.84371C13.7006 4.37777 14.4702 4.10156 15.3042 4.10156C17.346 4.10156 19.0012 5.75674 19.0012 7.79851C19.0012 9.84027 17.346 11.4955 15.3042 11.4955ZM19.9248 19.8987H16.3901C16.7014 19.4736 16.9159 18.969 16.9827 18.3987H19.9248C20.1341 18.3987 20.2991 18.3141 20.3936 18.2112C20.4796 18.1175 20.5169 18.0034 20.4837 17.861C20.2969 17.0607 19.913 16.088 19.1382 15.3208C18.4047 14.5945 17.261 13.9921 15.4231 13.9566C15.2232 13.6945 14.9995 13.437 14.7491 13.1891C14.5144 12.9566 14.262 12.7384 13.9916 12.5362C14.3853 12.4831 14.8044 12.4549 15.2503 12.4549C17.5447 12.4549 19.1291 13.2008 20.1936 14.2549C21.2395 15.2906 21.7206 16.5607 21.9444 17.5202C22.2657 18.8971 21.107 19.8987 19.9248 19.8987Z"
                            fill="" />
                    </svg>
                </div>

                <div class="mt-5 flex items-end justify-between">
                    <div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Mahasiswa (NIM Terdaftar)</span>
                        <h4 class="mt-2 text-title-sm font-bold text-gray-800 dark:text-white/90">
                            1000
                        </h4>
                    </div>
                </div>
            </div>
            <!-- Metric Item End -->

            <!-- Metric Item Start -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                    <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M11.665 3.75621C11.8762 3.65064 12.1247 3.65064 12.3358 3.75621L18.7807 6.97856L12.3358 10.2009C12.1247 10.3065 11.8762 10.3065 11.665 10.2009L5.22014 6.97856L11.665 3.75621ZM4.29297 8.19203V16.0946C4.29297 16.3787 4.45347 16.6384 4.70757 16.7654L11.25 20.0366V11.6513C11.1631 11.6205 11.0777 11.5843 10.9942 11.5426L4.29297 8.19203ZM12.75 20.037L19.2933 16.7654C19.5474 16.6384 19.7079 16.3787 19.7079 16.0946V8.19202L13.0066 11.5426C12.9229 11.5844 12.8372 11.6208 12.75 11.6516V20.037ZM13.0066 2.41456C12.3732 2.09786 11.6277 2.09786 10.9942 2.41456L4.03676 5.89319C3.27449 6.27432 2.79297 7.05342 2.79297 7.90566V16.0946C2.79297 16.9469 3.27448 17.726 4.03676 18.1071L10.9942 21.5857L11.3296 20.9149L10.9942 21.5857C11.6277 21.9024 12.3732 21.9024 13.0066 21.5857L19.9641 18.1071C20.7264 17.726 21.2079 16.9469 21.2079 16.0946V7.90566C21.2079 7.05342 20.7264 6.27432 19.9641 5.89319L13.0066 2.41456Z"
                            fill="" />
                    </svg>
                </div>

                <div class="mt-5 flex items-end justify-between">
                    <div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Program Studi</span>
                        <h4 class="mt-2 text-title-sm font-bold text-gray-800 dark:text-white/90">
                            16
                        </h4>
                    </div>
                </div>
            </div>
            <!-- Metric Item End -->
        </div>
        <!-- Metric Group One -->

        <!-- ====== Chart One Start -->
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-5 pt-5 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6 sm:pt-6">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Mahasiswa Per Prodi
                </h3>

                <div x-data="{ openDropDown: false }" class="relative h-fit">
                    <button @click="openDropDown = !openDropDown" :class="openDropDown ? 'text-gray-700 dark:text-white' : 'text-gray-400 hover:text-gray-700 dark:hover:text-white'">
                        <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M10.2441 6C10.2441 5.0335 11.0276 4.25 11.9941 4.25H12.0041C12.9706 4.25 13.7541 5.0335 13.7541 6C13.7541 6.9665 12.9706 7.75 12.0041 7.75H11.9941C11.0276 7.75 10.2441 6.9665 10.2441 6ZM10.2441 18C10.2441 17.0335 11.0276 16.25 11.9941 16.25H12.0041C12.9706 16.25 13.7541 17.0335 13.7541 18C13.7541 18.9665 12.9706 19.75 12.0041 19.75H11.9941C11.0276 19.75 10.2441 18.9665 10.2441 18ZM11.9941 10.25C11.0276 10.25 10.2441 11.0335 10.2441 12C10.2441 12.9665 11.0276 13.75 11.9941 13.75H12.0041C12.9706 13.75 13.7541 12.9665 13.7541 12C13.7541 11.0335 12.9706 10.25 12.0041 10.25H11.9941Z"
                                fill="" />
                        </svg>
                    </button>
                    <div x-show="openDropDown" @click.outside="openDropDown = false"
                        class="absolute right-0 z-40 w-40 p-2 space-y-1 bg-white border border-gray-200 top-full rounded-2xl shadow-theme-lg dark:border-gray-800 dark:bg-gray-dark">
                        <button
                            class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                            View More
                        </button>
                        <button
                            class="flex w-full px-3 py-2 font-medium text-left text-gray-500 rounded-lg text-theme-xs hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                            Delete
                        </button>
                    </div>
                </div>
            </div>

            <div class="max-w-full overflow-x-auto custom-scrollbar">
                <div class="-ml-5 min-w-[650px] pl-2 xl:min-w-full">
                    <div id="chartOne" class="-ml-5 h-full min-w-[650px] pl-2 xl:min-w-full"></div>
                </div>
            </div>
        </div>
        <!-- ====== Chart One End -->
    </div>
</div>
