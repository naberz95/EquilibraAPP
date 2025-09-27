@extends('layouts.app')

@section('title', 'Iniciar Sesión - EquilibraAPP')
@section('body-class', 'login-body')

@section('content')
<div class="login-container">
    <div class="login-wrapper">
        <div class="login-card">
            
            <div class="logo-section">
                <img src="{{ asset('logo.png') }}" alt="EquilibraAPP Logo" class="app-logo">
                <h2 class="app-title">EquilibraAPP</h2>
                <p class="app-subtitle">Sistema de Gestión Psicológica</p>
            </div>

            <div class="form-section">
                @if($errors->any())
                    <div class="alert alert-danger alert-modern">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-modern">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="login-form">
                    @csrf
                    
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-2"></i>Correo Electrónico
                        </label>
                        <input type="email" 
                               class="form-control form-control-modern @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               placeholder="Ingresa tu correo electrónico"
                               required 
                               autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i>Contraseña
                        </label>
                        <div class="password-input-wrapper">
                            <input type="password" 
                                   class="form-control form-control-modern @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password"
                                   placeholder="Ingresa tu contraseña" 
                                   required>
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check-wrapper">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Recordarme
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Iniciar Sesión
                    </button>
                </form>

                <div class="help-section">
                    <p class="help-text">
                        <i class="fas fa-question-circle me-2"></i>
                        ¿Problemas para acceder? Contacta al administrador
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>

.login-body {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.login-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.login-wrapper {
    width: 100%;
    max-width: 450px;
}

.login-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    animation: slideUp 0.6s ease-out;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.logo-section {
    text-align: center;
    padding: 40px 30px 30px;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border-bottom: 1px solid #e9ecef;
}

.app-logo {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    margin-bottom: 20px;
    animation: logoFloat 3s ease-in-out infinite;
}

@keyframes logoFloat {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-5px); }
}

.app-title {
    font-size: 2rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 8px;
    text-shadow: none;
}

.app-subtitle {
    color: #718096;
    font-size: 1rem;
    margin-bottom: 0;
    font-weight: 500;
}

.form-section {
    padding: 30px;
}

.login-form {
    margin-bottom: 0;
}

.form-group {
    margin-bottom: 25px;
}

.form-label {
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 8px;
    font-size: 0.95rem;
    display: block;
}

.form-control-modern {
    height: 50px;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.form-control-modern:focus {
    border-color: #63b3ed;
    box-shadow: 0 0 0 0.2rem rgba(99, 179, 237, 0.15);
    background: white;
    transform: translateY(-1px);
}

.password-input-wrapper {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #6c757d;
    cursor: pointer;
    padding: 5px;
    transition: color 0.3s ease;
}

.password-toggle:hover {
    color: #63b3ed;
}

.form-check-wrapper {
    margin-bottom: 30px;
}

.form-check {
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-check-input {
    width: 18px;
    height: 18px;
    border-radius: 4px;
    border: 2px solid #dee2e6;
}

.form-check-input:checked {
    background-color: #63b3ed;
    border-color: #63b3ed;
}

.form-check-label {
    color: #6c757d;
    font-size: 0.95rem;
    cursor: pointer;
}

.btn-login {
    width: 100%;
    height: 50px;
    background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
    border: none;
    border-radius: 12px;
    color: white;
    font-size: 1.1rem;
    font-weight: 600;
    transition: all 0.3s ease;
    margin-bottom: 20px;
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(66, 153, 225, 0.3);
    background: linear-gradient(135deg, #3182ce 0%, #2c5282 100%);
}

.btn-login:active {
    transform: translateY(0);
}

.alert-modern {
    border: none;
    border-radius: 12px;
    margin-bottom: 20px;
    font-size: 0.9rem;
}

.help-section {
    text-align: center;
    padding-top: 20px;
    border-top: 1px solid #e9ecef;
}

.help-text {
    color: #6c757d;
    font-size: 0.9rem;
    margin-bottom: 0;
}

@media (max-width: 576px) {
    .login-container {
        padding: 10px;
    }
    
    .login-card {
        border-radius: 15px;
    }
    
    .logo-section {
        padding: 30px 20px 20px;
    }
    
    .app-logo {
        width: 60px;
        height: 60px;
    }
    
    .app-title {
        font-size: 1.5rem;
    }
    
    .form-section {
        padding: 20px;
    }
}

@media (prefers-color-scheme: dark) {
    .login-body {
        background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
    }
    
    .login-card {
        background: rgba(45, 55, 72, 0.95);
        color: #e2e8f0;
    }
    
    .logo-section {
        background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
        border-bottom: 1px solid #4a5568;
    }
    
    .app-title {
        color: #e2e8f0;
    }
    
    .app-subtitle {
        color: #a0aec0;
    }
    
    .form-label {
        color: #cbd5e0;
    }
    
    .form-control-modern {
        background: #4a5568;
        border-color: #718096;
        color: #e2e8f0;
    }
    
    .form-control-modern:focus {
        background: #2d3748;
        border-color: #63b3ed;
    }
    
    .help-text {
        color: #a0aec0;
    }
}
</style>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.login-form');
    const inputs = form.querySelectorAll('.form-control-modern');
    
    inputs.forEach(input => {
        input.addEventListener('invalid', function() {
            this.classList.add('is-invalid');
        });
        
        input.addEventListener('input', function() {
            if (this.validity.valid) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    });
});
</script>
@endsection