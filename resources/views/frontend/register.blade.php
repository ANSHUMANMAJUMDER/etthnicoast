<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Lato:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <title>Register – ETTHNICOAST</title>

  <style>
    *{margin:0;padding:0;box-sizing:border-box}
    :root{
      --primary-blue:#07203F;
      --secondary-peach:#EBDED4;
      --dark:#02000D;
      --muted:rgba(2,0,13,.6);
      --border:rgba(7,32,63,.12);
      --shadow:0 10px 30px rgba(7,32,63,.12);
      --white:#fff;
      --font-primary:'Cormorant Garamond',serif;
      --font-secondary:'Lato',system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
    }

    html{scroll-behavior:smooth}
    body{
      font-family:var(--font-secondary);
      background:#fff;
      color:var(--dark);
      line-height:1.35;
      overscroll-behavior:none;
    }
    a{text-decoration:none;color:inherit}
    button,input,select{font-family:inherit}
    img{max-width:100%;display:block}

    .register-page{
      min-height:100vh;
      display:flex;
      align-items:center;
      justify-content:center;
      padding:3rem 1rem;
      background:linear-gradient(135deg, rgba(235,222,212,.15) 0%, rgba(255,255,255,1) 50%, rgba(235,222,212,.15) 100%);
      position:relative;
      overflow:hidden;
    }

    .register-page::before,
    .register-page::after{
      content:'';
      position:absolute;
      border-radius:50%;
      opacity:.05;
      pointer-events:none;
    }
    .register-page::before{
      width:600px;
      height:600px;
      background:var(--primary-blue);
      top:-200px;
      right:-200px;
    }
    .register-page::after{
      width:400px;
      height:400px;
      background:var(--secondary-peach);
      bottom:-150px;
      left:-150px;
    }

    .register-container{
      max-width:900px;
      width:100%;
      background:#fff;
      border-radius:24px;
      box-shadow:0 20px 60px rgba(7,32,63,.12);
      overflow:hidden;
      display:grid;
      grid-template-columns:1fr 1fr;
      position:relative;
      animation:slideUp 0.6s ease;
    }

    @keyframes slideUp{
      from{opacity:0;transform:translateY(30px)}
      to{opacity:1;transform:translateY(0)}
    }

    .register-form-section{
      padding:3rem 2.5rem;
    }

    .register-header{
      margin-bottom:2rem;
    }
    .register-header h1{
      font-family:var(--font-primary);
      font-size:2.5rem;
      font-weight:700;
      color:var(--primary-blue);
      margin-bottom:.5rem;
      letter-spacing:.5px;
    }
    .register-header p{
      color:var(--muted);
      font-size:.95rem;
    }
    .register-header p a{
      color:var(--primary-blue);
      font-weight:600;
      text-decoration:underline;
      transition:.2s ease;
    }
    .register-header p a:hover{
      opacity:.7;
    }

    .form-group{
      margin-bottom:1.2rem;
      animation:fadeIn 0.6s ease backwards;
    }

    @keyframes fadeIn{
      from{opacity:0;transform:translateY(10px)}
      to{opacity:1;transform:translateY(0)}
    }

    .form-group label{
      display:block;
      margin-bottom:.5rem;
      font-size:.9rem;
      font-weight:600;
      color:var(--dark);
      letter-spacing:.3px;
    }
    .form-group label span{
      color:#e74c3c;
    }

    .form-group input{
      width:100%;
      padding:.95rem 1.1rem;
      border:1.5px solid var(--border);
      border-radius:12px;
      font-size:.95rem;
      transition:.25s ease;
      background:#fafafa;
    }
    .form-group input:focus{
      outline:none;
      border-color:var(--primary-blue);
      background:#fff;
      box-shadow:0 0 0 4px rgba(7,32,63,.08);
    }
    .form-group input::placeholder{
      color:rgba(2,0,13,.35);
    }

    .form-row{
      display:grid;
      grid-template-columns:1fr 1fr;
      gap:1rem;
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
      font-size:1rem;
      padding:.5rem;
    }

    .checkbox-group{
      display:flex;
      align-items:flex-start;
      gap:.75rem;
      margin-bottom:1.5rem;
    }
    .checkbox-group input[type="checkbox"]{
      width:20px;
      height:20px;
      margin-top:2px;
      accent-color:var(--primary-blue);
    }
    .checkbox-group label{
      font-size:.9rem;
      color:var(--muted);
      margin:0;
    }
    .checkbox-group a{
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
      transition:.25s ease;
      box-shadow:0 4px 12px rgba(7,32,63,.2);
    }
    .submit-btn:hover{
      background:#050f21;
      transform:translateY(-2px);
    }

    .error-text{
      color:#dc2626;
      font-size:.82rem;
      margin-top:.4rem;
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

    .register-visual{
      background:linear-gradient(135deg, var(--primary-blue) 0%, #0a2f5a 100%);
      padding:3rem 2.5rem;
      display:flex;
      flex-direction:column;
      justify-content:center;
      align-items:center;
      color:#fff;
      position:relative;
      overflow:hidden;
    }
    .register-visual::before{
      content:'';
      position:absolute;
      inset:0;
      background-image:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
      opacity:.3;
    }

    .visual-content{
      position:relative;
      z-index:1;
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
      animation:float 3s ease-in-out infinite;
    }
    .visual-icon i{
      font-size:3.5rem;
      color:var(--secondary-peach);
    }

    @keyframes float{
      0%, 100%{transform:translateY(0)}
      50%{transform:translateY(-10px)}
    }

    .visual-content h2{
      font-family:var(--font-primary);
      font-size:2rem;
      font-weight:700;
      margin-bottom:1rem;
      letter-spacing:.5px;
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
      font-size:1.1rem;
    }

    @media (max-width: 768px){
      .register-container{grid-template-columns:1fr}
      .register-visual{order:-1;padding:2rem 1.5rem}
      .register-form-section{padding:2rem 1.5rem}
      .register-header h1{font-size:2rem}
      .visual-icon{width:80px;height:80px;margin-bottom:1.5rem}
      .visual-icon i{font-size:2.5rem}
      .visual-content h2{font-size:1.5rem}
      .form-row{grid-template-columns:1fr}
    }
  </style>
</head>

<body>
  <main class="register-page">
    <div class="register-container">
      <div class="register-form-section">
        <div class="register-header">
          <h1>Create Account</h1>
          <p>Already have an account? <a href="{{ route('frontend.login') }}">Sign in</a></p>
        </div>

        @if(session('success'))
          <div class="alert-box alert-success">
            {{ session('success') }}
          </div>
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

        <form action="{{ route('frontend.register.store') }}" method="POST">
          @csrf

          <div class="form-row">
            <div class="form-group">
              <label>First Name <span>*</span></label>
              <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="Enter your first name" required />
              @error('first_name') <div class="error-text">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
              <label>Last Name <span>*</span></label>
              <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Enter your last name" required />
              @error('last_name') <div class="error-text">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="form-group">
            <label>Email Address <span>*</span></label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required />
            @error('email') <div class="error-text">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label>Phone Number <span>*</span></label>
            <input type="text" name="phone_number" value="{{ old('phone_number') }}" placeholder="+91 98765 43210" required />
            @error('phone_number') <div class="error-text">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label>Password <span>*</span></label>
            <div class="password-wrapper">
              <input type="password" id="password" name="password" placeholder="Create a strong password" required />
              <button type="button" class="password-toggle" onclick="togglePassword('password')">
                <i class="fas fa-eye" id="password-icon"></i>
              </button>
            </div>
            @error('password') <div class="error-text">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label>Confirm Password <span>*</span></label>
            <div class="password-wrapper">
              <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required />
              <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                <i class="fas fa-eye" id="password_confirmation-icon"></i>
              </button>
            </div>
          </div>

          <div class="checkbox-group">
            <input type="checkbox" id="terms" required>
            <label for="terms">I agree to the <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a></label>
          </div>

          <button type="submit" class="submit-btn">Create Account</button>
        </form>
      </div>

      <div class="register-visual">
        <div class="visual-content">
          <div class="visual-icon">
            <i class="fas fa-gem"></i>
          </div>
          <h2>Join Our Elite Collection</h2>
          <p>Become part of the ETTHNICOAST family and unlock exclusive benefits</p>

          <ul class="features-list">
            <li><i class="fas fa-check-circle"></i><span>Exclusive early access to new collections</span></li>
            <li><i class="fas fa-check-circle"></i><span>Special member-only discounts</span></li>
            <li><i class="fas fa-check-circle"></i><span>Personalized jewelry recommendations</span></li>
            <li><i class="fas fa-check-circle"></i><span>Free shipping on all orders</span></li>
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