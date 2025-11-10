<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Collab</title>
    <link rel="stylesheet" href="{{ asset('css/ui.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="auth-layout">
        <div class="auth-container">
            <div class="auth-header">
                <h1>Welcome Back</h1>
                <p class="text-muted">Sign in to continue to Collab</p>
            </div>
            
            @if ($errors->any())
                <div class="errors" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autofocus autocomplete="email">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required autocomplete="current-password">
                </div>

                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember" id="remember">
                        <span>Remember me</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-full">Sign In</button>
            </form>

            <div class="auth-links">
                Don't have an account? <a href="{{ route('register') }}">Create one</a>
            </div>
        </div>
    </div>
</body>
</html>
