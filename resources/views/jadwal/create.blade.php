@extends('apptwo')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    <!-- <div class="row mb-3">
        <div class="col-12">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search here...." aria-label="Search here....">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-user"></i>
                    </button>
                </div>
            </div>
        </div>
    </div> -->

    <div class="row mb-3">
    <div class="flex flex-col md:flex-row justify-end gap-x-4">
        <a href="{{ route('jadwal.index') }}" class="bg-green-500 text-white text-white px-4 py-2 rounded mb-4 inline-block hover:bg-green-600">Schedule</a>
        <!-- <a href="{{ route('jadwal.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded inline-block hover:bg-blue-600">Add Schedule</a> -->
    </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('jadwal.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">

 <!-- Nama Kursus -->
<div>
    <label for="id_kursus" class="block text-sm font-semibold text-gray-700">Nama Kursus</label>
    <select name="id_kursus" id="id_kursus" required
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-500">
        <option value="" disabled selected hidden>Contoh: Pilih Kursus</option>
        @foreach ($courses as $course)
            <option value="{{ $course->id_kursus }}">{{ $course->nama_kursus }}</option>
        @endforeach
    </select>
</div>

<!-- Nama Tentor -->
<div>
    <label for="id_tentor" class="block text-sm font-semibold text-gray-700">Nama Tentor</label>
    <select name="id_tentor" id="id_tentor" required>
    @foreach ($tentors as $tentor)
        <option value="{{ $tentor->id_tentor }}">{{ $tentor->nama_tentor ?? 'No name' }}</option>
    @endforeach
</select>

</div>


<!-- Durasi -->
<div>
    <label for="durasi" class="block text-sm font-semibold text-gray-700">Durasi (menit)</label>
    <input type="number" name="durasi" id="durasi" placeholder="Contoh: 45"
    value="{{ old('durasi', $jadwal->durasi ?? '') }}" required
    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
</div>

<!-- Nama Siswa -->
<div>
    <label for="nama_siswa" class="block text-sm font-semibold text-gray-700">Nama Siswa</label>
    <input type="text" name="nama_siswa" id="nama_siswa" required
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
</div>

<!-- Nama Ortu -->
<div>
    <label for="nama_ortu" class="block text-sm font-semibold text-gray-700">Nama Ortu</label>
    <input type="text" name="nama_ortu" id="nama_ortu" required
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
</div>

<!-- Alamat -->
<div>
    <label for="alamat" class="block text-sm font-semibold text-gray-700">Alamat</label>
    <input type="text" name="alamat" id="alamat" required
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
</div>

<!-- Telp Ortu -->
<div>
    <label for="telp_ortu" class="block text-sm font-semibold text-gray-700">Telp. Ortu</label>
    <input type="text" name="telp_ortu" id="telp_ortu" required
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
</div>

<!-- Hari -->
<div>
    <label for="hari" class="block text-sm font-semibold text-gray-700">Hari </label>
    <input type="text" name="hari" id="hari" placeholder="Contoh: Senin  Mohon diperhatikan ! setiap pengisian hanya bisa 1 hari saja!!!" required
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
</div>

<!-- Tanggal Mulai -->
<div>
    <label for="tanggal_mulai" class="block text-sm font-semibold text-gray-700">Tanggal Mulai</label>
    <input type="date" name="tanggal_mulai" id="tanggal_mulai" required
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
</div>

<!-- Tanggal Berakhir -->
<div>
    <label for="tanggal_berakhir" class="block text-sm font-semibold text-gray-700">Tanggal Berakhir</label>
    <input type="date" name="tanggal_berakhir" id="tanggal_berakhir" required
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
</div>

<!-- Waktu Mulai Mengajar -->
<div>
    <label for="waktu_mulai" class="block text-sm font-semibold text-gray-700">Waktu Mulai Mengajar</label>
    <input type="time" name="waktu_mulai" id="waktu_mulai" required
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
</div>

<!-- Waktu Selesai Mengajar -->
<div>
    <label for="waktu_akhir" class="block text-sm font-semibold text-gray-700">Waktu Selesai Mengajar</label>
    <input type="time" name="waktu_akhir" id="waktu_akhir" required
        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
</div>

<!-- Submit Button -->
<div class="mt-4">
    <button type="submit"
        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md">
        Simpan Jadwal
    </button>
</div>   
            </form>
        </div>
    </div>

    <!-- <div class="row mt-3">
        <div class="col-md-12 text-center">
            <p>Copyright © 2025 <strong>LBB SMART PLUS</strong>. All Rights Reserved.</p>
        </div>
    </div> -->
</div>
@endsection

<!-- <style>
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-primary:hover {
        background-color: #0069d9;
        border-color: #0062cc;
    }
</style> -->
