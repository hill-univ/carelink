@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-heart-pulse-fill text-primary" style="font-size: 3rem;"></i>
                        <h3 class="mt-3">{{ __('Login to CareLink') }}</h3>
                    </div>

                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }} <span class="text-danger">*</span></label>
                            <input id="email" 
                                   type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus
                                   placeholder="user@example.com"
                                   pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}">
                            @error('email')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                            <small class="text-muted">Example: client@carelink.com</small>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input id="password" 
                                       type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password" 
                                       required
                                       minlength="8"
                                       placeholder="Minimum 8 characters">
                                @error('password')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-box-arrow-in-right"></i> {{ __('Login') }}
                        </button>

                        <div class="text-center mt-3">
                            <p class="mb-0">{{ __("Don't have an account?") }} 
                                <a href="{{ route('register') }}">{{ __('Register') }}</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

        
        </div>
    </div>
</div>

<script>
    document.getElementById('loginForm').addEventListener('submit', function(e) {
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    
    if (!email.checkValidity()) {
        e.preventDefault();
        email.classList.add('is-invalid');
    }
    
    if (!password.checkValidity()) {
        e.preventDefault();
        password.classList.add('is-invalid');
    }
});
</script>

@endsection