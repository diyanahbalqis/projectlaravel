<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - ICT Equipment Rental</title>
    
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    
    <div class="signin-container">
        <div class="brand">
            <div class="brand-logo">ICT</div>
            <div class="brand-name">ICTRent Pro</div>
            <div class="brand-tagline">ICT Equipment Rental</div>
        </div>

        <h1>Welcome Back</h1>
        <p class="subtitle">Sign in to access your account</p>

        <!-- Session Status -->
        @if (session('status'))
            <div class="status-message">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
        @csrf

            <div class="form-group">
                <label for="staff_id">STAFF ID</label>
                <div class="input-wrapper">
                    <input type="text" 
                           id="staff_id" 
                           name="staff_id" 
                           value="{{ old('staff_id') }}" 
                           placeholder="Enter your username"
                           required 
                           autofocus 
                           autocomplete="username">
                    @error('staff_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" 
                           id="password" 
                           name="password" 
                           placeholder="Enter your password" 
                           required 
                           autocomplete="current-password">
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="options">
                <div class="remember-me">
                    <input type="checkbox" id="remember_me" name="remember">
                    <label for="remember_me">Remember me</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                @endif
            </div>

            <button type="submit" class="signin-btn">
                Log in
            </button>
        </form>
        
        <div class="signup-prompt">
            Don't have an account?<a href="{{ route('register') }}">Create one now</a>
        </div>
    </div>
</body>
</html>