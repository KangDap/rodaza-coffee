<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome To Rodaza Coffee</title>
    <link rel="stylesheet" href="/css/styleProfileEdit.css">
    <link rel="icon" href=<?= base_url("/assets/Logo/icon.png") ?> type="image/icon">
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
                <i class="fa-solid fa-cart-shopping" id="cart"><span class="quantity-badge"
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
                        <img :src="`${item.img}`" :alt="item.name">
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
            <div x-data="orderForm">
                <h3 x-show="!$store.cart.items.length">Pesanan Kamu Masih Kosong.</h3>
                <h2 x-show="$store.cart.items.length">
                    Harga Total: <span x-text="rupiah($store.cart.total)"></span>
                </h2>

                <!-- Pilihan dine-in atau take-away -->
                <div class="dine-btn" x-show="$store.cart.items.length">
                    <label>
                        <input type="radio" name="orderType" value="delivery" @change="orderType = 'delivery'"> Delivery
                    </label>
                    <label>
                        <input type="radio" name="orderType" value="dineIn" @change="orderType = 'dineIn'"> Dine In
                    </label>
                </div>

                <!-- Input dinamis berdasarkan pilihan -->
                <template x-if="orderType === 'delivery'">
                    <div>
                        <input type="text" placeholder="Masukkan alamat" x-model="inputValue" class="input-style">
                    </div>
                </template>
                <template x-if="orderType === 'dineIn'">
                    <div>
                        <input type="text" placeholder="Masukkan nomor meja" x-model="inputValue" class="input-style">
                    </div>
                </template>

                <!-- Tombol Bayar -->
                <div class="pay-btn">
                    <button x-show="$store.cart.items.length" @click="submitOrder">Bayar</button>
                </div>
            </div>
        </div>

        <!-- Landing Page -->
        <div class="hero-container" id="home">
            <h1>Edit Personal Info</h1>
            <p>Ubah informasi pribadi Anda di sini</p>

            <?php if(session()->has('error')) : ?>
                <div class="notification-popup failed">
                    <?= session('error') ?>
                </div>
            <?php endif ?>

            <form action="<?= route_to("edit-profile") ?>" method="POST" enctype="multipart/form-data"
                class="edit-profile-form">
                <?= csrf_field() ?>
                <div class="profile-picture-preview">
                    <img id="profile-preview" src=<?= user()->__get('profile_picture') ?> alt="Profile Picture">
                </div>
                <div class="form-group">
                    <label for="profile-picture">Ubah Foto Profil:</label>
                    <input type="file" id="profile-picture" name="profile_picture" accept="image/*" value="<?= user()->__get('profile_picture') ?? base_url("assets/profile.jpg") ?>" >
                </div>
                <div class="form-group">
                    <label for="name">Nama:</label>
                    <input type="text" id="name" name="username" value="<?= user()->__get('username') ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?= user()->__get('email') ?>">
                </div>
                <div class="form-group">
                    <label for="birthdate">Tanggal Lahir:</label>
                    <input type="date" id="birthdate" name="birthdate" value="<?= user()->__get('birthdate') ?? "-" ?>">
                </div>
                <div class="form-group">
                    <label for="address">Alamat:</label>
                    <textarea id="address" name="address"><?= user()->__get('address') ?? "-" ?></textarea>
                </div>
                <div class="form-group">
                    <label for="phone">No HP:</label>
                    <input type="tel" id="phone" name="phone_number" value="<?= user()->__get('phone_number') ?? "-" ?>">
                </div>
                <button type="submit" class="btn-submit">Simpan Perubahan</button>
            </form>
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
    <script src="/js/profile.js"></script>
</body>

</html>