@extends('app')

@section('content')
<div class="text-2xl font-bold mb-2">Today Course</div>
<p class="text-gray-500 mb-4">
    Home / <span class="text-blue-500">Daily Course</span>
</p>

<div class="bg-white p-4 rounded-lg shadow">
    <form method="GET" action="{{ route('today.course') }}" class="flex mb-4">
        <input class="border rounded-l-full py-2 px-4 flex-grow" 
               name="search"
               placeholder="Cari Nama Siswa atau Orang tua" 
               type="text"
               value="{{ request('search') }}" />
        <select class="border-t border-b border-r py-2 px-4" name="id_tentor">
            <option value="">Pilih Tentor</option>
            @foreach($tentors as $tentor)
                <option value="{{ $tentor->id_tentor }}" {{ request('id_tentor') == $tentor->id_tentor ? 'selected' : '' }}>
                    {{ $tentor->nama_tentor ?? 'Tentor #'.$tentor->id_tentor }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="border rounded-r-full py-2 px-4 bg-gray-200">
            <i class="fas fa-search"></i>
        </button>
    </form>
    
    <table class="w-full text-left">
        <thead>
            <tr class="border-b">
                <th class="py-2">Nomor</th>
                <th class="py-2">Data Siswa</th>
                <th class="py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($jadwals as $index => $jadwal)
            <tr class="border-b">
                <td class="py-2">{{ $index + 1 }}</td>
                <td class="py-2">
                    <p>Nama: {{ $jadwal->nama_siswa }}</p>
                    <p>Orang Tua: {{ $jadwal->nama_ortu }}</p>
                    <p>Alamat: {{ $jadwal->alamat }}</p>
                    <p>No. Handphone Orangtua: 
                        @if($jadwal->telp_ortu)
                            <a class="text-blue-500" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $jadwal->telp_ortu) }}">WhatsApp</a>
                        @else
                            -
                        @endif
                    </p>
                    @if($jadwal->mulai)
                        <p class="mt-2 text-sm text-gray-600">
                            Mulai: {{ \Carbon\Carbon::parse($jadwal->mulai->waktu_mulai)->translatedFormat('l, d M Y H:i') }}
                            Lokasi: 
                            @if(!empty($jadwal->mulai->lokasi_latitude) && !empty($jadwal->mulai->lokasi_longitude))
                                <a href="https://www.google.com/maps?q={{ $jadwal->mulai->lokasi_latitude }},{{ $jadwal->mulai->lokasi_longitude }}" target="_blank" class="text-blue-500 underline">Lihat di Maps</a>
                            @else
                                -
                            @endif
                        </p>
                        @if(!is_null($jadwal->mulai->waktu_akhir ?? null))
                            <p class="text-sm text-gray-600">
                                Selesai: {{ \Carbon\Carbon::parse($jadwal->mulai->waktu_akhir)->translatedFormat('l, d M Y H:i') }}
                            </p>
                        @endif
                    @else
                        <p class="mt-2 text-sm text-gray-600">Belum dimulai</p>
                    @endif
                </td>
                <td class="py-2">
                    <div class="flex space-x-2 items-center">
                        @php
                            $sudahSelesai = $jadwal->mulai && !is_null($jadwal->mulai->waktu_akhir ?? null);
                        @endphp

                        @if(!$sudahSelesai)
                        <!-- Tombol MULAI -->
                        <form id="form-start-{{ $jadwal->id_jadwal }}" action="{{ route('jadwals.start', $jadwal) }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_tentor" value="{{ $jadwal->id_tentor }}">
                            <input type="hidden" name="id_jadwal" value="{{ $jadwal->id_jadwal }}">
                            <input type="hidden" name="id_mulai" value="{{ $jadwal->mulai->id_mulai ?? null }}">
                            <input type="hidden" name="latitude" id="lat-{{ $jadwal->id_jadwal }}">
                            <input type="hidden" name="longitude" id="long-{{ $jadwal->id_jadwal }}">
                            <input type="hidden" name="waktu_mulai" id="waktu-{{ $jadwal->id_jadwal }}">

                            @php
                                $mulai = $jadwal->mulai; // Menyimpan status apakah sudah dimulai
                            @endphp

                            <button 
                                type="button"
                                id="btn-start-{{ $jadwal->id_jadwal }}"
                                onclick="handleStart(this, {{ $jadwal->id_jadwal }})" 
                                class="bg-green-500 text-white py-1 px-3 rounded-full hover:bg-green-600 transition duration-200
                                @if($mulai && !is_null($mulai->waktu_mulai)) bg-gray-500 cursor-not-allowed @endif"
                                @if($mulai && !is_null($mulai->waktu_mulai)) disabled @endif>
                                MULAI
                            </button>
                        </form>

                            <!-- Tombol MULAI
                            <form id="form-start-{{ $jadwal->id_jadwal }}" action="{{ route('jadwals.start', $jadwal) }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_tentor" value="{{ $jadwal->id_tentor }}">
                                <input type="hidden" name="id_jadwal" value="{{ $jadwal->id_jadwal }}">
                                <input type="hidden" name="id_mulai" value="{{ $jadwal->mulai->id_mulai ?? null }}">
                                <input type="hidden" name="latitude" id="lat-{{ $jadwal->id_jadwal }}">
                                <input type="hidden" name="longitude" id="long-{{ $jadwal->id_jadwal }}">
                                <input type="hidden" name="waktu_mulai" id="waktu-{{ $jadwal->id_jadwal }}">
                                <button 
                                    type="button"
                                    id="btn-start-{{ $jadwal->id_jadwal }}"
                                    onclick="handleStart(this, {{ $jadwal->id_jadwal }})" 
                                    class="bg-green-500 text-white py-1 px-3 rounded-full hover:bg-green-600 transition duration-200"
                                    @if($jadwal->mulai && !is_null($jadwal->mulai->waktu_mulai)) disabled @endif>
                                    MULAI
                                </button>
                            </form> -->

                            <!-- Tombol SELESAI
                            <form action="{{ route('dokumentasi.create', ['jadwal' => $jadwal->id_jadwal, 'id_mulai' => $jadwal->mulai->id_mulai ?? null]) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-red-500 text-white py-1 px-3 rounded-full hover:bg-red-600 transition duration-200">
                                    SELESAI
                                </button>
                            </form> -->

                            <!-- Tombol SELESAI -->
                            <form action="{{ route('dokumentasi.create', ['jadwal' => $jadwal->id_jadwal, 'id_mulai' => $jadwal->mulai->id_mulai ?? null]) }}" method="POST">
                                @csrf
                                @php
                                    $selesai = \App\Models\Dokumentasi::where('id_jadwal', $jadwal->id_jadwal)
                                                ->where('id_mulai', $jadwal->mulai->id_mulai ?? null)
                                                ->first();
                                @endphp
                                <button type="submit" 
                                        class="bg-red-500 text-white py-1 px-3 rounded-full hover:bg-red-600 transition duration-200 
                                        @if($selesai) bg-gray-500 cursor-not-allowed @endif"
                                        @if($selesai) disabled @endif>
                                    SELESAI
                                </button>
                            </form>

                        @else
                            <!-- Status COMPLETED -->
                            <span class="bg-gray-300 text-gray-700 py-1 px-3 rounded-full">COMPLETED</span>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
    function handleStart(button, jadwalId) {
        console.log("Tombol MULAI diklik");
        button.disabled = true;

        if (!navigator.geolocation) {
            alert("Browser Anda tidak mendukung geolokasi.");
            return;
        }

        navigator.geolocation.getCurrentPosition(function(position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;
            const now = new Date().toISOString();

            document.getElementById(`lat-${jadwalId}`).value = latitude;
            document.getElementById(`long-${jadwalId}`).value = longitude;
            document.getElementById(`waktu-${jadwalId}`).value = now;

            document.getElementById(`form-start-${jadwalId}`).submit();
        }, function(error) {
            alert("Gagal mendapatkan lokasi. Aktifkan lokasi perangkat.");
            button.disabled = false; // enable lagi kalau gagal
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        // Tambahan UX saat tombol mulai diklik
        const startButtons = document.querySelectorAll("form[id^='form-start-'] button");
        startButtons.forEach(button => {
            button.addEventListener("click", function () {
                this.disabled = true;
                this.innerText = "Sedang Mulai...";
            });
        });

        // Cek jika redirect dari SELESAI dan tandai COMPLETED
        const urlParams = new URLSearchParams(window.location.search);
        const justCompletedId = urlParams.get('completed_id');

        if (justCompletedId) {
            const row = document.querySelector(`tr[data-jadwal-id='${justCompletedId}']`);
            if (row) {
                const actions = row.querySelector('.flex.space-x-2');
                const completedBadge = document.createElement('span');
                completedBadge.className = "bg-gray-300 text-gray-700 py-1 px-3 rounded-full";
                completedBadge.innerText = "COMPLETED";
                actions.appendChild(completedBadge);
            }
        }
    });
</script>
@endsection
