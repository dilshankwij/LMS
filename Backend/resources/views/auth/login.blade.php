@extends('layouts.auth')
@section('title', 'Sign In')

@section('content')
<div class="auth-card">
  <!-- Logo -->
  <div class="auth-logo">
    <div class="logo-icon-wrap"><i class="fas fa-code"></i></div>
    <h1>CodeXpress Institute</h1>
    <p>Learning Management System</p>
  </div>

  {{-- Error message --}}
  @if($errors->any())
  <div class="alert-error"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
  @endif

  <form id="login-form" action="{{ route('login') }}" method="POST">
    @csrf

    <!-- Email -->
    <div class="form-group">
      <label class="form-label" for="input-email">Email Address</label>
      <input type="email" name="email" class="form-input" id="input-email"
             placeholder="Enter your email address" value="{{ old('email') }}" required autofocus>
    </div>

    <!-- Password -->
    <div class="form-group" style="margin-bottom: 28px;">
      <label class="form-label" for="input-password">Password</label>
      <input type="password" name="password" class="form-input" id="input-password"
             placeholder="••••••••" required>
    </div>

    <button type="submit" class="btn-primary-cx">
      <i class="fas fa-sign-in-alt mr-2"></i>Sign In
    </button>
  </form>

  <div class="auth-links" style="margin-bottom:0;">
    <a href="{{ route('forgot-password') }}">Forgot Password?</a>
    <span class="sep">|</span>
    <a href="{{ route('register') }}">Create Account</a>
  </div>
</div>
@endsection
