<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Login</title>

    @include('includes.editor.style')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .login-card {
            background: white;
            padding: 2.5rem 3rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            width: 360px;
            text-align: center;
        }

        .login-card img.logo {
            width: 90px;
            margin-bottom: 1.2rem;
        }

        .login-card h2 {
            margin-bottom: 1.5rem;
            color: #4e73df;
            font-weight: 700;
        }

        .input-group {
            margin-bottom: 1.3rem;
        }

        .input-group-text {
            background-color: #4e73df;
            border: none;
            color: white;
            border-radius: 50px 0 0 50px;
        }

        .form-control-user {
            border-radius: 50px;
            padding: 0.9rem 1.3rem;
            font-size: 1rem;
            border: 1.8px solid #ccc;
            transition: border-color 0.3s ease;
        }

        .form-control-user:focus {
            border-color: #4e73df;
            box-shadow: 0 0 6px rgba(102, 126, 234, 0.5);
        }

        .btn-primary {
            width: 100%;
            padding: 0.8rem;
            font-size: 1.1rem;
            border-radius: 50px;
            font-weight: 600;
            background-color: #667eea;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #5a67d8;
        }
        
        /* Gaya tambahan untuk pesan validasi per field */
        .invalid-feedback {
            display: block; /* Pastikan selalu terlihat */
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
            text-align: left; /* Biar rata kiri */
            padding-left: 10px; /* Sedikit indentasi */
        }
    </style>
</head>

<body>
    <div class="login-card">
        <img src="{{asset('template_admin/img/tutwuri.jpg')}}" alt="Logo SD Negeri 05 Taman" class="logo" />
        <h2>Login Admin</h2>

        {{-- Tampilkan pesan LoginError di atas form --}}
        @if(session()->has('LoginError'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="font-size: 0.9rem;">
                {{ session('LoginError') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <form method="POST" action="{{ route('login.auth') }}">
            @csrf
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                {{-- Tambahkan kelas is-invalid dan old() untuk input --}}
                <input type="email" name="email" class="form-control form-control-user @error('email') is-invalid @enderror" placeholder="Email" required value="{{ old('email') }}" />
                {{-- Tampilkan pesan error validasi spesifik untuk field email --}}
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                {{-- Tambahkan kelas is-invalid untuk input --}}
                <input type="password" name="password" class="form-control form-control-user @error('password') is-invalid @enderror" placeholder="Password" required />
                {{-- Tampilkan pesan error validasi spesifik untuk field password --}}
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>

    @include('includes.editor.script')

</body>

</html>