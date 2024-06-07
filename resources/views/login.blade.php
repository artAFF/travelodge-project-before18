<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('/assets/css/login.css') }}">

</head>

<body>
    <div
        style="background: url('{{ asset('/assets/images/123.jpg') }}') no-repeat; background-size: cover; background-position: center;">
        <div class="wrapper">
            <form action="">
                <h1>Login</h1>
                <div class="input-box">
                    <input type="text" placeholder="Username" required>
                    <i class="bi bi-person-fill"></i>
                </div>
                <div class="input-box">
                    <input type="text" placeholder="Password" required>
                    <i class="bi bi-lock-fill"></i>
                </div>

                <div class="remember-forget">
                    <label>
                        <input type="checkbox"> Remember me
                    </label>
                    <a href="#">Forgot password?</a>
                </div>

                <button type="submit" class="btn">Login</button>

                <div class="register-link">
                    <p>Don't have an account? <a href="#">Register</a></p>
                </div>
            </form>
        </div>
    </div>
</body>


</html>
