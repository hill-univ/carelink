@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-7">
            <div class="card shadow">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-plus-fill text-primary" style="font-size: 3rem;"></i>
                        <h3 class="mt-3">{{ __('Create Account') }}</h3>
                    </div>

                    <form method="POST" action="{{ route('register') }}" id="registerForm" novalidate>
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                {{ __('Full Name') }} <span class="text-danger">*</span>
                            </label>
                            <input id="name" 
                                   type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autofocus
                                   minlength="3"
                                   maxlength="255"
                                   pattern="[a-zA-Z\s]+"
                                   placeholder="e.g., John Doe">
                            @error('name')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @else
                                <small class="text-muted">Letters and spaces only, 3-255 characters</small>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                {{ __('Email Address') }} <span class="text-danger">*</span>
                            </label>
                            <input id="email" 
                                   type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required
                                   pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"
                                   placeholder="user@example.com">
                            @error('email')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @else
                                <small class="text-muted">Valid email format required</small>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">
                                {{ __('Phone Number') }} <span class="text-danger">*</span>
                            </label>
                            <input id="phone" 
                                   type="tel" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   name="phone" 
                                   value="{{ old('phone') }}" 
                                   required
                                   pattern="[0-9]{10,15}"
                                   placeholder="08123456789"
                                   maxlength="15">
                            @error('phone')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @else
                                <small class="text-muted">10-15 digits only, no spaces or symbols</small>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label for="address" class="form-label">
                                {{ __('Address') }} <span class="text-danger">*</span>
                            </label>
                            <textarea id="address" 
                                      class="form-control @error('address') is-invalid @enderror" 
                                      name="address" 
                                      rows="2" 
                                      required
                                      minlength="10"
                                      maxlength="500"
                                      placeholder="Enter your complete address">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @else
                                <small class="text-muted">Minimum 10 characters</small>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                {{ __('Password') }} <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input id="password" 
                                       type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password" 
                                       required
                                       minlength="8"
                                       pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$"
                                       placeholder="Minimum 8 characters">
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @else
                                <small class="text-muted">Must contain: uppercase, lowercase, and number</small>
                            @enderror
                            
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">
                                {{ __('Confirm Password') }} <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input id="password_confirmation" 
                                       type="password" 
                                       class="form-control" 
                                       name="password_confirmation" 
                                       required
                                       minlength="8"
                                       placeholder="Re-enter password">
                            </div>
                            <small class="text-muted">Must match the password above</small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-person-plus"></i> {{ __('Register') }}
                        </button>

                        <div class="text-center mt-3">
                            <p class="mb-0">{{ __("Already have an account?") }} 
                                <a href="{{ route('login') }}">{{ __('Login') }}</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('name').addEventListener('input', function() {
        const pattern = /^[a-zA-Z\s]+$/;
        if (!pattern.test(this.value) && this.value.length > 0) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });
    document.getElementById('phone').addEventListener('input', function() {
        // Remove non-numeric characters
        this.value = this.value.replace(/[^0-9]/g, '');
        
        const pattern = /^[0-9]{10,15}$/;
        if (!pattern.test(this.value) && this.value.length > 0) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });

    document.getElementById('password_confirmation').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        if (this.value !== password && this.value.length > 0) {
            this.classList.add('is-invalid');
            this.setCustomValidity('Passwords do not match');
        } else {
            this.classList.remove('is-invalid');
            this.setCustomValidity('');
        }
    });
    
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const passwordConfirm = document.getElementById('password_confirmation').value;
        
        if (password !== passwordConfirm) {
            e.preventDefault();
            alert('Password confirmation does not match!');
            document.getElementById('password_confirmation').focus();
        }
    });
</script>

@endsection