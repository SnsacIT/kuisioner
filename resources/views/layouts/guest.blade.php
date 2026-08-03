<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Login ke aplikasi Sistem Kuisioner.">

    <title>Login Sistem Kuisioner | SNS.AC</title>

    <link rel="icon" href="{{ asset(config('app.favicon')) }}">
    <link rel="apple-touch-icon" href="{{ asset(config('app.favicon')) }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">

    {{-- Styles & Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/app.js') }}"></script>
</head>

<body style="background: linear-gradient(135deg, #0d6efd, #6EC6FF);">
    {{-- <x-loading-overlay /> --}}
    <main class="container min-vh-100 d-flex flex-column justify-content-center">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ asset('assets/img/logo-sns.png') }}" alt="Logo SNS.AC"
                        class="card-img-top mx-auto mt-4" style="width: 250px; height: auto;">

                    <div class="card-body">
                        <form action="{{ route('login.post') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-bold" for="nip">NIP</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input value="{{ old('nip') }}" type="text" inputmode="numeric" pattern="[0-9]*" class="form-control" name="nip"
                                        id="nip" placeholder="Masukkan NIP" autocomplete="username" required>
                                </div>
                            </div>
                            @error('nip')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="mb-3">
                                <label class="form-label fw-bold" for="password">Password</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control" name="password" id="password"
                                        placeholder="Masukkan Password" autocomplete="current-password" required>
                                    <span class="input-group-text" style="cursor:pointer" id="togglePassword"><i
                                            class="bi bi-eye" id="iconEye"></i></span>
                                </div>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="mb-3 form-check text-start">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Ingat Saya</label>
                            </div>

                            <div class="mt-4 mb-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    Masuk Aplikasi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center text-white mt-4">
            &copy; {{ date('Y') }} SNS.AC Sistem Kuisioner. <br>All rights reserved.
        </div>
    </main>
</body>

</html>