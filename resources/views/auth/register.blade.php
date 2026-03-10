@extends('layouts.app')
@section('content')
    <div class="login-wrapper">
        <div class="login-img">
            <img src="{{ asset('assets/img/login.jpg') }}" alt="img">
        </div>
        <div class="login-content">
            <div class="login-userset">
                <div class="login-logo">
                    <img src="assets/img/logo.png" alt="img">
                </div>
                <div class="login-userheading">
                    <h3>Create an Account</h3>
                    <h4>Continue where you left off</h4>
                </div>
                <form action="{{ route('register') }}" class="mt-10" method="POST">
                    @csrf
                    <div class="form-login">
                        <label>Full Name</label>
                        <div class="form-addons">
                            <input type="text" name="name" placeholder="Enter your full name">
                            <img src="{{ asset('assets/img/icons/users1.svg') }}" alt="img">
                        </div>
                    </div>
                    <div class="form-login">
                        <label>Email</label>
                        <div class="form-addons">
                            <input type="text" name="email" placeholder="Enter your email address">
                            <img src="{{ asset('assets/img/icons/mail.svg') }}" alt="img">
                        </div>
                    </div>
                    <div class="form-login">
                        <label>Password</label>
                        <div class="pass-group">
                            <input type="password" class="pass-input" name="password" placeholder="Enter your password">
                            <span class="fas toggle-password fa-eye-slash"></span>
                        </div>
                    </div>
                    <div class="form-login">
                        <label>Password Confirmation</label>
                        <div class="pass-group">
                            <input type="password" class="pass-input" name="password_confirmation" placeholder="Enter your password confirmation">
                            <span class="fas toggle-password fa-eye-slash"></span>
                        </div>
                    </div>
                    <div class="form-login">
                        <button type="submit" class="btn btn-login">Sign Up</button>
                    </div>
                </form>
                <div class="signinform text-center">
                    <h4>Already a user? <a href="{{ route('login') }}" class="hover-a">Sign In</a></h4>
                </div>
                <div class="form-setlogin">
                    <h4>Or sign up with</h4>
                </div>
                <div class="form-sociallink">
                    <ul>
                        <li>
                            <a href="javascript:void(0);">
                                <img src="{{ asset('assets/img/icons/google.png') }}" class="me-2" alt="google">
                                Sign Up using Google
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);">
                                <img src="{{ asset('assets/img/icons/facebook.png') }}" class="me-2" alt="google">
                                Sign Up using Facebook
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
