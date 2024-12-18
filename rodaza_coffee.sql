INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Site Administrator'),
(2, 'user', 'Regular User');

INSERT INTO `auth_permissions` (`id`, `name`, `description`) VALUES
(1, 'manage-orders', 'Manage all orders'),
(2, 'manage-profiles', 'Manage users profile');

INSERT INTO `auth_groups_permissions` (`group_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(2, 2);

INSERT INTO `categories` (`category_id`, `category_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Foods', 'Makanan berat', NULL, NULL),
(2, 'Beverages', 'Minuman, termasuk Coffee dan Non-Coffee', NULL, NULL),
(3, 'Snacks', 'Cemilan kecil untuk berbagi', NULL, NULL);

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `price`, `description`, `image`, `stock`) VALUES
(1, 2, 'Rodaza Coffee', 20000.00, 'Kopi segar khas Rodaza yang memberi energi ekstra.', 'assets/product/product1.jpg', 50),
(2, 2, 'Hot Latte', 18000.00, 'Latte panas lembut untuk meningkatkan semangat harian Anda.', 'assets/product/product2.jpg', 40),
(3, 3, 'Macaroons', 22000.00, 'Macaron lezat dengan beragam pilihan rasa yang menggoda.', 'assets/product/product3.jpg', 30),
(4, 3, 'Sandwich', 15000.00, 'Sandwich enak dan mengenyangkan, cocok untuk camilan sore.', 'assets/product/product4.jpg', 25),
(5, 2, 'Brown Coffee', 15000.00, 'Kopi dengan cita rasa kaya gula merah, menyegarkan.', 'assets/product/product5.jpg', 35),
(6, 2, 'Black Coffee', 12000.00, 'Kopi hitam murni dengan rasa yang kuat dan pekat.', 'assets/product/product6.jpg', 45),
(7, 2, 'Mochaccino Latte', 18000.00, 'Kombinasi kopi dan coklat manis yang menggugah selera.', 'assets/product/product7.jpg', 40),
(8, 2, 'Ice Cream Coffee', 25000.00, 'Kopi dingin dengan es krim lembut di atasnya, nikmat dan menyegarkan.', 'assets/product/product8.jpg', 20),
(9, 2, 'Red Coffee Latte', 20000.00, 'Latte merah unik dengan rasa khas yang berani dan segar.', 'assets/product/product9.jpg', 30),
(10, 2, 'Cappuccino Latte', 20000.00, 'Cappuccino klasik dengan busa krim yang lembut di atasnya.', 'assets/product/product10.jpg', 25),
(11, 3, 'Potato Fries', 22000.00, 'Kentang goreng renyah dengan rasa gurih yang pas.', 'assets/product/product11.jpg', 50),
(12, 3, 'Brown Cookies', 18000.00, 'Kue kering coklat yang manis dan lezat untuk teman kopi Anda.', 'assets/product/product12.jpg', 35),
(13, 3, 'Rodaza Salad', 15000.00, 'Salad segar khas Rodaza, sehat dan menggugah selera.', 'assets/product/product13.jpg', 25),
(14, 3, 'Rodaza Mini Pizza', 25000.00, 'Pizza mini khas Rodaza dengan topping istimewa.', 'assets/product/product14.jpg', 20),
(15, 3, 'Crunchy Potato Mayo', 18000.00, 'Camilan kentang gurih dengan saus mayo, renyah di luar, lembut di dalam.', 'assets/product/product15.jpg', 30),
(16, 3, 'Cookie Balls', 15000.00, 'Bola kue kecil dengan rasa manis yang pas untuk camilan.', 'assets/product/product16.jpg', 40),
(17, 1, 'Prawn Fried Rice', 25000.00, 'Nasi goreng udang lezat dengan bumbu khas yang menggoda.', 'assets/product/product17.jpg', 20),
(18, 3, 'Minced Beef', 32000.00, 'Daging sapi cincang yang juicy, pas untuk hidangan Anda.', 'assets/product/product18.jpg', 15),
(19, 3, 'Churros', 15000.00, 'Churros manis dan renyah dengan taburan gula, cocok untuk pencuci mulut.', 'assets/product/product19.jpg', 35),
(20, 2, 'Tea Vanilla Shake', 20000.00, 'Teh shake dingin dengan sentuhan vanilla yang menyegarkan.', 'assets/product/product20.jpg', 25),
(21, 1, 'Pasta', 25000.00, 'Pasta lezat dengan saus kaya yang menggugah selera.', 'assets/product/product21.jpg', 20),
(22, 1, 'Rodaza Burger', 30000.00, 'Burger khas Rodaza yang juicy dengan bahan premium.', 'assets/product/product22.jpg', 15),
(23, 1, 'Fried Noodle', 24000.00, 'Mie goreng khas dengan bumbu gurih yang pas di lidah.', 'assets/product/product23.jpg', 30),
(24, 1, 'Kwetiau', 18000.00, 'Kwetiau digoreng dengan sempurna, lezat dan gurih.', 'assets/product/product24.jpg', 25),
(25, 3, 'Chocolate Bar', 15000.00, 'Cokelat batang yang creamy dan lezat, menyenangkan untuk dinikmati.', 'assets/product/product25.jpg', 50),
(26, 3, 'Gyoza', 25000.00, 'Dumpling Jepang yang diisi dengan rasa gurih, lezat dan kenyal.', 'assets/product/product26.jpg', 20);
