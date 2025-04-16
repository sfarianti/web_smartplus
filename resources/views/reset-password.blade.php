<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <!-- Pastikan menambahkan Font Awesome untuk ikon mata -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-box">
            <p class="quote">Silakan masukkan password baru Anda.</p>

            @if (session('status'))
                <div class="alert success">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="input-group">
                    <input type="email" name="email" value="{{ $email }}" required placeholder="Alamat Email" readonly>
                </div>

                <div class="input-group" style="position: relative;">
                    <input type="password" name="password" id="password" required placeholder="Password Baru" minlength="6">
                    <i class="fas fa-eye" id="toggle-password" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                </div>

                <!-- Input Konfirmasi Password dengan ikon mata -->
                <div class="input-group" style="position: relative;">
                    <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Konfirmasi Password">
                    <i class="fas fa-eye" id="toggle-password-confirm" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                </div>

                <button class="login-button" type="submit">Reset Password</button>
            </form>

            <div class="forgot">
                <a href="{{ route('login') }}">Kembali ke Login</a>
            </div>
        </div>
    </div>
    <script>
        // Toggle password visibility for password field
        const togglePassword = document.getElementById('toggle-password');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function (e) {
            // Toggle the type of the input
            const type = password.type === 'password' ? 'text' : 'password';
            password.type = type;
            // Toggle the eye icon
            this.classList.toggle('fa-eye-slash');
        });

        // Toggle password visibility for password confirmation field
        const togglePasswordConfirm = document.getElementById('toggle-password-confirm');
        const passwordConfirm = document.getElementById('password_confirmation');

        togglePasswordConfirm.addEventListener('click', function (e) {
            // Toggle the type of the input
            const type = passwordConfirm.type === 'password' ? 'text' : 'password';
            passwordConfirm.type = type;
            // Toggle the eye icon
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
