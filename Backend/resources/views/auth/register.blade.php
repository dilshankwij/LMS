@extends('layouts.auth')
@section('title', 'Create Account')

@section('content')
<div class="auth-card" style="max-width:500px;">
  <div class="auth-logo">
    <div class="logo-icon-wrap"><i class="fas fa-user-plus"></i></div>
    <h1>Join CodeXpress</h1>
    <p>Create your student account</p>
  </div>

  @if($errors->any())
  <div class="alert-error"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
  @endif

  @if(session('success'))
  <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
  @endif

  <form action="{{ route('register') }}" method="POST">
    @csrf

    <div class="form-group">
      <label class="form-label">Full Name</label>
      <input type="text" name="name" class="form-input" placeholder="John Doe"
             value="{{ old('name') }}" required>
    </div>

    <div class="form-group">
      <label class="form-label">Email Address</label>
      <input type="email" name="email" class="form-input" placeholder="john@example.com"
             value="{{ old('email') }}" required>
    </div>

    <div class="form-group">
      <label class="form-label">Batch / Course Stream</label>
      <input type="text" name="batch" class="form-input" placeholder="e.g. Full Stack Web Development"
             value="{{ old('batch') }}" required>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
      <div class="form-group">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-input" placeholder="••••••••" required>
      </div>
      <div class="form-group">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-input" placeholder="••••••••" required>
      </div>
    </div>

    <button type="submit" class="btn-primary-cx" style="margin-top:8px;">
      <i class="fas fa-paper-plane mr-2"></i>Submit Application
    </button>
  </form>

  <div class="auth-links" style="margin-bottom:0;">
    Already have an account? <a href="{{ route('login') }}">Sign In</a>
  </div>
</div>
@endsection
