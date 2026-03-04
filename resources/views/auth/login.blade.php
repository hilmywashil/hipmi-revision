@extends('layouts.auth')

@section('title', (Request::is('admin/login') ? 'Login Admin' : 'Login Anggota') . ' - HIPMI Jawa Barat')

@section('content')
<style>
  /* Alert Styles */
  .alert {
    padding: 1rem 1.25rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    animation: slideDown 0.3s ease;
    font-size: 0.9375rem;
    line-height: 1.5;
  }

  @keyframes slideDown {
    from {
      opacity: 0;
      transform: translateY(-10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .alert-error {
    background: #fee2e2;
    border: 1px solid #fca5a5;
    color: #991b1b;
  }

  .alert-warning {
    background: #fef3c7;
    border: 1px solid #fcd34d;
    color: #92400e;
  }

  .alert-success {
    background: #d1fae5;
    border: 1px solid #6ee7b7;
    color: #065f46;
  }

  .alert-icon {
    font-size: 1.25rem;
    line-height: 1;
    flex-shrink: 0;
  }

  .alert-message {
    flex: 1;
  }

  .alert-close {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    margin: 0;
    color: inherit;
    opacity: 0.6;
    font-size: 1.25rem;
    line-height: 1;
    transition: opacity 0.2s;
    flex-shrink: 0;
  }

  .alert-close:hover {
    opacity: 1;
  }

  .login-type-badge {
    display: inline-block;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 10px;
  }

  .badge-admin {
    background: #e3f2fd;
    color: #1565c0;
  }

  .badge-anggota {
    background: #f3e5f5;
    color: #6a1b9a;
  }

  .login-switch {
    text-align: center;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #e0e0e0;
  }

  .login-switch a {
    color: #667eea;
    font-weight: 600;
    text-decoration: none;
    font-size: 14px;
  }

  .login-switch a:hover {
    text-decoration: underline;
  }
</style>

@php
  $isAdmin = Request::is('admin/login');
  $loginType = $isAdmin ? 'admin' : 'anggota';
  $loginTitle = $isAdmin ? 'Login Admin' : 'Login Anggota';
  $loginAction = $isAdmin ? route('admin.login.post') : route('anggota.login.post');
  $inputLabel = $isAdmin ? 'Nama Pengguna atau Alamat Email' : 'Email';
  $inputType = $isAdmin ? 'text' : 'email';
  $inputName = $isAdmin ? 'login' : 'email';
  $badgeClass = $isAdmin ? 'badge-admin' : 'badge-anggota';
@endphp

<section class="login-page">
  <div class="login-card">
    <div class="login-left">
      <div class="brand">
        <a href="{{ route('home') }}">
          <img class="brand__logo" src="{{ asset('images/hipmi-logo.png') }}" alt="Logo HIMPI">
        </a>
        <a href="{{ route('home') }}">
          <img class="brand__badge" src="{{ asset('images/maju-babarengan.png') }}" alt="Maju Barengan">
        </a>
      </div>

      
      <h1 class="login-title">{{ $loginTitle }}</h1>

      <form class="login-form" action="{{ $loginAction }}" method="post">
        @csrf

        {{-- Flash Messages --}}
        @if(session('error'))
          <div class="alert alert-error" id="alert-error">
            <span class="alert-icon">⚠️</span>
            <span class="alert-message">{{ session('error') }}</span>
            <button type="button" class="alert-close" onclick="closeAlert('alert-error')">&times;</button>
          </div>
        @endif

        @if(session('warning'))
          <div class="alert alert-warning" id="alert-warning">
            <span class="alert-icon">⏰</span>
            <span class="alert-message">{{ session('warning') }}</span>
            <button type="button" class="alert-close" onclick="closeAlert('alert-warning')">&times;</button>
          </div>
        @endif

        @if(session('success'))
          <div class="alert alert-success" id="alert-success">
            <span class="alert-icon">✅</span>
            <span class="alert-message">{{ session('success') }}</span>
            <button type="button" class="alert-close" onclick="closeAlert('alert-success')">&times;</button>
          </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
          <div class="alert alert-error" id="alert-validation">
            <span class="alert-icon">⚠️</span>
            <span class="alert-message">{{ $errors->first() }}</span>
            <button type="button" class="alert-close" onclick="closeAlert('alert-validation')">&times;</button>
          </div>
        @endif

        <label class="field">
          <span class="field__label">{{ $inputLabel }}</span>
          <input class="field__input" 
                 type="{{ $inputType }}" 
                 name="{{ $inputName }}" 
                 placeholder="{{ $isAdmin ? 'Masukkan Email atau Username' : 'Masukkan Email Anda' }}"
                 value="{{ old($inputName) }}" 
                 autocomplete="{{ $isAdmin ? 'username' : 'email' }}" 
                 required 
                 autofocus />
        </label>

        <label class="field">
          <span class="field__label">Password</span>
          <div class="password-wrap">
            <input class="field__input field__input--password" 
                   type="password" 
                   name="password"
                   placeholder="Masukkan Password" 
                   autocomplete="current-password" 
                   required 
                   id="password" />
            <button class="eye-btn" type="button" aria-label="Tampilkan password" onclick="togglePassword()">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" stroke="currentColor" stroke-width="1.6" />
                <circle cx="12" cy="12" r="3.5" stroke="currentColor" stroke-width="1.6" />
              </svg>
            </button>
          </div>
        </label>

        <div>
          <button class="login-btn" type="submit">Masuk</button>
          
          @if(!$isAdmin)
            <p style="text-align: center; margin-top: 15px; font-size: 14px; color: #666;">
              Belum punya akun? <a href="{{ route('jadi-anggota') }}" style="color: #667eea; font-weight: 600;">Daftar Sekarang</a>
            </p>
          @else
            
          @endif
        </div>
      </form>
    </div>

    <div class="login-right">
      <img class="login-image" src="{{ asset('images/svg/login-image.svg') }}" alt="Login Image">
    </div>
  </div>
</section>

<script>
  // Toggle password visibility
  function togglePassword() {
    const passwordInput = document.getElementById('password');
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
  }

  // Close alert manually
  function closeAlert(alertId) {
    const alert = document.getElementById(alertId);
    if (alert) {
      alert.style.transition = 'opacity 0.3s, transform 0.3s';
      alert.style.opacity = '0';
      alert.style.transform = 'translateY(-10px)';
      setTimeout(() => alert.remove(), 300);
    }
  }

  // Auto-hide alerts after 7 seconds
  setTimeout(() => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
      alert.style.transition = 'opacity 0.5s, transform 0.5s';
      alert.style.opacity = '0';
      alert.style.transform = 'translateY(-10px)';
      setTimeout(() => alert.remove(), 500);
    });
  }, 7000);
</script>
@endsection