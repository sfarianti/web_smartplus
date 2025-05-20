@extends('app')

@section('content')
    <div class="text-2xl font-bold mb-2">Riwayat Kursus</div>
    <p class="text-gray-500 mb-4">Home / <span class="text-blue-500">History</span></p>

    <!--<form method="GET" action="{{ route('history.course') }}" class="mb-4 flex flex-col sm:flex-row gap-2">-->
    <!--    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa..."-->
    <!--    class="border border-gray-300 rounded px-3 py-2 w-full">-->
    <!--<button type="submit"-->
    <!--    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full sm:w-auto">Cari</button>-->
    <!--</form>-->
    
    <form method="GET" action="{{ route('history.course') }}" class="mb-4 flex flex-col sm:flex-row gap-2" id="search-form">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa..."
        class="border border-gray-300 rounded px-3 py-2 w-full" id="search-input" readonly
        onfocus="this.removeAttribute('readonly')">
</form>

<script>
    const searchInput = document.getElementById('search-input');
    const historyBody = document.querySelector('tbody');
    let lastKeyword = searchInput.value;

    searchInput.addEventListener('input', function () {
        const keyword = this.value;

        // Cegah request ganda kalau input tidak berubah
        if (keyword === lastKeyword) return;
        lastKeyword = keyword;

        fetch(`{{ route('history.course') }}?search=${encodeURIComponent(keyword)}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newRows = doc.querySelector('tbody').innerHTML;
            historyBody.innerHTML = newRows;
        });
    });
</script>



    <div class="bg-white p-4 rounded-lg shadow">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b">
                    <th class="py-2">Nama Siswa</th>
                    <!--<th class="py-2">Tanggal</th>-->
                    <th class="py-2">Waktu Mulai</th>
                    <th class="py-2">Waktu Selesai</th>
                    <th class="py-2">Lokasi</th>
                </tr>
            </thead>
          <tbody>
    @forelse($histories as $item)
        <tr class="border-b">
            <td class="py-2">{{ $item->jadwal->nama_siswa ?? '-' }}</td>
            <td class="py-2">
                {{ $item->mulai?->waktu_mulai 
                    ? \Carbon\Carbon::parse($item->mulai->waktu_mulai)->format('d M Y, H:i') 
                    : '-' }}
            </td>
            <td class="py-2">
                {{ $item->waktu_akhir 
                    ? \Carbon\Carbon::parse($item->waktu_akhir)->format('d M Y, H:i') 
                    : '-' }}
            </td>
            <td class="py-2">
                @if($item->mulai)
                    <a href="https://www.google.com/maps?q={{ $item->mulai->lokasi_latitude }},{{ $item->mulai->lokasi_longitude }}" 
                       target="_blank" class="text-blue-500 underline">
                       Lihat Lokasi
                    </a>
                @else
                    -
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="py-4 text-center text-gray-500">Belum ada riwayat kursus</td>
        </tr>
    @endforelse
</tbody>


        </table>
    </div>
@endsection
