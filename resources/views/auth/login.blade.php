<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Masuk Sistem - SICAKAP Satpam & Caraka</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <style>
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
            position: relative;
        }

        .login-card {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-xl);
            max-width: 460px;
            width: 100%;
            padding: 2.25rem 2rem;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.8), 0 0 40px rgba(99, 102, 241, 0.15);
            position: relative;
            z-index: 10;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-logo {
            width: 76px;
            height: 76px;
            margin: 0 auto 1.25rem;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(6, 182, 212, 0.3);
            padding: 8px;
            overflow: hidden;
            transition: all 0.25s ease;
        }

        .login-logo:hover {
            transform: scale(1.05);
            border-color: rgba(6, 182, 212, 0.4);
            box-shadow: 0 12px 35px rgba(6, 182, 212, 0.45);
        }

        .login-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.25));
        }



        .input-icon-wrapper {
            position: relative;
        }

        .input-icon-wrapper input {
            padding-left: 2.75rem;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            pointer-events: none;
        }

        .password-toggle-btn {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        <div class="login-card">
            
            <!-- Header Brand -->
            <div class="login-header">
                <div class="login-logo">
                    <img src="{{ asset('images/logo-emblem.png') }}" alt="SICAKAP Logo">
                </div>
                <h1 style="font-size:1.4rem; font-weight:800; color:#fff; letter-spacing:-0.02em;">SICAKAP SATPAM & CARAKA</h1>
                <p style="font-size:0.825rem; color:var(--text-muted); margin-top:4px;">
                    Portal Presensi & Keamanan Terpadu
                </p>
            </div>

            @if(session('success'))
                <div class="alert-banner alert-success" style="font-size:0.825rem; padding:0.75rem 1rem;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert-banner alert-danger" style="font-size:0.825rem; padding:0.75rem 1rem;">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->has('login'))
                <div class="alert-banner alert-danger" style="font-size:0.825rem; padding:0.75rem 1rem;">
                    {{ $errors->first('login') }}
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login.post') }}" method="POST" id="loginForm">
                @csrf

                <!-- NIP atau Email -->
                <div class="form-group">
                    <label class="form-label">NIP atau Email Dinas:</label>
                    <div class="input-icon-wrapper">
                        <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <input type="text" name="login" id="loginInput" class="form-control" 
                            placeholder="Contoh: ADM-2024-001 atau email" 
                            value="{{ old('login') }}" required autofocus>
                    </div>
                    <small style="color:var(--text-muted); font-size:0.725rem; margin-top:3px; display:block;">
                        Anda dapat login menggunakan NIP personil atau alamat email.
                    </small>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label class="form-label">Kata Sandi:</label>
                    <div class="input-icon-wrapper" style="margin-top:0.4rem;">
                        <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Masukkan kata sandi..." required>
                        <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility()">
                            <svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:1.5rem;">
                    <input type="checkbox" name="remember" id="rememberMe" style="accent-color:var(--indigo-primary); cursor:pointer;">
                    <label for="rememberMe" style="font-size:0.825rem; color:var(--text-secondary); cursor:pointer; user-select:none;">
                        Ingat saya di perangkat ini
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-absen" style="width:100%; min-height:52px; background:linear-gradient(135deg, var(--indigo-primary) 0%, #4338ca 100%); color:#fff; font-size:1.05rem; box-shadow:0 8px 25px rgba(99, 102, 241, 0.4);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg>
                    Masuk ke Sistem
                </button>
            </form>



        </div>
    </div>

    <script>


        function togglePasswordVisibility() {
            const pwd = document.getElementById('passwordInput');
            const btn = document.querySelector('.password-toggle-btn');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                btn.innerHTML = `<svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>`;
                btn.setAttribute('title', 'Sembunyikan Kata Sandi');
            } else {
                pwd.type = 'password';
                btn.innerHTML = `<svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>`;
                btn.setAttribute('title', 'Lihat Kata Sandi');
            }
        }
    </script>
</body>
</html>
