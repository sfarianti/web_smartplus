<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #2c3e50;
        }
        .button {
            background-color: #f39c12;
            color: white;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }
        .footer {
            margin-top: 40px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Password Akun Tentor</h2>

        <p>Halo,</p>
        <p>Kami menerima permintaan untuk reset password akun Anda.</p>

        <p>Silakan klik tombol di bawah ini untuk mengatur ulang password Anda:</p>

        <p style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/reset-password/'.$token) }}" class="button">
                Reset Password
            </a>
        </p>

        <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>

        <p class="footer">Salam,<br><strong>Tim {{ config('LBB SMART PLUS') }}</strong></p>
    </div>
</body>
</html>
