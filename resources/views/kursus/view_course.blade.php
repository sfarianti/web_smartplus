@extends('apptwo')
@section('content')

<div class="max-w-6xl mx-auto p-6 bg-white shadow-md rounded-lg mt-10">
    <h2 class="text-2xl font-bold mb-4">Daftar Kursus</h2>

    <!-- Form Pencarian -->
<form action="{{ route('course.index') }}" method="GET" class="mb-4 flex items-center space-x-2">
    <input type="text" name="search" class="p-2 border rounded-md w-full" placeholder="Cari kursus berdasarkan nama..." value="{{ request()->get('search') }}">
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Search</button>
</form>


    <a href="{{ route('course.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-600">
        Tambah Kursus
    </a>

    <table class="w-full border-collapse border border-gray-200 mt-4">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Nama Kursus</th>
                <th class="border px-4 py-2">Harga Kursus</th>
                <th class="border px-4 py-2">Foto</th>
                <th class="border px-4 py-2">Deskripsi</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
            <tr class="text-center">
                <td class="border px-4 py-2">{{ $course->id_kursus }}</td>
                <td class="border px-4 py-2">{{ $course->nama_kursus }}</td>
                <td class="border px-4 py-2">{{ $course->harga_kursus }}</td>
                <td class="border px-4 py-2">
                    @if($course->foto_kursus)
                        <img src="{{ asset('storage/' . $course->foto_kursus) }}" 
                            alt="Foto Kursus" 
                            style="width: 80px; height: 80px; object-fit: cover; display: block; margin: auto; border-radius: 8px;">
                    @else
                        <span class="text-gray-500">Tidak ada gambar</span>
                    @endif
                </td>

                <td class="border px-4 py-2">{{ $course->deskripsi }}</td>
                <td class="border px-4 py-2">
                    <div class="flex justify-center gap-2">
                        <a href="{{ route('course.edit', $course->id_kursus) }}" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">
                            Edit
                        </a>
                        <form action="{{ route('course.destroy', $course->id_kursus) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kursus ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
