<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Lato:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <title>Sign In – ETTHNICOAST</title>

  <style>
    *{margin:0;padding:0;box-sizing:border-box}
    :root{
      --primary-blue:#07203F;
      --secondary-peach:#EBDED4;
      --dark:#02000D;
      --muted:rgba(2,0,13,.6);
      --border:rgba(7,32,63,.12);
      --white:#fff;
      --font-primary:'Cormorant Garamond',serif;
      --font-secondary:'Lato',system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
    }

    body{
      font-family:var(--font-secondary);
      background:#fff;
      color:var(--dark);
    }

    .signin-page{
      min-height:100vh;
      display:flex;
      align-items:center;
      justify-content:center;
      padding:3rem 1rem;
      background:linear-gradient(135deg, rgba(235,222,212,.15) 0%, rgba(255,255,255,1) 50%, rgba(235,222,212,.15) 100%);
      position:relative;
      overflow:hidden;
    }

    .signin-container{
      max-width:900px;
      width:100%;
      background:#fff;
      border-radius:24px;
      box-shadow:0 20px 60px rgba(7,32,63,.12);
      overflow:hidden;
      display:grid;
      grid-template-columns:1fr 1fr;
    }

    .signin-form-section{
      padding:3rem 2.5rem;
      display:flex;
      flex-direction:column;
      justify-content:center;
    }

    .signin-header{
      margin-bottom:2rem;
    }
    .signin-header h1{
      font-family:var(--font-primary);
      font-size:2.5rem;
      font-weight:700;
      color:var(--primary-blue);
      margin-bottom:.5rem;
    }
    .signin-header p{
      color:var(--muted);
      font-size:.95rem;
    }
    .signin-header p a{
      color:var(--primary-blue);
      font-weight:600;
      text-decoration:underline;
    }

    .form-group{
      margin-bottom:1.2rem;
    }
    .form-group label{
      display:block;
      margin-bottom:.5rem;
      font-size:.9rem;
      font-weight:600;
      color:var(--dark);
    }
    .form-group input{
      width:100%;
      padding:.95rem 1.1rem;
      border:1.5px solid var(--border);
      border-radius:12px;
      font-size:.95rem;
      background:#fafafa;
    }
    .form-group input:focus{
      outline:none;
      border-color:var(--primary-blue);
      background:#fff;
      box-shadow:0 0 0 4px rgba(7,32,63,.08);
    }

    .password-wrapper{
      position:relative;
    }
    .password-toggle{
      position:absolute;
      right:1rem;
      top:50%;
      transform:translateY(-50%);
      background:none;
      border:none;
      color:var(--muted);
      cursor:pointer;
      padding:.5rem;
    }

    .form-options{
      display:flex;
      justify-content:space-between;
      align-items:center;
      margin-bottom:1.5rem;
      gap:.75rem;
      flex-wrap:wrap;
    }

    .checkbox-group{
      display:flex;
      align-items:center;
      gap:.5rem;
    }
    .checkbox-group input[type="checkbox"]{
      width:18px;
      height:18px;
      accent-color:var(--primary-blue);
    }
    .checkbox-group label{
      font-size:.85rem;
      color:var(--muted);
      margin:0;
      font-weight:400;
    }

    .forgot-password{
      font-size:.85rem;
      color:var(--primary-blue);
      text-decoration:underline;
    }

    .submit-btn{
      width:100%;
      padding:1rem;
      background:var(--primary-blue);
      color:#fff;
      border:none;
      border-radius:12px;
      font-size:.95rem;
      font-weight:700;
      letter-spacing:1px;
      text-transform:uppercase;
      cursor:pointer;
    }

    .alert-box{
      padding:.9rem 1rem;
      border-radius:12px;
      margin-bottom:1rem;
      font-size:.9rem;
    }
    .alert-danger{
      background:#fef2f2;
      color:#b91c1c;
      border:1px solid #fecaca;
    }
    .alert-success{
      background:#f0fdf4;
      color:#166534;
      border:1px solid #bbf7d0;
    }

    .error-text{
      color:#dc2626;
      font-size:.82rem;
      margin-top:.4rem;
    }

    .signin-visual{
      background:linear-gradient(135deg, var(--primary-blue) 0%, #0a2f5a 100%);
      padding:3rem 2.5rem;
      display:flex;
      flex-direction:column;
      justify-content:center;
      align-items:center;
      color:#fff;
      text-align:center;
    }

    .visual-icon{
      width:120px;
      height:120px;
      background:rgba(255,255,255,.1);
      border-radius:50%;
      display:flex;
      align-items:center;
      justify-content:center;
      margin:0 auto 2rem;
      border:2px solid rgba(255,255,255,.2);
    }
    .visual-icon i{
      font-size:3.5rem;
      color:var(--secondary-peach);
    }

    .visual-content h2{
      font-family:var(--font-primary);
      font-size:2rem;
      margin-bottom:1rem;
    }
    .visual-content p{
      font-size:1rem;
      line-height:1.7;
      color:rgba(255,255,255,.85);
      margin-bottom:2rem;
    }
    .features-list{
      list-style:none;
      text-align:left;
      max-width:300px;
      margin:0 auto;
    }
    .features-list li{
      display:flex;
      align-items:center;
      gap:.75rem;
      margin-bottom:1rem;
      font-size:.95rem;
      color:rgba(255,255,255,.9);
    }
    .features-list i{
      color:var(--secondary-peach);
    }

    @media (max-width:768px){
      .signin-container{grid-template-columns:1fr}
      .signin-visual{order:-1;padding:2rem 1.5rem}
      .signin-form-section{padding:2rem 1.5rem}
    }
  </style>
</head>

<body>
  <main class="signin-page">
    <div class="signin-container">
      <div class="signin-form-section">
        <div class="signin-header">
          <h1>Welcome Back</h1>
          <p>Don't have an account? <a href="{{ route('frontend.register') }}">Create one</a></p>
        </div>

        @if(session('success'))
          <div class="alert-box alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
          <div class="alert-box alert-danger">{{ session('error') }}</div>
        @endif

        @if($errors->any())
          <div class="alert-box alert-danger">
            <ul style="padding-left:18px;">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('frontend.login.store') }}" method="POST">
          @csrf

          <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required />
            @error('email') <div class="error-text">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label>Password</label>
            <div class="password-wrapper">
              <input type="password" id="password" name="password" placeholder="Enter your password" required />
              <button type="button" class="password-toggle" onclick="togglePassword('password')">
                <i class="fas fa-eye" id="password-icon"></i>
              </button>
            </div>
            @error('password') <div class="error-text">{{ $message }}</div> @enderror
          </div>

          <div class="form-options">
            <div class="checkbox-group">
              <input type="checkbox" id="remember" name="remember">
              <label for="remember">Remember me</label>
            </div>
            <a href="#" class="forgot-password">Forgot password?</a>
          </div>

          <button type="submit" class="submit-btn">Sign In</button>
        </form>
      </div>

      <div class="signin-visual">
        <div class="visual-content">
          <div class="visual-icon">
            <i class="fas fa-crown"></i>
          </div>
          <h2>Continue Your Journey</h2>
          <p>Sign in to access your personalized jewelry collection and exclusive member benefits</p>

          <ul class="features-list">
            <li><i class="fas fa-check-circle"></i><span>Track your orders in real-time</span></li>
            <li><i class="fas fa-check-circle"></i><span>Save your favorite pieces</span></li>
            <li><i class="fas fa-check-circle"></i><span>Quick & easy checkout</span></li>
            <li><i class="fas fa-check-circle"></i><span>Exclusive member offers</span></li>
          </ul>
        </div>
      </div>
    </div>
  </main>

  <script>
    function togglePassword(fieldId) {
      const field = document.getElementById(fieldId);
      const icon = document.getElementById(fieldId + '-icon');

      if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }
  </script>
</body>
</html>