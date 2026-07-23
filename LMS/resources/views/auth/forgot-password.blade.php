@extends('layouts.auth')
@section('title', 'Forgot Password')

@section('content')
<div class="auth-card">
  <div class="auth-logo">
    <div class="logo-icon-wrap" style="background:linear-gradient(135deg,#f59e0b,#ef4444);">
      <i class="fas fa-key"></i>
    </div>
    <h1>Password Recovery</h1>
    <p>Enter your email to get reset instructions</p>
  </div>

  <div class="alert-success" id="success-alert" style="display:none;">
    <i class="fas fa-check-circle mr-2"></i>Reset instructions sent to your email!
  </div>

  <form id="reset-form" onsubmit="handleReset(event)">
    <div class="form-group" style="margin-bottom:24px;">
      <label class="form-label">Email Address</label>
      <input type="email" class="form-input" id="reset-email" placeholder="e.g. john@example.com" required>
    </div>

    <button type="submit" class="btn-primary-cx" style="background:linear-gradient(135deg,#f59e0b,#ef4444); box-shadow:0 4px 20px rgba(245,158,11,0.35);">
      <i class="fas fa-paper-plane mr-2"></i>Send Reset Instructions
    </button>
  </form>

  <div class="auth-links" style="margin-bottom:0;margin-top:20px;">
    <a href="{{ route('login') }}"><i class="fas fa-arrow-left mr-1"></i>Back to Sign In</a>
  </div>
</div>
@endsection

@section('scripts')
<script>
  function handleReset(e) {
    e.preventDefault();
    document.getElementById('reset-form').style.display = 'none';
    document.getElementById('success-alert').style.display = 'block';
  }
</script>
@endsection
