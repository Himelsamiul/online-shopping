@extends('frontend.master')

@section('content')

<style>
    :root {
        --primary: #4361ee;
        --primary-dark: #3a56d4;
        --secondary: #3f37c9;
        --light: #f8f9fa;
        --dark: #212529;
        --gray: #6c757d;
    }

    .full-height {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }

    .full-height::before {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(67, 97, 238, 0.1) 0%, rgba(67, 97, 238, 0) 70%);
        top: -100px;
        left: -100px;
    }

    .full-height::after {
        content: '';
        position: absolute;
        width: 400px;
        height: 400px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(63, 55, 201, 0.1) 0%, rgba(63, 55, 201, 0) 70%);
        bottom: -150px;
        right: -150px;
    }

    .login-card {
        background:rgb(179, 168, 253);
        padding: 2.5rem;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        width: 100%;
        max-width: 420px;
        position: relative;
        z-index: 1;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .login-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
    }

    .login-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 6px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
    }

    .login-title {
        margin-bottom: 2rem;
        color: var(--dark);
        font-size: 1.75rem;
        font-weight: 600;
        text-align: center;
        position: relative;
        padding-bottom: 1rem;
    }

    .login-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        border-radius: 3px;
    }

    .input-group {
        margin-bottom: 1.5rem;
        position: relative;
    }

    .input-field {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.9375rem;
        transition: all 0.3s ease;
        background-color: #f8fafc;
        padding-left: 2.75rem;
    }

    .input-field:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        outline: none;
        background-color: white;
    }

    .input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray);
        transition: color 0.3s ease;
    }

    .input-field:focus + .input-icon {
        color: var(--primary);
    }

    .form-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 1.5rem 0;
        font-size: 0.875rem;
    }

    .remember-me {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: black;
    }

    .remember-me input {
        accent-color: var(--primary);
        cursor: pointer;
    }

    .forgot-password {
        color: black;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .forgot-password:hover {
        color: var(--primary);
        text-decoration: underline;
    }

    .btn-submit {
        width: 100%;
        padding: 0.875rem;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        color: white;
        font-weight: 500;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-submit:hover {
        background: linear-gradient(90deg, var(--primary-dark), var(--secondary));
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(213, 26, 76, 0.3);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    .btn-submit::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 5px;
        height: 5px;
        background: rgba(255, 255, 255, 0.5);
        opacity: 0;
        border-radius: 100%;
        transform: scale(1, 1) translate(-50%, -50%);
        transform-origin: 50% 50%;
    }

    .btn-submit:focus:not(:active)::after {
        animation: ripple 0.6s ease-out;
    }

    @keyframes ripple {
        0% {
            transform: scale(0, 0);
            opacity: 0.5;
        }
        100% {
            transform: scale(20, 20);
            opacity: 0;
        }
    }

    .floating-particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        overflow: hidden;
    }

    .particle {
        position: absolute;
        background: rgba(67, 97, 238, 0.1);
        border-radius: 50%;
        animation: float 15s infinite linear;
    }

    @keyframes float {
        0% {
            transform: translateY(0) rotate(0deg);
        }
        100% {
            transform: translateY(-100vh) rotate(360deg);
        }
    }
</style>

<div class="full-height">
    <div class="floating-particles" id="particles"></div>
    
    <div class="login-card">
        <div class="login-title">
            User Login
        </div>
        
        <form id="login-form" action="{{ route('customer.success') }}" method="POST">
            @csrf
            
            <div class="input-group">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" name="email" placeholder="Email address" class="input-field" value="{{ old('email') }}" required>
            </div>

            <div class="input-group">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" name="password" placeholder="Password" class="input-field" id="password-field" required>
            </div>

            <div class="form-footer">
                <div class="remember-me">
                    <input type="checkbox" name="remember" id="remember-me">
                    <label for="remember-me">Remember me</label>
                </div>
                <div>
                    <a href="#" class="forgot-password">Forgot password?</a>
                </div>
            </div>

            <button type="submit" class="btn-submit" id="submit-btn">
                <span id="btn-text">Sign In</span>
            </button>
        </form>
    </div>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Create floating particles
        const particlesContainer = document.getElementById('particles');
        const particleCount = 15;
        
        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.classList.add('particle');
            
            // Random size between 5px and 15px
            const size = Math.random() * 10 + 5;
            particle.style.width = `${size}px`;
            particle.style.height = `${size}px`;
            
            // Random position
            particle.style.left = `${Math.random() * 100}%`;
            particle.style.top = `${Math.random() * 100}%`;
            
            // Random animation duration and delay
            const duration = Math.random() * 20 + 10;
            const delay = Math.random() * 5;
            particle.style.animationDuration = `${duration}s`;
            particle.style.animationDelay = `${delay}s`;
            
            particlesContainer.appendChild(particle);
        }

        // Form submission handler
        const form = document.getElementById('login-form');
        const submitBtn = document.getElementById('submit-btn');
        const btnText = document.getElementById('btn-text');
        
        form.addEventListener('submit', function(e) {
            submitBtn.disabled = true;
            btnText.textContent = 'Authenticating...';
            
            // Add loading spinner
            submitBtn.insertAdjacentHTML('beforeend', ' <i class="fas fa-spinner fa-spin"></i>');
        });

        // Password field focus effect
        const passwordField = document.getElementById('password-field');
        passwordField.addEventListener('focus', function() {
            this.parentNode.querySelector('.input-icon').classList.add('fa-shake');
        });
        
        passwordField.addEventListener('blur', function() {
            this.parentNode.querySelector('.input-icon').classList.remove('fa-shake');
        });
    });
</script>

@endsection