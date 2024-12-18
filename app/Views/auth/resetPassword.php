<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome To Rodaza Coffee</title>
    <link rel="stylesheet" href="/css/styleReset.css">
    <link rel="icon" href="/assets/Logo/icon.png" type="image/icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://kit.fontawesome.com/dd20ffdac4.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <nav class="navbar" x-data>
            <img src="/assets/Logo/brand.png" alt="Brand">
        </nav>
    </header>

    <!-- Reset Dashboard -->
    <section>
        <div class="hero-container" id="home">
            <div class="reset-password-container">
                <h2>Lupa kata sandi Anda?</h2>
                <hr>
                <p>Tidak masalah! Masukkan email Anda di bawah ini dan kami akan mengirimkan instruksi untuk mengatur
                    ulang kata sandi Anda.</p>
                <form action="<?= url_to('forgot') ?>" method="POST">
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <button type="submit">Kirim</button>
                </form>
            </div>
        </div>
    </section>
    <footer>
        <img src="./assets/Logo/brand.png" alt="">
        <p style="color: white;">Support us on our social media.</p>
        <div class="socials">
            <a href="#"><i class="fa-brands fa-instagram"></i></a>
            <a href="#"><i class="fa-brands fa-tiktok"></i></a>
            <a href="#"><i class="fa-brands fa-facebook"></i></a>
            <a href="#"><i class="fa-brands fa-twitter"></i></a>
            <a href="#"><i class="fa-brands fa-youtube"></i></a>
            <a href="#"><i class="fa-brands fa-linkedin"></i></a>
        </div>
        <div class="credit">
            <p>CreatedBy <span>RoDaZa</span> | &copy; 2024. All Right Reserved.
            </p>
        </div>
    </footer>
    <script src="/js/admin.js"></script>
</body>

</html>