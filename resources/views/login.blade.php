<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-box">
            <div class="profile-pic" id="profileImage" style="
                background-image: url('/default-user.png');
                background-size: cover;
                background-position: center;
            "></div>

            <p class="quote" id="loginQuote">Log in and begin your teaching journey!</p>

            <form method="POST" action="/login">
                @csrf

                <div class="input-group">
                    <span class="icon">👤</span>
                    <input type="text" name="username" id="username" placeholder="User Name" readonly>
                </div>

                <div class="input-group" style="position: relative;">
                    <span class="icon">🔒</span>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <i class="fa-solid fa-eye toggle-password" id="eyeIcon" style="
                        position: absolute;
                        right: 15px;
                        top: 50%;
                        transform: translateY(-50%);
                        font-size: 18px;
                        cursor: pointer;
                        color: #888;
                    "></i>
                </div>

                <div class="forgot">
                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                </div>
                

                <button class="login-button" type="submit">Sign in</button>
            </form>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const usernameInput = document.getElementById('username');
        const profileImage = document.getElementById('profileImage');
        const loginQuote = document.getElementById('loginQuote');
        const eyeIcon = document.getElementById('eyeIcon');

        eyeIcon.addEventListener('click', function () {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });

        passwordInput.addEventListener('input', function () {
            const password = this.value;

            if (password.length > 0) {
                fetch('/get-user-by-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ password })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.username) {
                        usernameInput.value = data.username;
                        loginQuote.innerText = `Welcome, ${data.username}!`;
                        if (data.foto_tentor) {
                            profileImage.style.backgroundImage = `url('/storage/${data.foto_tentor}')`;
                        } else {
                            profileImage.style.backgroundImage = `url('/default-user.png')`;
                        }
                    } else {
                        resetLoginUI();
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    resetLoginUI();
                });
            } else {
                resetLoginUI();
            }
        });

        function resetLoginUI() {
            usernameInput.value = '';
            profileImage.style.backgroundImage = `url('/default-user.png')`;
            loginQuote.innerText = 'Log in and begin your teaching journey!';
        }
    </script>
</body>
</html>