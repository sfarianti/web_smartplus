@extends('apptwo')
@section('content')
<main class="bg-white-300 flex-1 p-3 overflow-hidden">
                <div class="flex flex-col">
                    <div class="flex flex-1 flex-col md:flex-row lg:flex-row mx-3">
                    <div class="shadow-lg bg-red-vibrant border-l-8 hover:bg-red-vibrant-dark border-red-vibrant-dark mb-2 p-2 md:w-1/3 mx-2 rounded-lg">
                        <div class="p-4 flex flex-col">
                            <a href="#" class="no-underline text-white text-2xl">0</a>
                            <a href="#" class="no-underline text-white text-lg">Total Students</a>
                        </div>
                    </div>

                        <div class="shadow bg-info border-l-8 hover:bg-info-dark border-info-dark mb-2 p-2 md:w-1/3 mx-2 rounded-lg">
                            <div class="p-4 flex flex-col">
                                <a href="#" class="no-underline text-white text-2xl">{{ $totalTeachers }}</a>
                                <a href="#" class="no-underline text-white text-lg">Total Teachers</a>
                            </div>
                        </div>
                        <div class="shadow bg-warning border-l-8 hover:bg-warning-dark border-warning-dark mb-2 p-2 md:w-1/3 mx-2 rounded-lg">
                        <div class="p-4 flex flex-col">
                            <a href="{{ route('course.view') }}" class="no-underline text-white text-2xl">{{ $totalCourses }}</a>
                            <a href="{{ route('course.view') }}" class="no-underline text-white text-lg">Total Course</a>
                        </div>
                        </div>
                    </div>

                     <!-- Pengumuman -->
        <div class="flex flex-1 flex-col md:flex-row lg:flex-row mx-2">
            <div class="rounded overflow-hidden shadow bg-white mx-2 w-full">
                <div class="px-6 py-2 border-b border-light-grey">
                    <div class="font-bold text-xl">📢 Announcements</div>
                </div>

                <!-- Tombol Tambah -->
                <div class="flex justify-end mb-6 px-1">
                    <a href="{{ route('pengumuman.create') }}" class="flex items-center bg-blue-700 text-white px-2 py-1 rounded-md shadow-md hover:bg-blue-800 transition-all no-underline">
                        <span class="mr-2 text-sm">➕</span> <span class="text-md">Add Announcement</span>
                    </a>
                </div>

                <!-- Daftar Pengumuman -->
                <div class="space-y-6 px-6 pb-6">
                    @forelse ($pengumuman as $item)
                        <div class="p-8 bg-white rounded-lg shadow-md flex justify-between items-center border border-gray-300">
                            <div class="flex flex-col gap-4">
                                <h2 class="text-xl font-semibold text-gray-800">{{ $item->judul_pengumuman }}</h2>
                                <p class="text-gray-600 text-base leading-relaxed">{{ $item->detail_pengumuman }}</p>
                            </div>
                            <div class="flex flex-col items-end">
                                <span class="text-gray-500 text-sm mb-3">{{ \Carbon\Carbon::parse($item->tanggal_pengumuman)->format('d M Y') }}</span>
                                <div class="flex space-x-4">
                                    <a href="{{ route('pengumuman.edit', $item->id_pengumuman) }}" class="text-blue-500 hover:text-blue-700 text-2xl no-underline">✏️</a>
                                    <form action="{{ route('pengumuman.destroy', $item->id_pengumuman) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-2xl no-underline">🗑️</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-400 py-6 text-lg">Tidak ada pengumuman</p>
                    @endforelse
                </div>
            </div>
        </div>
                </div>
            </main>
        </div>
    </div>
</div>
@endsection