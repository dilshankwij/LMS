<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title') | CodeXpress Institute</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --cx-primary: #2563eb;
      --cx-purple:  #7c3aed;
      --cx-accent:  #06b6d4;
      --cx-green:   #10b981;
    }

    body {
      font-family: 'Inter', sans-serif;
      min-height: 100vh;
      background: linear-gradient(135deg, #0f172a 0%, #1e293b 55%, #0c1a40 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      position: relative;
      color: #fff;
    }

    /* Animated background blobs */
    body::before {
      content: '';
      position: fixed;
      width: 700px; height: 700px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(37,99,235,0.25) 0%, transparent 65%);
      top: -250px; right: -200px;
      pointer-events: none;
      animation: floatBlob 8s ease-in-out infinite;
    }
    body::after {
      content: '';
      position: fixed;
      width: 500px; height: 500px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(124,58,237,0.2) 0%, transparent 65%);
      bottom: -200px; left: -150px;
      pointer-events: none;
      animation: floatBlob 10s ease-in-out infinite reverse;
    }

    @keyframes floatBlob {
      0%, 100% { transform: translate(0,0) scale(1); }
      50% { transform: translate(30px, -30px) scale(1.05); }
    }

    /* Card */
    .auth-card {
      position: relative;
      z-index: 10;
      width: 100%;
      max-width: 460px;
      margin: 24px;
      background: rgba(255,255,255,0.06);
      backdrop-filter: blur(24px);
      -webkit-backdrop-filter: blur(24px);
      border: 1px solid rgba(255,255,255,0.12);
      border-radius: 24px;
      padding: 44px 40px;
      box-shadow: 0 30px 80px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.05) inset;
      animation: slideUp 0.5s cubic-bezier(0.16,1,0.3,1) both;
    }

    @keyframes slideUp {
      from { opacity: 0; transform: translateY(28px) scale(0.97); }
      to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* Logo */
    .auth-logo {
      text-align: center;
      margin-bottom: 32px;
    }
    .logo-icon-wrap {
      width: 72px; height: 72px;
      background: linear-gradient(135deg, var(--cx-primary), var(--cx-purple));
      border-radius: 20px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      color: #fff;
      margin-bottom: 14px;
      box-shadow: 0 8px 30px rgba(37,99,235,0.5);
    }
    .auth-logo h1 {
      font-family: 'Poppins', sans-serif;
      font-size: 1.5rem;
      font-weight: 700;
      color: #fff;
      letter-spacing: -0.3px;
      margin: 0 0 4px;
    }
    .auth-logo p {
      font-size: 0.82rem;
      color: rgba(255,255,255,0.5);
      letter-spacing: 0.5px;
      text-transform: uppercase;
    }

    /* Role buttons */
    .role-row {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 10px;
      margin-bottom: 24px;
    }
    .role-btn {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 6px;
      padding: 12px 8px;
      background: rgba(255,255,255,0.06);
      border: 1.5px solid rgba(255,255,255,0.12);
      border-radius: 12px;
      color: rgba(255,255,255,0.6);
      font-family: 'Inter', sans-serif;
      font-size: 0.78rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s ease;
    }
    .role-btn i { font-size: 1.1rem; }
    .role-btn:hover {
      border-color: var(--cx-primary);
      color: #fff;
      background: rgba(37,99,235,0.15);
      transform: translateY(-1px);
    }
    .role-btn.active {
      border-color: var(--cx-primary);
      background: linear-gradient(135deg, var(--cx-primary), var(--cx-purple));
      color: #fff;
      box-shadow: 0 4px 16px rgba(37,99,235,0.4);
    }

    /* Form */
    .form-group { margin-bottom: 18px; }
    .form-label {
      display: block;
      font-size: 0.8rem;
      font-weight: 600;
      color: rgba(255,255,255,0.7);
      margin-bottom: 6px;
      letter-spacing: 0.2px;
    }
    .form-input {
      width: 100%;
      padding: 12px 16px;
      background: rgba(255,255,255,0.07);
      border: 1.5px solid rgba(255,255,255,0.12);
      border-radius: 10px;
      color: #fff;
      font-family: 'Inter', sans-serif;
      font-size: 0.9rem;
      outline: none;
      transition: border-color 0.2s, background 0.2s;
    }
    .form-input::placeholder { color: rgba(255,255,255,0.3); }
    .form-input:focus {
      border-color: var(--cx-primary);
      background: rgba(37,99,235,0.1);
    }

    /* Alert */
    .alert-error {
      padding: 12px 16px;
      background: rgba(239,68,68,0.15);
      border: 1px solid rgba(239,68,68,0.4);
      border-radius: 10px;
      color: #fca5a5;
      font-size: 0.85rem;
      margin-bottom: 18px;
    }
    .alert-success {
      padding: 12px 16px;
      background: rgba(16,185,129,0.15);
      border: 1px solid rgba(16,185,129,0.4);
      border-radius: 10px;
      color: #6ee7b7;
      font-size: 0.85rem;
      margin-bottom: 18px;
    }

    /* Primary button */
    .btn-primary-cx {
      width: 100%;
      padding: 13px;
      background: linear-gradient(135deg, var(--cx-primary), var(--cx-purple));
      border: none;
      border-radius: 12px;
      color: #fff;
      font-family: 'Poppins', sans-serif;
      font-size: 0.95rem;
      font-weight: 700;
      letter-spacing: 0.3px;
      cursor: pointer;
      transition: all 0.2s ease;
      box-shadow: 0 4px 20px rgba(37,99,235,0.4);
      margin-bottom: 16px;
    }
    .btn-primary-cx:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 28px rgba(37,99,235,0.55);
    }
    .btn-primary-cx:active { transform: translateY(0); }

    /* Links row */
    .auth-links {
      text-align: center;
      font-size: 0.83rem;
      color: rgba(255,255,255,0.45);
      margin-bottom: 24px;
    }
    .auth-links a {
      color: var(--cx-accent);
      text-decoration: none;
      font-weight: 600;
    }
    .auth-links a:hover { text-decoration: underline; }
    .auth-links .sep { margin: 0 10px; }

    /* Quick demo section */
    .demo-section {
      border-top: 1px solid rgba(255,255,255,0.1);
      padding-top: 20px;
    }
    .demo-label {
      font-size: 0.7rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: rgba(255,255,255,0.35);
      margin-bottom: 12px;
      text-align: center;
    }
    .demo-btn {
      display: flex;
      align-items: center;
      gap: 10px;
      width: 100%;
      padding: 10px 14px;
      background: rgba(255,255,255,0.04);
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 10px;
      color: rgba(255,255,255,0.8);
      font-family: 'Inter', sans-serif;
      font-size: 0.83rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.18s ease;
      margin-bottom: 8px;
      text-align: left;
    }
    .demo-btn:hover {
      background: rgba(255,255,255,0.09);
      border-color: rgba(255,255,255,0.18);
      color: #fff;
    }
    .demo-btn:last-child { margin-bottom: 0; }
    .demo-btn .demo-icon { width: 28px; height: 28px; border-radius: 8px; display:flex; align-items:center; justify-content:center; font-size:0.85rem; flex-shrink:0; }
    .demo-btn .demo-role { font-weight: 700; color: #fff; }
    .demo-btn .demo-creds { font-size: 0.73rem; color: rgba(255,255,255,0.4); margin-left: auto; }

    /* Select dropdown */
    .form-select {
      width: 100%;
      padding: 12px 16px;
      background: rgba(255,255,255,0.07);
      border: 1.5px solid rgba(255,255,255,0.12);
      border-radius: 10px;
      color: #fff;
      font-family: 'Inter', sans-serif;
      font-size: 0.9rem;
      outline: none;
      appearance: none;
      -webkit-appearance: none;
      cursor: pointer;
    }
    .form-select option { background: #1e293b; color: #fff; }
    .form-select:focus { border-color: var(--cx-primary); }
  </style>
</head>
<body>
  @yield('content')

  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  @yield('scripts')
</body>
</html>