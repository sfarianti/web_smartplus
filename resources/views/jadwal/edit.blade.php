@extends('apptwo')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    <div class="row mb-3">
        <div class="flex flex-col md:flex-row justify-end gap-x-4">
            <a href="{{ route('jadwal.index') }}"
               class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-green-600">
                Kembali ke Jadwal
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('jadwal.update', $jadwal->id_jadwal) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 space-y-4">

                        {{-- Nama Kursus --}}
                        <div>
                            <label for="id_kursus" class="block text-sm font-semibold text-gray-700">Nama Kursus</label>
                            <select name="id_kursus" class="form-control">
                                @foreach($courses as $course)
                                    <option value="{{ $course->id_kursus }}" 
                                        {{ old('id_kursus', $jadwal->id_kursus) == $course->id_kursus ? 'selected' : '' }}>
                                        {{ $course->nama_kursus }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Nama Tentor --}}
                        <div>
                            <label for="id_tentor" class="block text-sm font-semibold text-gray-700">Nama Tentor</label>
                            <select name="id_tentor" id="id_tentor" required
                                class="mt-1 block w-full border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-700">
                                <option value="" disabled hidden>Pilih Tentor</option>
                                @foreach ($tentors as $tentor)
                                    <option value="{{ $tentor->id_tentor }}" {{ $jadwal->id_tentor == $tentor->id_tentor ? 'selected' : '' }}>
                                        {{ $tentor->nama_tentor }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Durasi --}}
                        @php
                        $durasiParts = explode(':', $jadwal->durasi);
                        $durasiDalamMenit = 0;

                        if (count($durasiParts) == 2) {
                            $durasiDalamMenit = ($durasiParts[0] * 60) + $durasiParts[1];
                        }
                        @endphp
                        <div>
                            <label for="durasi" class="block text-sm font-semibold text-gray-700">Durasi (menit)</label>
                            <input type="number" name="durasi" id="durasi" value="{{ old('durasi', $durasiDalamMenit) }}" required
                            class="mt-1 block w-full border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                        </div>

                        {{-- Nama Siswa --}}
                        <div>
                            <label for="nama_siswa" class="block text-sm font-semibold text-gray-700">Nama Siswa</label>
                            <input type="text" name="nama_siswa" id="nama_siswa" value="{{ old('nama_siswa', $jadwal->nama_siswa) }}" required
                                class="mt-1 block w-full border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        {{-- Nama Ortu --}}
                        <div>
                            <label for="nama_ortu" class="block text-sm font-semibold text-gray-700">Nama Ortu</label>
                            <input type="text" name="nama_ortu" id="nama_ortu" value="{{ old('nama_ortu', $jadwal->nama_ortu) }}" required
                                class="mt-1 block w-full border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        {{-- Alamat --}}
                        <div>
                            <label for="alamat" class="block text-sm font-semibold text-gray-700">Alamat</label>
                            <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $jadwal->alamat) }}" required
                                class="mt-1 block w-full border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        {{-- Telp Ortu --}}
                        <div>
                            <label for="telp_ortu" class="block text-sm font-semibold text-gray-700">Telp. Ortu</label>
                            <input type="text" name="telp_ortu" id="telp_ortu" value="{{ old('telp_ortu', $jadwal->telp_ortu) }}" required
                                class="mt-1 block w-full border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        {{-- Hari --}}
                        <div>
                            <label for="hari" class="block text-sm font-semibold text-gray-700">Hari</label>
                            <input type="text" name="hari" id="hari" value="{{ old('hari', $jadwal->hari) }}" required
                                class="mt-1 block w-full border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        {{-- Tanggal Mulai --}}
                        <div>
                            <label for="tanggal_mulai" class="block text-sm font-semibold text-gray-700">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai', \Carbon\Carbon::parse($jadwal->tanggal_mulai)->format('Y-m-d')) }}" required
                                class="mt-1 block w-full border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        {{-- Tanggal Berakhir --}}
                        <div>
                            <label for="tanggal_berakhir" class="block text-sm font-semibold text-gray-700">Tanggal Berakhir</label>
                            <input type="date" name="tanggal_berakhir" id="tanggal_berakhir" value="{{ old('tanggal_berakhir', \Carbon\Carbon::parse($jadwal->tanggal_berakhir)->format('Y-m-d')) }}" required
                                class="mt-1 block w-full border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        {{-- Waktu Mulai --}}
                        <div>
                            <label for="waktu_mulai" class="block text-sm font-semibold text-gray-700">Waktu Mulai Mengajar</label>
                            <input type="time" name="waktu_mulai" id="waktu_mulai" value="{{ old('waktu_mulai', \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i')) }}"
                                class="mt-1 block w-full border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        {{-- Waktu Selesai --}}
                        <div>
                            <label for="waktu_akhir" class="block text-sm font-semibold text-gray-700">Waktu Selesai Mengajar</label>
                            <input type="time" name="waktu_akhir" id="waktu_akhir" value="{{ old('waktu_akhir', \Carbon\Carbon::parse($jadwal->waktu_akhir)->format('H:i')) }}"
                                class="mt-1 block w-full border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        {{-- Submit Button --}}
                        <div class="mt-6">
                            <button type="submit"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-md">
                                Update Jadwal
                            </button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
