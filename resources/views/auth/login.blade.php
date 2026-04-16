@extends('layouts.app')

@section('content')
    <section class="section section-muted">
        <div class="container">
            <div class="content-card" style="max-width: 480px;">
                <h1 class="page-title" style="margin-bottom: 1.5rem;">

                @if($isRegister ?? false)
                    <form method="POST" action="{{ route('register.member') }}" class="form-stack">
                        @csrf
                        <label>
                            Nama Lengkap
                            <input type="text" name="name" value="{{ old('name') }}" class="form-input" required>
                        </label>
                        <label>
                            Email
                            <input type="email" name="email" value="{{ old('email') }}" class="form-input" required autofocus>
                        </label>
<label>No HP (9-12 angka) <input type="tel" name="phone" value="{{ old('phone') }}"
                                class="form-input" minlength="9" maxlength="12" title="9-12 angka" required></label>
                        <label>
                            Alamat <input type="text" name="address" value="{{ old('address') }}" class="form-input"
                                required> </label>
                        <label class="password-group">
                            Password
                            <div class="password-input">
                                <input type="password" id="password" name="password" class="form-input" required minlength="6">
                                <button type="button" class="password-toggle" onclick="togglePassword('password')">👁</button>
                            </div>
                        </label>
                        <label class="password-group">
                            Konfirmasi Password
                            <div class="password-input">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-input" required minlength="6">
                                <button type="button" class="password-toggle"
                                    onclick="togglePassword('password_confirmation')">👁</button>
                            </div>
                        </label>
                        <label>
                            Pilih Layanan (pilih minimal 1)
                            <div class="services-checkboxes">
                                @foreach($services as $id => $name)
                                    <label class="service-checkbox">
                                        <input type="checkbox" name="selected_services[]" value="{{ $id }}" {{ in_array($id, old('selected_services', [])) ? 'checked' : '' }}>
                                        {{ $name }}
                                    </label>
                                @endforeach
                            </div>
                        </label>
                        @if($errors->any())
                            <p class="form-error">{{ $errors->first() }}</p>
                        @endif
                        @if(session('success'))
                            <p class="alert-success">{{ session('success') }}</p>
                        @endif
                        <button type="submit" class="btn-submit btn-block">Daftar</button>
                        <p style="text-align: center; margin-top: 1rem;">
                            Sudah punya akun? <a href="{{ route('login.member') }}">Masuk di sini</a>
                        </p>
                    </form>
                @else
                    <form method="POST" action="{{ $role === 'admin' ? route('login.admin') : route('login.member') }}" class="form-stack">
                        @csrf
                        <label>
                            Email
                            <input type="email" name="email" value="{{ old('email') }}" class="form-input" required autofocus>
                        </label>
                        <label class="password-group">
                            Password
                            <div class="password-input">
                                <input type="password" id="password-login" name="password" class="form-input" required>
                                <button type="button" class="password-toggle" onclick="togglePassword('password-login')">👁</button>
                            </div>
                        </label>
                        @if($errors->any())
                            <p class="form-error">{{ $errors->first() }}</p>
                        @endif
                        <button type="submit" class="btn-submit btn-block">Masuk</button>
                        @if($role === 'member')
                            <p style="text-align: center; margin-top: 1rem;">
                                Belum punya akun? <a href="{{ route('login.member') }}?register=1">Daftar di sini</a>
                            </p>
                        @endif
                    </form>
                @endif
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            function togglePassword(id) {
                const input = document.getElementById(id);
                const toggle = input.nextElementSibling;
                if (input.type === 'password') {
                    input.type = 'text';
                    toggle.textContent = '🙈';
                } else {
                    input.type = 'password';
                    toggle.textContent = '👁';
                }
            }
        </script>
    @endpush

    <style>
        .password-group {
            position: relative;
        }

        .password-input {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: var(--text-muted);
            padding: 0;
            line-height: 1;
        }

        .services-checkboxes {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            max-height: 200px;
            overflow-y: auto;
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--surface-soft);
        }

        .service-checkbox {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            font-weight: 500;
        }

        .service-checkbox input[type="checkbox"] {
            width: auto;
            margin: 0;
        }
    </style>
@endsection