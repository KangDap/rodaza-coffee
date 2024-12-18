<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rodaza Coffee - Login</title>
    <link rel="stylesheet" href="/css/logreg.css">
    <link rel="icon" href="./assets/Logo/icon.png" type="image/icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="form-box">
            <h1>Login</h1>
            <?= view('Myth\Auth\Views\_message_block') ?>
            <form action="<?= url_to('login') ?>" method="post">
				<?= csrf_field() ?>
                <div class="input-group">
                    <label for="login">Username atau Email</label>
                    <input type="text" id="login" name="login" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="input-group">
                    <input type="checkbox" id="remember" name="remember" <?php if(old('remember')) : ?> checked <?php endif ?>>
                    <label for="remember">Ingat Saya</label>
                </div>
                <button type="submit" class="btn">Login</button>
                <div class="extra">
                    <a href="<?= route_to('forgot') ?>">Lupa password?</a>
                    <p>Belum punya akun? <a href="<?= route_to('register') ?>">Daftar di sini</a></p>
                </div>
            </form>
        </div>
    </div>
</body>

</html>