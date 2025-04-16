@extends('apptwo')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-start bg-blue-100 py-12">
    <div class="w-full md:w-1/3 bg-white px-8 py-6 rounded-lg shadow-lg">
        
        <!-- Judul -->
        <h1 class="text-2xl font-semibold text-center text-gray-700 mb-2">Edit Pengumuman</h1>
        <p class="text-center text-gray-500 mb-6">Silakan perbarui pengumuman dengan data yang benar</p>

        <!-- Form -->
        <form action="{{ route('pengumuman.update', $pengumuman->id_pengumuman) }}" method="POST" class="flex flex-col space-y-4">
            @csrf
            @method('PUT')

            <!-- Input Judul Pengumuman -->
            <div class="w-full">
                <label class="block text-gray-700 font-medium mb-1">Judul Pengumuman</label>
                <input type="text" name="judul_pengumuman" value="{{ $pengumuman->judul_pengumuman }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none" placeholder="Masukkan judul..." required>
            </div>

            <!-- Input Tanggal Pengumuman -->
            <div class="w-full">
                <label class="block text-gray-700 font-medium mb-1">Tanggal Pengumuman</label>
                <input type="date" name="tgl_pengumuman" value="{{ $pengumuman->tgl_pengumuman }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none" required>
            </div>

            <!-- Input Detail Pengumuman -->
            <div class="w-full">
                <label class="block text-gray-700 font-medium mb-1">Detail Pengumuman</label>
                <textarea name="detail_pengumuman" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none" placeholder="Masukkan detail pengumuman..." required>{{ $pengumuman->detail_pengumuman }}</textarea>
            </div>

            <!-- Tombol Aksi -->
            <div class="w-full flex flex-col space-y-2">
                <button type="submit" class="w-full px-6 py-2 bg-blue-600 text-white text-lg font-medium rounded-md shadow-md hover:bg-blue-700 transition-all">
                    Simpan
                </button>
                <a href="{{ route('pengumuman.index') }}" class="w-full px-6 py-2 bg-gray-500 text-white text-lg font-medium rounded-md shadow-md hover:bg-gray-600 transition-all text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection