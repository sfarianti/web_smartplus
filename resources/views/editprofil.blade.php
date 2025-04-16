<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="{{ asset('css/editprofil.css') }}">
    <style>
        .eye-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 16px;
        }
        .input-wrapper {
            position: relative;
        }
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
        }
        .form-group {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        label span {
            font-size: 12px;
            color: gray;
        }
    </style>
</head>
<body>
    <div class="profile-card">
        <div class="header">
            <img src="{{ $tentor->foto_tentor ? asset('storage/' . $tentor->foto_tentor) : asset('img/default-avatar.png') }}" alt="Profile">
        </div>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf

            {{-- ROW 1: NAME & PASSWORD --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="nama_tentor">Name</label>
                    <input type="text" id="nama_tentor" name="nama_tentor" value="{{ $tentor->nama_tentor ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="password">
                        Password <span>(kosongkan jika tidak diubah)</span>
                    </label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" placeholder="Masukkan password baru">
                        <span class="eye-icon" onclick="togglePassword()">👁️</span>
                    </div>
                </div>
            </div>

            {{-- ROW 2: AKADEMIK & NON-AKADEMIK --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="akademik">Akademik</label>
                    <input type="text" id="akademik" name="akademik" value="{{ $tentor->akademik ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="non_akademik">Non Akademik</label>
                    <input type="text" id="non_akademik" name="non_akademik" value="{{ $tentor->non_akademik ?? '' }}">
                </div>
            </div>

            {{-- ROW 3: REKENING --}}
            <div class="form-row">
                <div class="form-group" style="width: 100%;">
                    <label for="rekening">Nomor Rekening</label>
                    <input type="text" id="rekening" name="rekening" value="{{ $tentor->rekening ?? '' }}">
                </div>
            </div>

            {{-- ROW 4: FOTO --}}
            <div class="form-row">
                <div class="form-group" style="width: 100%;">
                    <label for="foto_tentor">Ubah Foto (opsional)</label>
                    <input type="file" id="foto_tentor" name="foto_tentor" accept="image/*">
                </div>
            </div>

            {{-- TOMBOL --}}
            <button type="submit" class="update-button">UPDATE</button>
        </form>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById("password");
            input.type = input.type === "password" ? "text" : "password";
        }
    </script>

@if(session('success'))
<div id="successModal" class="modal-overlay">
    <div class="modal-box">
        <p class="modal-text">Your data has been successfully updated!<br>Do you want to make more edits?</p>
        <div class="modal-actions">
            <a href="{{ route('profile.edit') }}" class="modal-button yes">Yes</a>
            <a href="{{ route('dashboardAdmin') }}" class="modal-button no">No</a>
        </div>
    </div>
</div>
@endif

</body>
</html>