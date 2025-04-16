@extends('app')

@section('content')
    <div class="text-2xl font-bold mb-2">Riwayat Kursus</div>
    <p class="text-gray-500 mb-4">Home / <span class="text-blue-500">History</span></p>

    <form method="GET" action="{{ route('history.course') }}" class="mb-4 flex flex-col sm:flex-row gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa..."
        class="border border-gray-300 rounded px-3 py-2 w-full">
    <button type="submit"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full sm:w-auto">Cari</button>
    </form>

    <div class="bg-white p-4 rounded-lg shadow">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b">
                    <th class="py-2">Nama Siswa</th>
                    <th class="py-2">Tanggal</th>
                    <th class="py-2">Waktu Mulai</th>
                    <th class="py-2">Waktu Selesai</th>
                    <th class="py-2">Lokasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($histories as $jadwal)
                    <tr class="border-b">
                        <td class="py-2">{{ $jadwal->nama_siswa }}</td>
                        <td class="py-2">{{ \Carbon\Carbon::parse($jadwal->tanggal_mulai)->translatedFormat('d M Y') }}</td>
                        <td class="py-2">{{ optional($jadwal->mulai)->waktu_mulai ? \Carbon\Carbon::parse($jadwal->mulai->waktu_mulai)->format('H:i') : '-' }}</td>
                        <td class="py-2">{{ $jadwal->waktu_akhir ? \Carbon\Carbon::parse($jadwal->waktu_akhir)->format('H:i') : '-' }}</td>
                        <td class="py-2">
                            @if($jadwal->mulai)
                                <a href="https://www.google.com/maps?q={{ $jadwal->mulai->lokasi_latitude }},{{ $jadwal->mulai->lokasi_longitude }}" 
                                   target="_blank" class="text-blue-500 underline">
                                   Lihat Lokasi
                                </a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-gray-500">Belum ada riwayat kursus</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
