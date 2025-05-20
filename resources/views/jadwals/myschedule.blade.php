@extends('app')

@section('title', 'My Schedule')

@section('content')
<div class="text-2xl font-bold mb-2">Jadwal Saya</div>
<p class="text-gray-500 mb-4">Home / <span class="text-blue-500">My Schedule</span></p>

<form method="GET" action="{{ route('jadwals.myschedule') }}" class="mb-4 w-full flex flex-col sm:flex-row gap-2">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa..."
        class="border border-gray-300 rounded px-3 py-2 w-full sm:w-auto flex-1">
    <button type="submit"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full sm:w-auto">Cari</button>
</form>

<div class="container max-w-full mx-auto px-2 sm:px-4 py-6">
    @if($jadwals->isEmpty())
        <div class="bg-yellow-100 border-l-4 border-yellow-400 text-yellow-800 p-4 rounded">
            <p>Belum ada jadwal untuk Anda.</p>
        </div>
    @else
    <div class="w-full overflow-x-auto rounded-lg shadow bg-white">
        <table class="min-w-[800px] sm:min-w-full text-sm text-left border border-blue-100">
            <thead class="bg-blue-100 text-black-800">
                <tr>
                    <th class="px-3 py-2 font-medium whitespace-nowrap">No</th>
                    <th class="px-3 py-2 font-medium whitespace-nowrap">Nama Siswa</th>
                    <th class="px-3 py-2 font-medium whitespace-nowrap">Nama Ortu</th>
                    <th class="px-3 py-2 font-medium whitespace-nowrap">Alamat</th>
                    <th class="px-3 py-2 font-medium whitespace-nowrap">Telp Ortu</th>
                    <th class="px-3 py-2 font-medium whitespace-nowrap">Nama Kursus</th>
                    <th class="px-3 py-2 font-medium whitespace-nowrap">Mulai</th>
                    <th class="px-3 py-2 font-medium whitespace-nowrap">Berakhir</th>
                    <th class="px-3 py-2 font-medium whitespace-nowrap">Hari</th>
                    <th class="px-3 py-2 font-medium whitespace-nowrap">Mulai (Jam)</th>
                    <th class="px-3 py-2 font-medium whitespace-nowrap">Akhir (Jam)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jadwals as $index => $jadwal)
                <tr class="{{ $index % 2 == 0 ? 'bg-blue-50' : 'bg-white' }} hover:bg-blue-100 transition">
                    <td class="px-3 py-2 border-t border-blue-100 whitespace-nowrap">{{ $index + 1 }}</td>
                    <td class="px-3 py-2 border-t border-blue-100 whitespace-nowrap">{{ $jadwal->nama_siswa }}</td>
                    <td class="px-3 py-2 border-t border-blue-100 whitespace-nowrap">{{ $jadwal->nama_ortu }}</td>
                    <td class="px-3 py-2 border-t border-blue-100">{{ $jadwal->alamat }}</td>
                    <td class="px-3 py-2 border-t border-blue-100 whitespace-nowrap">{{ $jadwal->telp_ortu }}</td>
                    <td class="px-3 py-2 border-t border-blue-100 whitespace-nowrap">{{ optional($jadwal->kursus)->nama_kursus ?? '-' }}</td>
                    <td class="px-3 py-2 border-t border-blue-100 whitespace-nowrap">{{ \Carbon\Carbon::parse($jadwal->tanggal_mulai)->format('d M Y') }}</td>
                    <td class="px-3 py-2 border-t border-blue-100 whitespace-nowrap">{{ \Carbon\Carbon::parse($jadwal->tanggal_berakhir)->format('d M Y') }}</td>
                    <td class="px-3 py-2 border-t border-blue-100 whitespace-nowrap">{{ $jadwal->hari }}</td>
                    <td class="px-3 py-2 border-t border-blue-100 whitespace-nowrap">{{ $jadwal->waktu_mulai ? \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') : '-' }}</td>
                    <td class="px-3 py-2 border-t border-blue-100 whitespace-nowrap">{{ $jadwal->waktu_akhir ? \Carbon\Carbon::parse($jadwal->waktu_akhir)->format('H:i') : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
