@extends('app')

@section('title', 'My Schedule')

@section('content')
<div class="text-2xl font-bold mb-2">Jadwal Saya</div>
<p class="text-gray-500 mb-4">Home / <span class="text-blue-500">My Schedule</span></p>

<form method="GET" action="{{ route('jadwals.myschedule') }}" class="mb-4 w-full flex flex-col sm:flex-row gap-2">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa..."
        class="border border-gray-300 rounded px-3 py-2 w-full">
    <button type="submit"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full sm:w-auto">Cari</button>
</form>


<div class="container mx-auto px-4 py-6">

    @if($jadwals->isEmpty())
        <div class="bg-yellow-100 border-l-4 border-yellow-400 text-yellow-800 p-4 rounded">
            <p>Belum ada jadwal untuk Anda.</p>
        </div>
    @else
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full text-sm text-left border border-blue-100 rounded overflow-hidden">
                <thead class="bg-blue-100 text-black-800">
                    <tr>
                        <th class="px-4 py-3 font-medium">No</th>
                        <th class="px-4 py-3 font-medium">Nama Siswa</th>
                        <th class="px-4 py-3 font-medium">Nama Ortu</th>
                        <th class="px-4 py-3 font-medium">Alamat</th>
                        <th class="px-4 py-3 font-medium">Telp Ortu</th>
                        <th class="px-4 py-3 font-medium">Nama Kursus</th>
                        <th class="px-4 py-3 font-medium">Tanggal Mulai</th>
                        <th class="px-4 py-3 font-medium">Tanggal Berakhir</th>
                        <th class="px-4 py-3 font-medium">Hari</th>
                        <th class="px-4 py-3 font-medium">Waktu Mulai</th>
                        <th class="px-4 py-3 font-medium">Waktu Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jadwals as $index => $jadwal)
                        <tr class="{{ $index % 2 == 0 ? 'bg-blue-50' : 'bg-white' }} hover:bg-blue-100 transition">
                            <td class="px-4 py-2 border-t border-blue-100">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border-t border-blue-100">{{ $jadwal->nama_siswa }}</td>
                            <td class="px-4 py-2 border-t border-blue-100">{{ $jadwal->nama_ortu }}</td>
                            <td class="px-4 py-2 border-t border-blue-100">{{ $jadwal->alamat }}</td>
                            <td class="px-4 py-2 border-t border-blue-100">{{ $jadwal->telp_ortu }}</td>
                            <td class="px-4 py-2 border-t border-blue-100">{{ optional($jadwal->kursus)->nama_kursus ?? '-' }}</td>
                            <td class="px-4 py-2 border-t border-blue-100">{{ \Carbon\Carbon::parse($jadwal->tanggal_mulai)->format('d M Y') }}</td>
                            <td class="px-4 py-2 border-t border-blue-100">{{ \Carbon\Carbon::parse($jadwal->tanggal_berakhir)->format('d M Y') }}</td>
                            <td class="px-4 py-2 border-t border-blue-100">{{ $jadwal->hari }}</td>
                            <td class="px-4 py-2 border-t border-blue-100">{{ $jadwal->waktu_mulai ? \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') : '-' }}</td>
                            <td class="px-4 py-2 border-t border-blue-100">{{ $jadwal->waktu_akhir ? \Carbon\Carbon::parse($jadwal->waktu_akhir)->format('H:i') : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
