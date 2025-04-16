@extends('layouts.app')

@section('title', 'Tomorrow Course - SMART PLUS Learning')

@section('content')
    <div class="text-2xl font-bold mb-2">Tomorrow Course</div>
    <p class="text-gray-500 mb-4">
        Home / <span class="text-blue-500">Soon Course</span>
    </p>

    <div class="bg-white p-4 rounded-lg shadow">
        <form action="{{ route('tomorrow.course') }}" method="GET" class="flex mb-4">
            <input name="search" value="{{ request('search') }}" class="border rounded-l-full py-2 px-4 flex-grow" placeholder="Cari Nama Siswa atau Orang tua" type="text"/>
            <select name="tentor" class="border-t border-b border-l py-2 px-4">
                <option value="">Pilih Tentor</option>
                @foreach($tentors as $tentor)
                    <option value="{{ $tentor->id_tentor }}" {{ request('tentor') == $tentor->id_tentor ? 'selected' : '' }}>
                        {{ $tentor->nama_tentor }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="border rounded-r-full py-2 px-4 bg-gray-200">
                <i class="fas fa-search"></i>
            </button>
        </form>
        
        <table class="w-full text-left border-collapse">
            <thead>
                <tr>
                    <th class="border-b py-2 px-4">Nomor</th>
                    <th class="border-b py-2 px-4">Data Siswa</th>
                    <th class="border-b py-2 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwals as $index => $jadwal)
                    <tr>
                        <td class="border-b py-2 px-4">{{ $index + 1 }}</td>
                        <td class="border-b py-2 px-4">
                            <p>Nama: {{ $jadwal->nama_siswa }}</p>
                            <p>Orang Tua: {{ $jadwal->nama_ortu }}</p>
                            <p>Alamat: {{ $jadwal->alamat }}</p>
                            <p>
                                No. Handphone Orangtua: 
                                @if($jadwal->telp_ortu)
                                    <a class="text-blue-500" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $jadwal->telp_ortu) }}">
                                        WhatsApp
                                    </a>
                                @else
                                    -
                                @endif
                            </p>
                        </td>
                        <td class="border-b py-2 px-4">
                            <form action="{{ route('course.start', $jadwal->id_jadwal) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white py-1 px-3 rounded-full mb-1">
                                    MULAI
                                </button>
                            </form>
                            <form action="{{ route('course.finish', $jadwal->id_jadwal) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-500 text-white py-1 px-3 rounded-full">
                                    SELESAI
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="border-b py-4 px-4 text-center text-gray-500">
                            Tidak ada data jadwal yang ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
