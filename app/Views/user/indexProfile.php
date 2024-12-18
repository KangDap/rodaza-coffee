<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome To Rodaza Coffee</title>
    <link rel="stylesheet" href="/css/styleProfile.css">
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

        <!-- Floating Whatsapp Button -->
        <a href="#nomorwa" target="_blank" id="toggle" class="wa">
            <i class="fa-brands fa-whatsapp"></i>
            <div class="join">
                <p>Order By Whatsapp</p>
            </div>
        </a>

        <!-- Landing Page -->
        <div class="hero-container" id="home">
            <h1>Personal Info</h1>
            <p>Info tentang Anda dan pesanan Anda pada Rodaza Coffee</p>

            <?php if(session()->has('success')) : ?>
                <div class="notification-popup success">
                    <?= session('success') ?>
                </div>
            <?php endif ?>

            <div class="profile-container">
                <img src=<?= user()->__get('profile_picture') ?> alt="Profile Picture">
                <hr>
                <p><strong>Nama</strong> <?=user()->__get('username')?></p>
                <p><strong>Email</strong> <?=user()->__get('email')?></p>
                <p><strong>Tanggal Lahir</strong> <?= user()->__get('birthdate') ?? "-" ?> </p>
                <p><strong>Alamat</strong> <?= user()->__get('address') ?? "-" ?> </p>
                <p><strong>No HP</strong> <?= user()->__get('phone_number') ?? "-" ?> </p>
                <button onclick="window.location.href='<?= route_to('edit-profile') ?>'">
                    Edit Info
                </button>
            </div>

            <?php
                $db = \Config\Database::connect();
                $userId = user()->id;

                // Query database
                $builder = $db->table('orders');
                $builder->select('orders.order_id, orders.order_date, orders.order_type, orders.order_status, orders.total_amount, order_items.quantity, order_items.price, products.product_name');
                $builder->join('order_items', 'order_items.order_id = orders.order_id', 'left');
                $builder->join('products', 'products.product_id = order_items.product_id', 'left');
                $builder->where('orders.user_id', $userId);
                $builder->orderBy('orders.order_date', 'DESC');
                $result = $builder->get()->getResultArray();

                // Strukturkan data berdasarkan order_id
                $orderHistory = [];
                foreach ($result as $row) {
                    $orderId = $row['order_id'];
                    if (!isset($orderHistory[$orderId])) {
                        $orderHistory[$orderId] = [
                            'order_date' => $row['order_date'],
                            'order_type' => $row['order_type'] === 'dine-in' ? 'Dine-in' : 'Delivery',
                            'order_status' => ($row['order_status'] === 'menunggu') ? 'Menunggu' : (($row['order_status'] === 'diproses') ? 'Diproses' : 'Selesai'),
                            'total_amount' => $row['total_amount'],
                            'items' => []
                        ];
                    }
                    $orderHistory[$orderId]['items'][] = [
                        'name' => $row['product_name'],
                        'quantity' => $row['quantity'],
                        'price' => $row['price']
                    ];
                }
                ?>

                <div class="order-history-container">
                    <h2>History Pemesanan</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Pesan</th>
                                <th>Jenis Pesanan</th>
                                <th>Pesanan dan Harga</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($orderHistory)): ?>
                                <?php $rowNumber = 1; ?>
                                <?php foreach ($orderHistory as $order): ?>
                                    <tr>
                                        <td><?= $rowNumber++ ?></td>
                                        <td><?= $order['order_date'] ?></td>
                                        <td><?= $order['order_type'] ?></td>
                                        <td>
                                            <?php foreach ($order['items'] as $item): ?>
                                                - <?= $item['name'] ?> &times;<?= $item['quantity'] ?> : Rp<?= number_format($item['price'], 0, ',', '.') ?><br>
                                            <?php endforeach; ?>
                                        </td>
                                        <td>Rp<?= number_format($order['total_amount'], 0, ',', '.') ?></td>
                                        <td><?= $order['order_status'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">Tidak ada data pemesanan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
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
    <script src="/js/profile.js"></script>
</body>

</html>