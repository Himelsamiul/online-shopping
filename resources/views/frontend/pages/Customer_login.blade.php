@extends('frontend.master')

@section('content')

<style>
    .full-height {
        min-height: 90vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #ffffff;
        padding: 30px 15px;
    }

    .login-card {
    background: linear-gradient(270deg, 
        #6c63ff,   
        #a78bfa,   
        #38bdf8,   
        #f472b6,   
        #34d399,  
        #facc15,   
        #fb923c,   
        #6c63ff    
    );
    background-size: 1500% 1500%;
    animation: gradientMove 12s ease infinite;
    padding: 40px 30px;
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    width: 100%;
    max-width: 400px;
    text-align: center;
    position: relative;
    transition: background 1s;
}

@keyframes gradientMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}


    .login-title {
        margin-bottom: 20px;
        color: #ffffff;
        font-size: 30px;
        font-weight: bold;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.5);
    }

    .lock-icon {
        font-size: 30px;
        transition: 0.3s;
    }

    /* Shake Animation */
    .shake {
        animation: shake 0.5s;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        20%, 60% { transform: translateX(-5px); }
        40%, 80% { transform: translateX(5px); }
    }

    .input-field {
        width: 100%;
        padding: 12px 15px;
        margin: 10px 0;
        border: 2px solid #ccc;
        border-radius: 10px;
        transition: all 0.4s ease;
        font-size: 16px;
        background-color: #f9fafb;
    }

    .input-field:focus {
        border-color: #38bdf8;
        background-color: #fff;
        box-shadow: 0 0 8px rgba(59, 130, 246, 0.5);
        outline: none;
    }

    .input-field:hover {
        border-color: #6c63ff;
        background-color: #f1f5f9;
    }

    .form-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 15px 0;
        font-size: 14px;
    }

    .form-footer a {
        color: #ffffff;
        text-decoration: none;
    }

    .form-footer a:hover {
        text-decoration: underline;
    }

    .btn-submit {
        width: 100%;
        padding: 12px;
        background: #ffffff;
        color: #6c63ff;
        font-weight: bold;
        border: 2px solid #6c63ff;
        border-radius: 10px;
        font-size: 16px;
        cursor: pointer;
        transition: 0.4s;
    }

    .btn-submit:hover {
        background: #6c63ff;
        color: white;
    }
</style>

<div class="container full-height">
    <div class="login-card" id="login-card">
        <div class="login-title" id="login-title">
            Login <span class="lock-icon" id="lock-icon">🔒</span>
        </div>
        <form id="login-form" action="{{ route('customer.success') }}" method="POST">
            @csrf
            <div>
                <input type="email" name="email" placeholder="Enter your email" class="input-field" value="{{ old('email') }}" required>
            </div>

            <div>
                <input type="password" name="password" placeholder="Enter your password" class="input-field" id="password-field" required>
            </div>

            <div class="form-footer">
                <div>
                    <input type="checkbox" name="remember-me" id="remember-me">
                    <label for="remember-me" style="color: white;">Remember Me</label>
                </div>
                <div>
                    <a href="#">Forgot Password?</a>
                </div>
            </div>

            <button type="submit" class="btn-submit" id="submit-btn">Login</button>
        </form>
    </div>
</div>

<script>
   
    const passwordField = document.getElementById('password-field');
    const lockIcon = document.getElementById('lock-icon');

    passwordField.addEventListener('input', () => {
        lockIcon.classList.add('shake');
        setTimeout(() => {
            lockIcon.classList.remove('shake');
        }, 500);
    });

   
    const form = document.getElementById('login-form');
    const submitBtn = document.getElementById('submit-btn');

    form.addEventListener('submit', function() {
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Logging in...';
    });
</script>

@endsection
