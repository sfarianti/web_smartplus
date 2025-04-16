<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile Admin</title>
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
        .welcome-message {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="profile-card">
        <div class="header">
            <p class="welcome-message">Welcome, change your data here!</p>
        </div>

        <form method="POST" action="{{ route('profileadmin.update') }}" enctype="multipart/form-data">
            @csrf

            {{-- ROW 1: NAME & PASSWORD --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="username">Name</label>
                    <!-- Tampilkan username dari session -->
                    <input type="text" id="username" name="username" value="{{ $user->username ?? '' }}">
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
                <a href="{{ route('profileadmin.edit') }}" class="modal-button yes">Yes</a>
                <a href="{{ route('dashboardAdmin') }}" class="modal-button no">No</a>
            </div>
        </div>
    </div>
    @endif

</body>
</html>