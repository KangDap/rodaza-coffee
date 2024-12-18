<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome To Rodaza Coffee</title>
    <link rel="stylesheet" href="css/styleAdmin.css">
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
            <div class="admin" onclick="toggleMenu()">
                <p>Admin - <?= user()->__get('username') ?></p>
            </div>
            <div class="garis"></div>
            <div class="sub-menu-wrap" id="sub-menu">
                <div class="sub-menu">
                    <div class="user-info">
                        <h2>Rodaza Admin</h2>
                    </div>
                    <hr>
                    <a href="<?= route_to('admin') ?>" class="sub-menu-links">
                        <i class="sub-menu-icon fa-solid fa-house"></i>
                        <p>Home</p>
                        <span>></span>
                    </a>
                    <a href="#" class="sub-menu-links">
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

    <?php if(session()->has('success')) : ?>
        <div class="notification-popup success">
            <?= session('success') ?>
        </div>
        <?php  elseif(session()->has('error')) : ?>
        <div class="notification-popup failed">
            <?= session('error') ?>
        </div>
    <?php endif ?>

    <!-- Admin Dashboard -->
    <section>
        <div class="hero-container" id="home" x-data="{ view: 'delivery' }">
            <div class="button">
                <button class="toggle-btn" :class="{ active: view === 'delivery' }" @click="view = 'delivery'">
                    Delivery
                </button>
                <button class="toggle-btn" :class="{ active: view === 'dine-in' }" @click="view = 'dine-in'">
                    Dine In
                </button>
            </div>

            <!-- Tables -->
            <div class="main" x-data="{ showModal: false, orderDetails: [], totalPrice: '', orderID: '' }">
                <!-- Delivery Table -->
                <table id="order-table" class="delivery" x-show="view === 'delivery'" x-cloak>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Pesanan</th>
                            <th>Alamat</th>
                            <th>Nama Pemesan</th>
                            <th>Status Pembayaran</th>
                            <th>Status Pesanan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <!-- Data mengambil dari API -->
                    </tbody>
                </table>

                <!-- Dine-In Table -->
                <table id="order-table" class="dine-in" x-show="view === 'dine-in'" x-cloak>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Pesanan</th>
                            <th>Nomor Meja</th>
                            <th>Nama Pemesan</th>
                            <th>Status Pembayaran</th>
                            <th>Status Pesanan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <!-- Data mengambil dari API -->
                    </tbody>
                </table>
                <!-- Modal -->
                <div class="modal" 
                    x-data
                    x-show="showModal" 
                    x-cloak 
                    @click.away="showModal = false; orderDetails = []; totalPrice = ''; orderID = ''" 
                    @keydown.escape.window="showModal = false; orderDetails = []; totalPrice = ''; orderID = ''">
                    <div class="modal-content animate__animated animate__bounceIn">
                        <button class="close-btn" @click="showModal = false; orderDetails = []; totalPrice = ''; orderID = ''">×</button>
                        <h3>Detail Pesanan</h3>
                        <h3><span x-text="orderID"></span></h3>
                        <ul>
                            <template x-for="item in orderDetails" :key="item">
                                <li><span x-text="item"></span></li>
                            </template>
                        </ul>
                        <p>Total Harga: <span x-text="totalPrice"></span></p>
                    </div>
                </div>
            </div>

            <?php
                $db = \Config\Database::connect();
                
                // Total Penghasilan
                $builder = $db->table('orders');
                $builder->selectSum('total_amount', 'total_income');
                $totalIncome = $builder->get()->getRowArray()['total_income'];

                // Total Transaksi
                $builder = $db->table('orders');
                $builder->selectCount('order_id', 'total_transactions');
                $totalTransactions = $builder->get()->getRowArray()['total_transactions'];

                // Total User (kecuali admin)
                $builder = $db->table('users');
                $builder->selectCount('users.id', 'total_users');
                $builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'inner');
                $builder->where('auth_groups_users.group_id !=', 1);
                $totalUsers = $builder->get()->getRowArray()['total_users'];
            ?>

            <div class="summary">
                <h3>Rekapitulasi Rodaza Coffee</h3>
                <hr>
                <div class="summary-details">
                    <div>
                        <span>Total Penghasilan:</span>
                        <span>Rp <?= number_format($totalIncome, 0, ',', '.') ?>,00</span>
                    </div>
                    <hr>
                    <div>
                        <span>Total Transaksi:</span>
                        <span><?= $totalTransactions ?></span>
                    </div>
                    <hr>
                    <div>
                        <span>Total User:</span>
                        <span><?= $totalUsers ?></span>
                    </div>
                </div>
            </div>
            <div class="feedback">
                <h1>Feedback Pengguna</h1>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Pesan</th>
                        </tr>
                    </thead>
                    <tbody id="feedback-table">
                    <!-- Data mengambil dari API Feedback -->
                    </tbody>
                </table>
            </div>
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
    <script src="js/admin.js"></script>
</body>

</html>