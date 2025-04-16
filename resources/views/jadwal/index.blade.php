@extends('apptwo')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">

    {{-- Alert sukses --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tombol tambah jadwal --}}
    <div class="row mb-3">
        <div class="flex flex-col md:flex-row justify-end gap-x-4">
            <a href="{{ route('jadwal.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Add Schedule
            </a>
        </div>
    </div>

    {{-- Tabel Jadwal --}}
    <div class="overflow-x-auto">
        <table class="table table-borderless shadow-sm rounded w-full" style="background-color: #f9f9f9;">
            <thead class="table-light">
                <tr>
                    <th class="text-left p-2">No</th>
                    <th class="text-left p-2">Data Jadwal</th>
                    <th class="text-left p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jadwal as $item)
                <tr class="border-b">
                    <td class="align-top p-2">{{ $loop->iteration + ($jadwal->currentPage() - 1) * $jadwal->perPage() }}</td>
                    <td class="align-top text-sm p-2">
                        <strong>Nama Kursus:</strong> {{ optional($item->kursus)->nama_kursus ?? '-' }}<br>
                        <strong>Nama Tentor:</strong> {{ optional($item->tentor)->nama_tentor ?? '-' }}<br>
                        <strong>Durasi:</strong> 
                            @php
                                $durasiMenit = 0; // Nilai default jika format tidak valid
                                if (!empty($item->durasi) && is_numeric($item->durasi)) {
                                    $durasiMenit = $item->durasi;
                                }

                                // Mengonversi durasi dalam menit ke format jam dan menit
                                $jam = floor($durasiMenit / 60);
                                $menit = $durasiMenit % 60;

                                $durasiFormat = "{$jam} jam {$menit} menit";
                            @endphp
                            {{ $durasiFormat }}<br>
                        <strong>Nama Siswa:</strong> {{ $item->nama_siswa ?? '-' }}<br>
                        <strong>Nama Ortu:</strong> {{ $item->nama_ortu ?? '-' }}<br>
                        <strong>Telp Ortu:</strong> {{ $item->telp_ortu ?? '-' }}<br>
                        <strong>Alamat:</strong> {{ $item->alamat ?? '-' }}<br>
                        <strong>Hari:</strong> {{ $item->hari ?? '-' }}<br>
                        <strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d M Y') }}<br>
                        <strong>Tanggal Berakhir:</strong> {{ \Carbon\Carbon::parse($item->tanggal_berakhir)->translatedFormat('d M Y') }}<br>
                        <strong>Waktu Mulai:</strong> {{ \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') }}<br>
                        <strong>Waktu Selesai:</strong> {{ \Carbon\Carbon::parse($item->waktu_akhir)->format('H:i') }}
                    </td>
                    <td class="align-top p-2">
                        <div class="flex gap-2">
                            <a href="{{ route('jadwal.edit', $item->id_jadwal) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded shadow-sm text-sm" title="Edit">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('jadwal.destroy', $item->id_jadwal) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow-sm text-sm" title="Hapus">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-gray-500 py-4">Belum ada data jadwal.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $jadwal->links() }}
        </div>
    </div>

</div>
@endsection
