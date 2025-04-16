@extends('apptwo')
@section('content')

<div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg mt-10">
    <h2 class="text-2xl font-bold mb-4">Tambah Kursus</h2>
    
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('course.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block font-semibold">Nama Kursus</label>
            <input type="text" name="nama_kursus" class="w-full p-2 border rounded" required>
        </div>

        <div>
            <label class="block font-semibold">Foto Kursus</label>
            <input type="file" name="foto_kursus" class="w-full p-2 border rounded" required>
        </div>

        <div>
            <label class="block font-semibold">Harga Kursus</label>
            <input type="text" name="harga_kursus" class="w-full p-2 border rounded" required>
        </div>

        <div>
            <label class="block font-semibold">Deskripsi</label>
            <textarea name="deskripsi" rows="4" class="w-full p-2 border rounded" required></textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Simpan
        </button>
    </form>
</div>

@endsection