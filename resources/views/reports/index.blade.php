@extends('apptwo')

@section('title', 'Reports - SMART PLUS')

@section('content')
<!-- Alpine.js for loading animation -->
<script src="//unpkg.com/alpinejs" defer></script>

<div class="bg-white p-4 rounded-xl shadow">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-2 mb-4">
        <h2 class="text-xl font-bold text-indigo-700">Report</h2>
        <div class="flex flex-col md:flex-row items-start md:items-center gap-2">
            <span class="text-gray-500 text-sm">
                Total Aktivitas:
                <span class="font-bold">{{ $totalActivities }}</span>
            </span>

            <form x-data="{ loading: false }" @submit="loading = true" action="{{ route('reports.export') }}" method="POST" class="flex gap-2 items-center">
                @csrf
                <input type="hidden" name="search" value="{{ request('search') }}">
                <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                <input type="hidden" name="course" value="{{ request('course') }}">
                <input type="number" name="jumlah_pertemuan" value="{{ request('jumlah_pertemuan') }}" placeholder="Jumlah Pertemuan"
                    class="border rounded p-2 text-sm w-40" min="1" />
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition" x-bind:disabled="loading">
                    <template x-if="!loading">Export</template>
                    <template x-if="loading">Loading...</template>
                </button>
            </form>
        </div>
    </div>

    <form action="{{ route('reports.index') }}" method="GET" class="flex flex-wrap gap-2 mb-4">
    <input
    id="search"
    type="text"
    name="search"
    value="{{ request('search') }}"
    class="border rounded p-2 flex-grow"
    placeholder="Cari Nama Siswa atau Orang Tua"
/>
<ul id="search-results" class="border bg-white rounded shadow absolute z-50 mt-1 hidden max-h-40 overflow-y-auto w-full"></ul>

        <input class="border rounded p-2" name="start_date" value="{{ request('start_date') }}" type="date"/>
        <input class="border rounded p-2" name="end_date" value="{{ request('end_date') }}" type="date"/>
        <select class="border rounded p-2" name="course">
            <option value="">Pilih Kursus</option>
            @foreach($courses as $course)
                <option value="{{ $course }}" {{ request('course') == $course ? 'selected' : '' }}>{{ $course }}</option>
            @endforeach
        </select>
        <input class="border rounded p-2 w-40" name="jumlah_pertemuan" value="{{ request('jumlah_pertemuan') }}" type="number" placeholder="Jumlah Pertemuan" min="1"/>
        <button class="border rounded p-2" type="submit" title="Filter">
            <i class="fas fa-search"></i>
        </button>
    </form>

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

    <!-- pagination -->
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
                            results += `<li class="p-2 hover:bg-gray-100 cursor-pointer" data-value="${item}">
                                            ${item}
                                        </li>`;
                        });

                        $('#search-results').html(results).removeClass('hidden');

                        // Klik hasil
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
