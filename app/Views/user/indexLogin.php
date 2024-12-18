<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome To Rodaza Coffee</title>
    <link rel="stylesheet" href="/css/styleLogin.css">
    <link rel="icon" href=<?=base_url("/assets/Logo/icon.png")?> type="image/icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
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
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#about">Tentang Kami</a></li>
                <li><a href="#menu">Menu</a></li>
                <li><a href="#gallery">Galeri</a></li>
                <li><a href="#contact">Kontak</a></li>
            </ul>
            <div class="order" onclick="toggleMenu()">
                <p><?=user()->__get('username')?></p>
            </div>
            <div class="settings">
                <i class="fa-solid fa-cart-shopping cart-button" id="cart"><span class="quantity-badge"
                        x-text="$store.cart.quantity" x-show="$store.cart.quantity"></span></i>
                <i class="fa-solid fa-gear" id="gear" onclick="toggleMenu()"></i>
            </div>
            <div class="garis"></div>
            <div class="sub-menu-wrap" id="sub-menu">
                <div class="sub-menu">
                    <div class="img">
                            <img src=<?= user()->__get('profile_picture') ?> alt="Picture">
                    </div>
                    <hr>
                    <a href="<?= route_to('home') ?>" class="sub-menu-links">
                        <i class="sub-menu-icon fa-solid fa-house"></i>
                        <p>Home</p>
                        <span>></span>
                    </a>
                    <a href="<?= route_to('profile') ?>" class="sub-menu-links">
                        <i class="sub-menu-icon fa-solid fa-user"></i>
                        <p>Profile</p>
                        <span>></span>
                    </a>
                    <a href="<?= route_to('logout') ?>" class="sub-menu-links">
                        <i class="sub-menu-icon fa-solid fa-door-open"></i>
                        <p>Logout</p>
                        <span>></span>
                    </a>
                </div>
            </div>
        </nav>
    </header>
    <section x-data>
        <!-- Cart Sidebar -->
        <div class="cart-side">
            <div class="cart-content">
                <template x-for="(item, index) in $store.cart.items" x-keys="index">
                    <div class="cart-item">
                    <img :src="item.img.startsWith('http') ? item.img : `${window.location.origin}/${item.img}`" :alt="item.name">
                    <div class="cart-text">
                            <h2 x-text="item.name"></h2>
                            <div class="item-price">
                                <span x-text="rupiah(item.price)"></span> &times;
                                <button id="remove" @click="$store.cart.remove(item.id)">&minus;</button>
                                <span x-text="item.quantity"></span>
                                <button id="add" @click="$store.cart.add(item)">&plus;</button> &equals;
                                <span x-text="rupiah(item.total)"></span>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            <div class="garis2" x-show="$store.cart.items.length"></div>
            <h3 x-show="!$store.cart.items.length">Pesanan Kamu Masih Kosong.</h3>
            <h2 x-show="$store.cart.items.length">Harga Total: <span x-text="rupiah($store.cart.total)"></span></h2>

            <form action="<?= route_to('payment') ?>" id="checkoutForm" method="POST">
                <div x-data="{ 
                        order_type: '', 
                        inputValue: '',
                        get isOrderValid() {
                            // Cek apakah item keranjang ada
                            if ($store.cart.items.length === 0) return false;
                            
                            // Cek apakah tipe pesanan sudah dipilih
                            if (this.order_type === '') return false;
                            
                            // Cek apakah input tambahan sudah diisi
                            if (this.inputValue === '') return false;
                            
                            return true;
                        }
                    }" 
                    x-init="$watch('order_type', () => order_type === 'delivery' ? inputValue = '<?= user()->address ?>' : inputValue = '')"
                    x-show="$store.cart.items.length">
                    
                    <!-- Pilihan jenis pemesanan -->
                    <div class="dine-btn">
                        <label>
                            <input type="radio" name="order_type" value="delivery" x-model="order_type"> Delivery
                        </label>
                        <label>
                            <input type="radio" name="order_type" value="dine-in" x-model="order_type"> Dine In
                        </label>
                    </div>

                    <!-- Input dinamis berdasarkan pilihan -->
                    <template x-if="order_type === 'delivery'">
                        <div>
                            <input type="text" 
                                placeholder="Masukkan alamat Anda" 
                                x-model="inputValue" 
                                class="input-style" 
                                name="address" 
                                required>
                        </div>
                    </template>
                    <template x-if="order_type === 'dine-in'">
                        <div>
                            <select 
                                name="table_number" 
                                x-model="inputValue" 
                                class="input-style" 
                                required>
                                <option value="" disabled selected>Masukkan nomor meja</option>
                                <template x-for="table_number in Array.from({ length: 25 }, (_, i) => i + 1)">
                                    <option :value="table_number" x-text="table_number"></option>
                                </template>
                            </select>
                        </div>
                    </template>
                    
                    <input type="hidden" name="items" x-model="JSON.stringify($store.cart.items)">
                    <input type="hidden" name="total_amount" x-model="$store.cart.total">
                    
                    <input type="hidden" name="user_id" id="user_id" value="<?= user()->id ?>">
                    <input type="hidden" name="username" id="username" value="<?= user()->username ?>">
                    <input type="hidden" name="email" id="email" value="<?= user()->email ?>">
                    <input type="hidden" name="phone_number" id="phone_number" value="<?= user()->phone_number ?>">

                    <div class="pay-btn">
                        <button 
                            id="pay-btn" 
                            type="submit" 
                            x-show="$store.cart.items.length"
                            :disabled="!isOrderValid"
                            :class="{ 'disabled': !isOrderValid }">
                            Bayar
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Midtrans -->
    <script type="text/javascript"
                src="https://app.sandbox.midtrans.com/snap/snap.js"
                data-client-key=""></script> <!-- Sesuaikan dengan API Key Midtrans -->

        <!-- Floating Whatsapp Button -->
        <a href="https://wa.me/+6281384310179" target="_blank" id="toggle" class="wa">
            <i class="fa-brands fa-whatsapp"></i>
            <div class="join">
                <p>Order By Whatsapp</p>
            </div>
        </a>

        <!-- Landing Page -->
        <div class="hero-container" id="home">
            <?php if(session()->has('success')) : ?>
                <div class="notification-popup2 success">
                    <?= session('success') ?>
                </div>
                <?php  elseif(session()->has('error')) : ?>
                <div class="notification-popup2 failed">
                    <?= session('error') ?>
                </div>
            <?php endif ?>
            <div class="sub-container-kiri">
                <div class="title animate__animated animate__fadeInLeft animate__fast">
                    <h1 id="title1">Rodaza</h1>
                    <h1 id="title2">Coffee</h1>
                </div>
                <p class="animate__animated animate__fadeIn" >Dari biji terbaik hingga cangkir Anda. <span>Rodaza Coffee</span>, menciptakan momen hangat di setiap
                    hari.</p>
                <div class="order animate__animated animate__fadeInUp">
                    <a href="#menu">Order Sekarang</a>
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
        <div class="product-container">
            <img src="/assets/bg1.svg" alt="" id="bg2">
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

    <!-- MENU -->
    <section>
        <div class="menu-container" x-data="products" id="menu">
            <h1>OUR MENU</h1>
            <p>Nikmati hidangan kami dengan rasa yang otentik dan original.</p>
            <!-- TOMBOL FILTER -->
            <div class="filter-container">
                <button x-on:click="selectedCategory = 'all'" :class="{ 'active': selectedCategory === 'all' }">Show
                    All</button>
                <button x-on:click="selectedCategory = 'Foods'"
                    :class="{ 'active': selectedCategory === 'Foods' }">Foods</button>
                <button x-on:click="selectedCategory = 'Beverages'"
                    :class="{ 'active': selectedCategory === 'Beverages' }">Beverages</button>
                <button x-on:click="selectedCategory = 'Snacks'"
                    :class="{ 'active': selectedCategory === 'Snacks' }">Snacks</button>
            </div>
            <div class="card-container">
                <template x-for="(item, index) in items" :key="index">
                    <div class="product-cards" x-show="selectedCategory === 'all' || item.dataSet === selectedCategory"
                        x-transition>
                        <img :src="item.img" :alt="item.name" class="product-image">
                        <div class="product-info">
                            <h3 class="product-title" x-text="item.name"></h3>
                            <p class="product-price" x-text="rupiah(item.price)"></p>
                            <button @click.prevent="$store.cart.add(item)" onclick="showNotification()"
                                class="order-btn">Tambah ke
                                Keranjang</button>
                        </div>
                    </div>
                </template>
            </div>
            <div id="notificationPopup" class="notification-popup">
                <p>Item berhasil ditambahkan ke keranjang!</p>
            </div>
        </div>
    </section>

    <!-- GALLERY PAGE -->
    <section>
        <div class="gallery-container" id="gallery">
            <h1>OUR COFFEE GALLERY</h1>
            <p>Koleksi foto-foto yang diambil langsung oleh pelanggan kami.</p>
            <div class="box">
                <div class="dream">
                    <img src="./assets/product/gallery1.jpg" alt="Photo">
                    <img src="./assets/product/gallery2.jpg" alt="Photo">
                    <img src="./assets/product/gallery3.jpg" alt="Photo">
                    <img src="./assets/product/gallery4.jpg" alt="Photo">
                    <img src="./assets/product/gallery5.jpg" alt="Photo">
                </div>
                <div class="dream">
                    <img src="./assets/product/gallery6.jpg" alt="Photo">
                    <img src="./assets/product/gallery7.jpg" alt="Photo">
                    <img src="./assets/product/gallery8.jpg" alt="Photo">
                    <img src="./assets/product/gallery9.jpg" alt="Photo">
                    <img src="./assets/product/gallery10.jpg" alt="Photo">
                    <img src="./assets/product/gallery16.jpg" alt="Photo">
                </div>
                <div class="dream">
                    <img src="./assets/product/gallery11.jpg" alt="Photo">
                    <img src="./assets/product/gallery12.jpg" alt="Photo">
                    <img src="./assets/product/gallery13.jpg" alt="Photo">
                    <img src="./assets/product/gallery14.jpg" alt="Photo">
                    <img src="./assets/product/gallery15.jpg" alt="Photo">
                    <img src="./assets/product/gallery17.jpg" alt="Photo">
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACT US PAGE -->
    <section>
        <div class="contact-container" id="contact">
            <div class="contact-wrapper">
                <h2>Contact Us</h2>
                <form class="contact-form" action="<?= url_to('sendfeedback') ?>" method="post">
                    <label for="name">Nama</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan nama Anda" required value="<?= user()->__get('username') ?>">

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan email Anda" required value="<?= user()->__get('email') ?>" readonly>

                    <label for="message">Pesan</label>
                    <textarea id="message" name="message" placeholder="Tuliskan pesan Anda" rows="5"
                        required></textarea>

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
    <script src="/js/scriptLogin.js"></script>
    <script src="/js/payment.js"></script>
</body>

</html>