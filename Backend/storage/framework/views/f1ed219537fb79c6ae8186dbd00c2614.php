<?php $__env->startSection('title', 'Sign In'); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-card">
  <!-- Logo -->
  <div class="auth-logo">
    <div class="logo-icon-wrap"><i class="fas fa-code"></i></div>
    <h1>CodeXpress Institute</h1>
    <p>Learning Management System</p>
  </div>

  
  <?php if($errors->any()): ?>
  <div class="alert-error"><i class="fas fa-exclamation-circle"></i> <?php echo e($errors->first()); ?></div>
  <?php endif; ?>

  <form id="login-form" action="<?php echo e(route('login')); ?>" method="POST">
    <?php echo csrf_field(); ?>

    <!-- Email -->
    <div class="form-group">
      <label class="form-label" for="input-email">Email Address</label>
      <input type="email" name="email" class="form-input" id="input-email"
             placeholder="Enter your email address" value="<?php echo e(old('email')); ?>" required autofocus>
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
    <a href="<?php echo e(route('forgot-password')); ?>">Forgot Password?</a>
    <span class="sep">|</span>
    <a href="<?php echo e(route('register')); ?>">Create Account</a>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dilsh\Documents\Internship\AdminLTE-3.1.0\Backend\resources\views/auth/login.blade.php ENDPATH**/ ?>