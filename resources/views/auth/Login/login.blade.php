@extends('auth.layouts.main')

@section('container')
<div class="bg-primary bg-gradient" style="min-height: 100vh;">
    <div class="container-fluid d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-md-4 col-lg-3">
            <div class="text-center mb-4">
                <img src="{{ asset('img/logo.jpeg') }}" alt="logo" class='rounded-circle shadow mb-3' width="96" height="96" style="object-fit: cover;" />
                <h1 class="text-white h3 fw-bold">
                    SPK SMART SKRIPSI
                </h1>
                <p class="text-white-50">Masuk ke akun Anda</p>
            </div>

            <div class="card shadow-lg border-0 rounded-3">


                <div class="card-body p-4">
                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input name="email" type="email" required value="{{ old('email') }}"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="Masukkan Email" />
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input id="password" name="password" type="password" required
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Masukkan Password" />
                                <button type="button" id="togglePassword" class="btn btn-outline-secondary">
                                    <i id="eyeOpen" class="fas fa-eye"></i>
                                    <i id="eyeClosed" class="fas fa-eye-slash d-none"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Masuk
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <p class="mb-0">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">
                                Daftar disini
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
