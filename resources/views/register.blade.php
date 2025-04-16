<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Tentor</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
        }

        .profile-photo {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-bottom: 20px;
        }

        .circle {
            width: 120px;
            height: 120px;
            background-color: #ccc;
            border-radius: 50%;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            overflow: hidden;
        }

        .circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .camera-icon {
            position: absolute;
            bottom: 10px;
            right: 10px;
            font-size: 22px;
            color: blue;
            background: white;
            border-radius: 50%;
            padding: 5px;
            pointer-events: none;
        }

        input[type="file"] {
            display: none;
        }

        .alert {
            background-color: #ffe0e0;
            border-left: 5px solid #72a5df;
            padding: 10px 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            font-size: 14px;
            color: #3aa8d7;
        }
    </style>
</head>
<body>
    <div class="register-wrapper">
        <div class="header">
            <img src="{{ asset('img/logo.png') }}" alt="Logo">
            <h2>SMART PLUS</h2>
            <h3>Selamat Datang</h3>
            <p>Mau Pintar? Ke Smart Plus Aja!</p>
        </div>

        <!-- Notifikasi Error -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORM -->
        <form method="POST" action="{{ route('register.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Foto Profil -->
            <div class="profile-photo">
                <label for="foto_tentor">
                    <div class="circle">
                        <img id="preview-image" src="{{ asset('img/default.png') }}" alt="">
                        <i class="fa-solid fa-camera camera-icon"></i>
                    </div>
                </label>
                <input type="file" name="foto_tentor" id="foto_tentor" accept="image/*" required>
            </div>

            <!-- Grid Form -->
            <div class="form-grid">
                <!-- KIRI -->
                <div class="form-column">
                    <label>Nama Tentor</label>
                    <input type="text" name="nama_tentor" required>

                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" required>

                    <label>Pendidikan Terakhir</label>
                    <select name="pendidikan_terakhir" required>
                        <option value="">-- Pilih --</option>
                        <option value="D3">D3</option>
                        <option value="D4/S1">D4/S1</option>
                        <option value="S2">S2</option>
                        <option value="S3">S3</option>
                    </select>

                    <label>Rekening</label>
                    <input type="text" name="rekening" required>

                    <label>Hak Akses</label>
                    <input type="text" name="role" value="tentor" readonly>
                </div>

                <!-- KANAN -->
                <div class="form-column">
                    <label>Awal Gabung</label>
                    <input type="date" name="awal_gabung" value="{{ old('awal_gabung', date('Y-m-d')) }}" readonly>

                    <label>Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" required>
                        <i class="fa-solid fa-eye toggle-password" onclick="togglePassword()"></i>
                    </div>

                    <label>Akademik</label>
                    <input type="text" name="akademik" required>

                    <label>Non Akademik</label>
                    <input type="text" name="non_akademik" required>

                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
            </div>

            <!-- BUTTON -->
            <button type="submit" class="submit-btn">REGISTER</button>
        </form>
    </div>

    <!-- Script JS -->
    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.querySelector('.toggle-password');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Preview gambar otomatis
        document.getElementById('foto_tentor').addEventListener('change', function(event) {
            const input = event.target;
            const preview = document.getElementById('preview-image');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        });

        // MessageBox setelah register sukses
        window.addEventListener('DOMContentLoaded', function() {
            const query = new URLSearchParams(window.location.search);
            if (query.get('success') === 'true') {
                const confirmBox = confirm("Registration successful! Would you like to register another user?");
                if (confirmBox) {
                    window.location.href = "/register";
                } else {
                    window.location.href = "/dashboardAdmin";
                }
            }
        });
    </script>
</body>
</html>