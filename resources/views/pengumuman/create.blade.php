@extends('apptwo')

@section('content')
<div class="min-h-screen flex items-start justify-center bg-blue-100 p-6">
    <div class="w-11/12 md:w-2/3 lg:w-1/2 max-w-md bg-white p-8 rounded-lg shadow-lg mx-auto mt-12">
        
        <!-- Judul -->
        <h1 class="text-3xl font-bold text-center text-blue-700 mb-6">Tambah Pengumuman</h1>
        
        <!-- Form -->
        <form action="{{ route('pengumuman.store') }}" method="POST">
            @csrf
            
            <!-- Judul Pengumuman -->
            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">Judul Pengumuman</label>
                <input type="text" name="judul_pengumuman" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Masukkan judul..." required>
            </div>

            <!-- Tanggal Pengumuman -->
            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">Tanggal Pengumuman</label>
                <input type="date" name="tgl_pengumuman" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
            </div>

            <!-- Detail Pengumuman -->
            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2">Detail Pengumuman</label>
                <textarea name="detail_pengumuman" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Masukkan detail pengumuman..." required></textarea>
            </div>

            <!-- Tombol -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('pengumuman.index') }}" class="px-5 py-3 bg-gray-500 text-white font-semibold rounded-lg shadow-md hover:bg-gray-600 transition-all">Batal</a>
                <button type="submit" class="px-5 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition-all">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection