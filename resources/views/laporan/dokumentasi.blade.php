@extends('app')

@section('content')
<!-- <pre>{{ print_r($jadwal, true) }}</pre> -->
<div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg mt-10">
    <h2 class="text-2xl font-bold mb-4">Input Dokumentasi</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(request('jadwal') && request('id_mulai'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
        <strong>ID berhasil dikirim!</strong><br>
        ID Jadwal: {{ request('jadwal') }} <br>
        ID Mulai: {{ request('id_mulai') }}
    </div>
@endif


    <form action="{{ route('dokumentasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <!-- Input for id_jadwal -->
    <input type="hidden" name="id_jadwal" value="{{ request('jadwal') }}">
    <input type="hidden" name="id_mulai" value="{{ request('id_mulai') }}">


    <!-- Field untuk penguasaan siswa dan feedback tentor tetap seperti sebelumnya -->
    <div>
        <label class="block font-semibold">Aktivitas Siswa</label>
        <input type="text" name="penguasaan_siswa" class="w-full p-2 border rounded" placeholder="Contoh: Aljabar, Algoritma, dll" required>
    </div>

    <div>
        <label class="block font-semibold">Feedback Tentor</label>
        <textarea name="feedback_tentor" rows="4" class="w-full p-2 border rounded" placeholder="Masukkan feedback dari tentor" required></textarea>
    </div>

    <!-- Field untuk upload foto dan video -->
    <div>
        <label class="block font-semibold">Upload Foto</label>
        <input type="file" name="foto[]" id="fotoInput" accept="image/*" class="w-full p-2 border rounded" multiple>
        <div id="fotoPreviewContainer" class="mt-2 flex space-x-4"></div>
    </div>

    <div>
       <label class="block font-semibold">Upload Video</label>
       <input type="file" name="video" id="videoInput" accept="video/*" class="w-full p-2 border rounded">
       <video id="videoPreview" class="mt-2 rounded hidden" style="max-height: 150px; width: auto;" controls></video>
    </div>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Simpan Dokumentasi
    </button>
</form>

</div>

{{-- Script Preview --}}
<script>
    const fotoInput = document.getElementById('fotoInput');
    const fotoPreviewContainer = document.getElementById('fotoPreviewContainer');
    const videoInput = document.getElementById('videoInput');
    const videoPreview = document.getElementById('videoPreview');

    fotoInput.addEventListener('change', function () {
        fotoPreviewContainer.innerHTML = ''; // Clear previous previews

        const files = this.files;
        if (files) {
            Array.from(files).forEach(file => {
                const fileURL = URL.createObjectURL(file);
                
                // Create an image preview element
                const img = document.createElement('img');
                img.src = fileURL;
                img.classList.add('rounded', 'max-h-32', 'w-auto');
                
                // Append the image preview to the container
                fotoPreviewContainer.appendChild(img);
            });
        }
    });

    videoInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            videoPreview.src = URL.createObjectURL(file);
            videoPreview.classList.remove('hidden');
        }
    });
</script>

@endsection
