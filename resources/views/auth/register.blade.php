<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ICT Equipment Rental</title>
   
    <link rel="stylesheet" href="{{asset ('css/register.css')}}">
</head>
<body>
    <div class="register-container">
        <div class="brand">
            <div class="brand-logo">ICT</div>
            <div class="brand-name">ICTRent Pro</div>
            <div class="brand-tagline">ICT Equipment Rental</div>
        </div>

        <h1>Create Account</h1>
        <p class="subtitle">Register to start renting equipment</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name">Name</label>
                <div class="input-wrapper">
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           placeholder="Enter your full name"
                           required 
                           autofocus 
                           autocomplete="name">
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

             <div class="form-group">
    <label for="role">Role</label>
    <div class="input-wrapper">
        <select name="role" 
                id="role" 
                required 
                class="form-control">
            <option value="">Select Role</option>
            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
        @error('role')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>
</div>

            <!-- Staff ID -->
            <div class="form-group">
                <label for="staff_id">Staff ID</label>
                <div class="input-wrapper">
                    <input type="text" 
                           id="staff_id" 
                           name="staff_id" 
                           value="{{ old('staff_id') }}" 
                           placeholder="Enter your staff ID"
                           required 
                           autocomplete="staff_id">
                    @error('staff_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Email Address -->
           <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required>
        @error('email') <div class="error-message">{{ $message }}</div> @enderror
    </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" 
                           id="password" 
                           name="password" 
                           placeholder="Create a strong password"
                           required 
                           autocomplete="new-password">
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <div class="input-wrapper">
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           placeholder="Re-enter your password"
                           required 
                           autocomplete="new-password">
                    @error('password_confirmation')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="register-btn">
                Register
            </button>
        </form>

        <div class="signin-prompt">
            Already registered?<a href="{{ route('login') }}">Sign in here</a>
        </div>
    </div>
</body>
</html>