@extends('layouts.app')

@section('content')

<style>
/* ===== Layout ===== */
body {
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
    background: #f5f7fb;
}

.login-wrapper {
    display: flex;
    min-height: 100vh;
}

/* ===== LEFT PANEL ===== */
.login-left {
    flex: 1;
    background: #07203f;
    color: #fff;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;

}

.login-left h2 {
    margin-top: 10px;
    font-weight: 600;
}

.login-left p {
    opacity: 0.8;
}

/* Small logo/image */
.login-logo {
    width: 120px;
    height: auto;
    margin-bottom: 15px;
}

/* ===== RIGHT PANEL ===== */
.login-right {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Login box */
.login-box {
    width: 100%;
    max-width: 360px;
    background: #fff;
    padding: 35px;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

.login-box h3 {
    text-align: center;
    margin-bottom: 25px;
    color: #07203f;
}

/* ===== FORM ===== */
.form-group {
    margin-bottom: 18px;
}

.form-group label {
    font-size: 14px;
    font-weight: 500;
}

.form-group input {
    width: 100%;
    padding: 11px;
    border-radius: 6px;
    border: 1px solid #ccc;
    margin-top: 6px;
    font-size: 14px;
}

/* Password toggle */
.password-wrapper {
    position: relative;
}

.toggle-password {
    position: absolute;
    right: 10px;
    top: 40px;
    cursor: pointer;
    font-size: 14px;
    color: #666;
}

/* Button */
.btn-login {
    width: 100%;
    padding: 12px;
    background: #07203f;
    border: none;
    color: #fff;
    border-radius: 6px;
    font-size: 16px;
    margin-top: 10px;
    transition: 0.3s;
}

.btn-login:hover {
    background: #0a2f5e;
}

/* ===== Responsive ===== */
@media(max-width: 768px){
    .login-wrapper {
        flex-direction: column;
    }

    .login-left {
        padding: 40px 20px;
    }
}
</style>

<div class="login-wrapper">

    <!-- LEFT SIDE -->
    <div class="login-left">
        <!-- replace with your logo -->
        <img src="{{ asset('public/assets/img/login.jpg') }}" alt="logo" class="login-logo">
        <h2>Welcome Back</h2>
        <p>Please login to continue</p>
    </div>

    <!-- RIGHT SIDE -->
    <div class="login-right">
        <div class="login-box">
            <h3>Sign In</h3>

            <form action="{{ route('admin.login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group password-wrapper">
                    <label>Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    <span class="toggle-password" onclick="togglePassword()">👁</span>
                </div>

                <button type="submit" class="btn-login">Sign In</button>
            </form>

        </div>
    </div>

</div>

<script>
function togglePassword() {
    const field = document.getElementById("password");
    field.type = field.type === "password" ? "text" : "password";
}
</script>

@endsection