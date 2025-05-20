@extends('apptwo')

@section('title', 'Reports - SMART PLUS')

@section('content')
<script src="//unpkg.com/alpinejs" defer></script>

<div class="bg-white p-4 rounded-xl shadow">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-2 mb-4">
        <h2 class="text-xl font-bold text-indigo-700">Report</h2>
        <span class="text-gray-500 text-sm">
            Total Aktivitas:
            <span class="font-bold">{{ $totalActivities }}</span>
        </span>
    </div>

    <!-- Form pencarian utama -->
    <form action="{{ route('reports.index') }}" method="GET" class="flex flex-col md:flex-row md:items-center md:space-x-2 space-y-2 md:space-y-0 mb-4">
        <input
            id="search"
            type="text"
            name="search"
            value="{{ request('search') }}"
            class="border rounded p-2 w-full md:w-1/2"
            placeholder="Cari Nama Siswa atau Orang Tua"
        />
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded w-full md:w-auto">
            Cari
        </button>
    </form>

    <!-- Form filter tambahan -->
    <!-- Form filter tambahan -->
@if(request('search'))
<form
    x-data="{ loading: false }"
    @submit="loading = true"
    action="{{ route('reports.export') }}"
    method="GET"
    class="bg-white p-4 rounded-xl shadow-md flex flex-col md:flex-row md:items-center gap-4 mb-6"
>
    <input type="hidden" name="search" value="{{ request('search') }}"/>

    <!-- Dropdown Kursus -->
    <div class="w-full md:w-auto">
        <label class="block text-sm font-medium text-gray-700 mb-1">Kursus</label>
        <select
            name="course"
            class="w-full md:w-48 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
        >
            <option value="">Pilih Kursus</option>
            @foreach($courses as $course)
                <option value="{{ $course }}" {{ request('course') == $course ? 'selected' : '' }}>
                    {{ $course }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Jumlah Pertemuan -->
    <div class="w-full md:w-auto">
        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Pertemuan</label>
        <input
            type="number"
            name="jumlah_pertemuan"
            value="{{ request('jumlah_pertemuan') }}"
            placeholder="Contoh: 4"
            class="w-full md:w-40 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
            min="1"
        />
    </div>

    <!-- Tombol -->
    <div class="flex flex-col md:flex-row gap-2 w-full md:w-auto pt-2 md:pt-6">
        <button
            formaction="{{ route('reports.index') }}"
            formmethod="GET"
            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition font-semibold mr-4"
        >
            Terapkan
        </button>
        <button 
            type="submit"
            class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition font-semibold flex items-center justify-center"
            x-bind:disabled="loading">
            <template x-if="!loading">
                <span class="flex items-center gap-2">
                    <i class="fas fa-file-export"></i>Export
                </span>
            </template>
            <template x-if="loading">
                <span>Loading...</span>
            </template>
        </button>
    </div>
</form>
@endif

    <!-- Tabel hasil -->
    <div class="overflow-x-auto rounded-lg">
        <table class="min-w-full border-collapse text-sm">
            <thead>
                <tr class="bg-indigo-100 text-gray-700">
                    <th class="border p-3 text-center rounded-tl-lg">Nomor</th>
                    <th class="border p-3">Aktivitas</th>
                    <th class="border p-3">Tentor</th>
                    <th class="border p-3 text-center rounded-tr-lg">Harga</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities as $activity)
                    <tr class="even:bg-gray-50">
                        <td class="border p-3 text-center">{{ $activity->id_selesai }}</td>
                        <td class="border p-3 break-words">
                            <p><strong>Tanggal:</strong> {{ $activity->waktu_akhir }}</p>
                            <p><strong>Kursus:</strong> {{ $activity->nama_kursus }}</p>
                            <p><strong>Aktivitas:</strong> {{ $activity->penguasaan_siswa }}</p>
                            <p><strong>Feedback Tentor:</strong> {{ $activity->feedback_tentor }}</p>
                        </td>
                        <td class="border p-3 break-words">{{ $activity->nama_tentor }}</td>
                        <td class="border p-3 text-center">{{ $activity->harga_kursus }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="border p-3 text-center text-gray-500">No activities found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $activities->withQueryString()->links() }}
    </div>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#search').on('input', function () {
            const query = $(this).val();
            if (query.length >= 2) {
                $.ajax({
                    url: '{{ route("reports.autocomplete") }}',
                    method: 'GET',
                    data: { search: query },
                    success: function (data) {
                        let results = '';
                        data.forEach(item => {
                            results += `<li class="p-2 hover:bg-gray-100 cursor-pointer" data-value="${item}">${item}</li>`;
                        });
                        $('#search-results').html(results).removeClass('hidden');
                        $('#search-results li').on('click', function () {
                            $('#search').val($(this).data('value'));
                            $('#search-results').addClass('hidden');
                        });
                    }
                });
            } else {
                $('#search-results').addClass('hidden');
            }
        });

        $(document).on('click', function (e) {
            if (!$(e.target).closest('#search').length) {
                $('#search-results').addClass('hidden');
            }
        });
    });
</script>
@endpush
@endsection
