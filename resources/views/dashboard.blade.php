 @extends('app')
 @section('content')
            <main class="bg-white-300 flex-1 p-3 overflow-hidden">
                <div class="flex flex-col">
                    <div class="flex flex-1 flex-col md:flex-row lg:flex-row mx-2">
                    <div class="shadow-lg bg-red-vibrant border-l-8 hover:bg-red-vibrant-dark border-red-vibrant-dark mb-2 p-2 md:w-1/2 mx-2 rounded-lg">
                        <div class="p-4 flex flex-col">
                            <!-- <a href="{{ route('today.course') }}" class="no-underline text-white text-2xl">{{ $todayCourses }}</a> -->
                            <a href="{{ route('today.course') }}" class="no-underline text-white text-lg">Today Course</a>
                        </div>
                    </div>

                        <!-- <div class="shadow bg-info border-l-8 hover:bg-info-dark border-info-dark mb-2 p-2 md:w-1/4 mx-2 rounded-lg">
                            <div class="p-4 flex flex-col">
                                <a href="#" class="no-underline text-white text-2xl">{{ $tomorrowCourses }}</a>
                                <a href="#" class="no-underline text-white text-lg">Tomorrow Course</a>
                            </div>
                        </div>
                        <div class="shadow bg-warning border-l-8 hover:bg-warning-dark border-warning-dark mb-2 p-2 md:w-1/4 mx-2 rounded-lg">
                            <div class="p-4 flex flex-col">
                                <a href="#" class="no-underline text-white text-2xl">{{ $monthlyCourses }}</a>
                                <a href="#" class="no-underline text-white text-lg">Monthly Course</a>
                            </div>
                        </div> -->
                        <div class="shadow bg-success border-l-8 hover:bg-success-dark border-success-dark mb-2 p-2 md:w-1/2 mx-2 rounded-lg">
                            <div class="p-4 flex flex-col">
                                <!-- <a href="#" class="no-underline text-white text-2xl">{{ $historyCourses }}</a> -->
                                <a href="#" class="no-underline text-white text-lg">History Course</a>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-1 flex-col md:flex-row lg:flex-row mx-2">
                        <div class="rounded overflow-hidden shadow bg-white mx-2 w-full">
                            <div class="px-6 py-2 border-b border-light-grey">
                                <div class="font-bold text-xl">Announcements</div>
                            </div>
                        </div>
                    </div>

                    
        <!-- Pengumuman -->
        <div class="card mt-4 shadow-lg rounded-lg">
            <div class="card-header bg-gray-200 p-4">
                <h3 class="text-xl font-semibold">Latest Announcements</h3>
            </div>
            <div class="card-body p-4">
                @if($pengumuman->count() > 0)
                    <ul class="list-group space-y-4">
                        @foreach($pengumuman as $item)
                        <li class="list-group-item bg-gray-100 p-4 rounded-lg relative">
                            <strong class="text-lg">{{ $item->judul_pengumuman }}</strong><br>
                            <!-- Pindahkan tanggal di bawah judul -->
                            <small class="text-xs text-black font-light">
                                {{ \Carbon\Carbon::parse($item->tgl_pengumuman)->format('d M Y') }}
                            </small>
                            <p class="mt-2">Deskripsi: {{ $item->detail_pengumuman }}</p>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-center text-gray-500">Tidak ada pengumuman saat ini.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
