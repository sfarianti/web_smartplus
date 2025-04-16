@extends('apptwo')

@section('content')
<div class="min-h-screen bg-blue-600 flex flex-col items-center py-10">
    <!-- Container utama -->
    <div class="bg-white w-11/12 max-w-2xl p-8 rounded-lg shadow-lg">

        <!-- Judul di tengah -->
        <h1 class="text-3xl font-bold text-gray-800 text-center mb-6">📢 Announcements</h1>

        <!-- Tombol Tambah di Kanan -->
        <div class="flex justify-end mb-6">
            <a href="{{ route('pengumuman.create') }}" class="flex items-center bg-blue-700 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-800 transition-all no-underline">
                <span class="mr-2 text-lg">➕</span> <span class="text-lg">Add Announcement</span>
            </a>
        </div>

        <!-- Daftar Pengumuman -->
        <div class="space-y-6">
            @forelse ($pengumuman as $item)
            <div class="p-8 bg-white rounded-lg shadow-md flex justify-between items-center border border-gray-300">
                <div class="flex flex-col gap-4">
                    <!-- Isi Pengumuman -->
                    <h2 class="text-xl font-semibold text-gray-800">{{ $item->judul_pengumuman }}</h2>
                    <p class="text-gray-600 text-base leading-relaxed">{{ $item->detail_pengumuman }}</p>
                </div>
                <div class="flex flex-col items-end">
                    <span class="text-gray-500 text-sm mb-3">{{ \Carbon\Carbon::parse($item->tanggal_pengumuman)->format('d M Y') }}</span>
                    <div class="flex space-x-4">
                        <a href="{{ route('pengumuman.edit', $item->id_pengumuman) }}" class="text-blue-500 hover:text-blue-700 text-2xl no-underline">✏️</a>
                        <form action="{{ route('pengumuman.destroy', $item->id_pengumuman) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-2xl no-underline">🗑️</button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center text-gray-400 py-6 text-lg">Tidak ada pengumuman</p>
            @endforelse
        </div>
    </div>
</div>
@endsection