<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome To Rodaza Coffee</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" href=<?=base_url("/assets/Logo/icon.png")?> type="image/icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/dd20ffdac4.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <nav class="navbar">
            <img src="<?=base_url("/assets/Logo/brand.png")?>" alt="Brand">
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#about">Tentang Kami</a></li>
                <li><a href="#menu">Menu</a></li>
                <li><a href="#gallery">Galeri</a></li>
                <li><a href="#contact">Kontak</a></li>
            </ul>
            <a href="/login" class="order">Login
            </a>
            <div class="garis"></div>
        </nav>
    </header>
    <section>
        <!-- Floating Whatsapp Button -->
        <a href="https://wa.me/+6281384310179" target="_blank" id="toggle" class="wa">
            <i class="fa-brands fa-whatsapp"></i>
            <div class="join">
                <p>Order By Whatsapp</p>
            </div>
        </a>

        <!-- Landing Page -->
        <div class="hero-container" id="home">
            <div class="sub-container-kiri">
                <div class="title animate__animated animate__fadeInLeft animate__fast">
                    <h1 id="title1">Rodaza</h1>
                    <h1 id="title2">Coffee</h1>
                </div>
                <p class="animate__animated animate__fadeIn" >Dari biji terbaik hingga cangkir Anda. <span>Rodaza Coffee</span>, menciptakan momen hangat di setiap
                    hari.</p>
                <div class="order animate__animated animate__fadeInUp">
                    <a href="/login">Order Sekarang</a>
                    <i class="fa-solid fa-mug-hot"></i>
                </div>
            </div>
            <div class="sub-container-kanan">
                <img class="animate__animated animate__fadeInRight" src=<?=base_url("/assets/home.jpg")?> alt="">
            </div>
            <img src=<?=base_url("/assets/bg1.svg")?> alt="" id="bg1">
        </div>

        <!-- About Page -->
        <div class="about-container" id="about">
            <h1>Tentang Rodaza</h1>
            <div class="text-wrapper">
                <p>
                    Sejak pertama kali membuka pintu pada tahun 1999, Rodaza Coffee telah menjadi lebih dari sekadar
                    tempat untuk menikmati secangkir kopi. Kami adalah sebuah pengalaman, sebuah perjalanan yang
                    menyatukan rasa, aroma, dan kehangatan dalam setiap tegukan. Dari
                    biji kopi terbaik yang dipilih langsung dari perkebunan unggulan, kami berkomitmen untuk
                    menghadirkan kopi berkualitas tinggi yang diracik dengan penuh cinta dan keahlian.
                </p>
                <div class="more-text">
                    <p>Berasal dari kecintaan kami terhadap kopi, Rodaza Coffee lahir dengan visi sederhana:
                        menciptakan momen istimewa di setiap cangkir. Dalam lebih dari dua dekade, kami telah tumbuh
                        bersama pelanggan setia yang menjadikan setiap kunjungan ke Rodaza sebagai bagian dari
                        rutinitas harian mereka. Baik Anda datang untuk menikmati kopi pagi yang menghangatkan jiwa,
                        atau menghabiskan waktu bersantai di sore hari, Rodaza Coffee selalu menyambut Anda dengan
                        keramahan dan citarasa yang khas.</p>
                    <p>Dengan filosofi yang mengedepankan keaslian dan keberlanjutan, kami bangga menggunakan
                        bahan-bahan alami yang diproses secara etis. Setiap minuman yang kami sajikan tidak hanya
                        sekedar kopi, melainkan cerita tentang kerja keras para petani, perjalanan biji kopi dari
                        kebun hingga cangkir, dan upaya kami untuk selalu memberikan yang terbaik.</p>
                    <p>Nikmati perjalanan rasa bersama Rodaza Coffee, di mana setiap tegukan mengingatkan Anda bahwa
                        hidup yang indah dimulai dari secangkir kopi yang sempurna.</p>
                </div>
                <a href="" id="read-more-button">Read more...</a>
            </div>
        </div>
    </section>

    <!-- PRODUK -->
    <section>
        <div class="product-container" id="menu">
            <img src=<?=base_url("/assets/bg1.svg")?> alt="" id="bg2">
            <div class="wrapper">
                <h1>OUR BEST SELLER</h1>
                <div class="product-list" id="product-list">
                    <!-- Produk kopi akan ditampilkan di sini -->
                </div>
                <div class="scroll-buttons">
                    <button id="scroll-left" class="scroll-btn">◀</button>
                    <button id="scroll-right" class="scroll-btn">▶</button>
                </div>
            </div>
        </div>
    </section>
    <script src="/js/script.js"></script>
</body>

</html>