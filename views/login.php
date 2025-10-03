<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | RSHP</title>
    <link rel="stylesheet" href="views/css/login.css">
</head>
<body>
    <section class="login-section">
        <div class="login-image"></div>
        <div class="login-content">
            <h1>Login</h1>
            <form action="/login" method="post" class="login-form">
                <label for="username">Email</label>
                <input type="text" id="username" name="email" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Login</button>
            </form>
        </div>
    </section>
</body>
</html>