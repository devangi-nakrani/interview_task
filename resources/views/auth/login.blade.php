<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 300px; }
        h2 { margin-top: 0; text-align: center; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background-color: #007bff; border: none; color: white; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        .error { color: red; font-size: 12px; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>Login</h2>
        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <label>Email</label>
            <input type="email" name="email" required placeholder="Email Address">
            @error('email') <div class="error">{{ $message }}</div> @enderror
            
            <label>Password</label>
            <input type="password" name="password" required placeholder="Password">
            
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
