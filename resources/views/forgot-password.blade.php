<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-box">
            <p class="quote">Lupa password? Masukkan email untuk menerima link reset.</p>

            @if (session('status'))
                <div class="alert success">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="input-group">
                    <span class="icon">📧</span>
                    <input type="email" name="email" placeholder="Alamat Email" required>
                </div>
                <button class="login-button" type="submit">Kirim Link Reset</button>
                <div class="forgot">
                    <a href="{{ route('login') }}">Kembali ke Login</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
