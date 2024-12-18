<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rodaza Coffee - Register</title>
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
            <h1>Register</h1>
            <?= view('Myth\Auth\Views\_message_block') ?>
            <form action="<?= url_to('register') ?>" method="post">
                <?= csrf_field() ?>
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="input-group">
                    <label for="pass_confirm">Konfirmasi Password</label>
                    <input type="password" id="pass_confirm" name="pass_confirm" required>
                </div>
                <button type="submit" class="btn">Register</button>
                <div class="extra">
                    <p>Sudah punya akun? <a href="<?= route_to('login') ?>">Login sekarang</a></p>
                </div>
            </form>
        </div>
    </div>
</body>

</html>