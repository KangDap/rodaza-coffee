const subMenu = document.getElementById("sub-menu");
function toggleMenu() {
    subMenu.classList.toggle("open-menu");
}

// ALPINE IMPLEMENTATION //
document.addEventListener('alpine:init', () => {
    Alpine.data('products', () => ({
        selectedCategory: 'all',
        items: [
            { id: 1, name: 'Rodaza Coffee', img: 'assets/product/product1.jpg', price: 20000, dataSet: 'beverages' },
            { id: 2, name: 'Hot Latte', img: 'assets/product/product2.jpg', price: 18000, dataSet: 'beverages' },
            { id: 3, name: 'Macaroons', img: 'assets/product/product3.jpg', price: 22000, dataSet: 'snacks' },
            { id: 4, name: 'Sandwich', img: 'assets/product/product4.jpg', price: 15000, dataSet: 'snacks' },
            { id: 5, name: 'Brown Coffee', img: 'assets/product/product5.jpg', price: 15000, dataSet: 'beverages' },
            { id: 6, name: 'Black Coffee', img: 'assets/product/product6.jpg', price: 12000, dataSet: 'beverages' },
            { id: 7, name: 'Mochaccino Latte', img: 'assets/product/product7.jpg', price: 18000, dataSet: 'beverages' },
            { id: 8, name: 'Ice Cream Coffee', img: 'assets/product/product8.jpg', price: 25000, dataSet: 'beverages' },
            { id: 9, name: 'Red Coffee Latte', img: 'assets/product/product9.jpg', price: 20000, dataSet: 'beverages' },
            { id: 10, name: 'Cappuccino Latte', img: 'assets/product/product10.jpg', price: 20000, dataSet: 'beverages' },
            { id: 11, name: 'Potato Fries', img: 'assets/product/product11.jpg', price: 22000, dataSet: 'snacks' },
            { id: 12, name: 'Brown Cookies', img: 'assets/product/product12.jpg', price: 18000, dataSet: 'snacks' },
            { id: 13, name: 'Rodaza Salad', img: 'assets/product/product13.jpg', price: 15000, dataSet: 'snacks' },
            { id: 14, name: 'Rodaza Mini Pizza', img: 'assets/product/product14.jpg', price: 25000, dataSet: 'snacks' },
            { id: 15, name: 'Crunchy Potato Mayo', img: 'assets/product/product15.jpg', price: 18000, dataSet: 'snacks' },
            { id: 16, name: 'Cookie Balls', img: 'assets/product/product16.jpg', price: 15000, dataSet: 'snacks' },
            { id: 17, name: 'Prawn Fried Rice', img: 'assets/product/product17.jpg', price: 25000, dataSet: 'food' },
            { id: 18, name: 'Minced Beef', img: 'assets/product/product18.jpg', price: 32000, dataSet: 'snacks' },
            { id: 19, name: 'Churros', img: 'assets/product/product19.jpg', price: 15000, dataSet: 'snacks' },
            { id: 20, name: 'Tea Vanilla Shake', img: 'assets/product/product20.jpg', price: 20000, dataSet: 'beverages' },
            { id: 21, name: 'Pasta', img: 'assets/product/product21.jpg', price: 25000, dataSet: 'food' },
            { id: 22, name: 'Rodaza Burger', img: 'assets/product/product22.jpg', price: 30000, dataSet: 'food' },
            { id: 23, name: 'Fried Noodle', img: 'assets/product/product23.jpg', price: 24000, dataSet: 'food' },
            { id: 24, name: 'Kwetiau', img: 'assets/product/product24.jpg', price: 18000, dataSet: 'food' },
            { id: 25, name: 'Chocolate Bar', img: 'assets/product/product25.jpg', price: 15000, dataSet: 'snacks' },
            { id: 26, name: 'Gyoza', img: 'assets/product/product26.jpg', price: 25000, dataSet: 'snacks' }
        ]
    }));

    Alpine.data('orderForm', () => ({
        orderType: '', // Untuk melacak pilihan dine-in atau take-away
        inputValue: '', // Menyimpan alamat atau nomor meja
        submitOrder() {
            if (!this.orderType) {
                alert('Silakan pilih Delivery atau Dine In!');
                return;
            }
            if (!this.inputValue) {
                alert(`Silakan masukkan ${this.orderType === 'delivery' ? 'alamat' : 'nomor meja'}!`);
                return;
            }
            alert('Pesanan Anda berhasil diproses.');
            // Logika submit pesanan bisa ditambahkan di sini
        },
    }));

    Alpine.store('cart', {
        items: [],
        total: 0,
        quantity: 0,

        add(newItem) {
            const cartItem = this.items.find((item) => item.id === newItem.id);
            if (!cartItem) {
                this.items.push({ ...newItem, quantity: 1, total: newItem.price });
                this.quantity++;
                this.total += newItem.price;
            } else {
                this.items = this.items.map((item) => {
                    if (item.id !== newItem.id) {
                        return item;
                    } else {
                        item.quantity++;
                        item.total = item.price * item.quantity;
                        this.quantity++;
                        this.total += newItem.price;
                        return item;
                    }
                });
                this.items = Alpine.clone(this.items); // Menjamin reaktifitas
            }
        },
        remove(id) {
            const cartItem = this.items.find((item) => item.id === id);

            if (cartItem.quantity > 1) {
                this.items = this.items.map((item) => {
                    if (item.id !== id) {
                        return item;
                    } else {
                        item.quantity--;
                        item.total = item.price * item.quantity;
                        this.quantity--;
                        this.total -= item.price;
                        return item;
                    }
                })
            } else if (cartItem.quantity === 1) {
                this.items = this.items.filter((item) => item.id !== id);
                this.quantity--;
                this.total -= cartItem.price;
            }
        }
    });
});

function showNotification() {
    const notification = document.getElementById("notificationPopup");
    notification.style.opacity = 1;
    setTimeout(() => {
        notification.style.opacity = 0;
    }, 1000);
}

const rupiah = (number) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 2,
    }).format(number);
};

const cartButton = document.getElementById('cart');
const sidebar = document.querySelector('.cart-side');
cartButton.onclick = () => {
    sidebar.classList.toggle('active');
};

document.addEventListener('DOMContentLoaded', () => {
    const notification = document.querySelector('.notification-popup');
    if (notification) {
        setTimeout(() => {
            notification.style.opacity = 0;
        }, 2000);
    }
});


// async function loadOrderHistory() {
//     const tableBody = document.getElementById('order-history-body');
//     tableBody.innerHTML = ''; // Hapus isi tabel sebelumnya

//     try {
//         // Panggil API untuk mendapatkan data order history
//         const response = await fetch('http://localhost:8080/api/order-history/3'); // Sesuaikan endpoint API Anda
//         const data = await response.json();

//         if (response.ok) {
//             const orderHistory = data.orderHistory;
//             let rowNumber = 1;

//             orderHistory.forEach(order => {
//                 // Buat baris baru untuk setiap order
//                 const row = document.createElement('tr');

//                 // Kolom nomor
//                 const colNo = document.createElement('td');
//                 colNo.textContent = rowNumber++;
//                 row.appendChild(colNo);

//                 // Kolom tanggal pesan
//                 const colDate = document.createElement('td');
//                 colDate.textContent = order.order_date;
//                 row.appendChild(colDate);

//                 // Kolom jenis pesanan
//                 const colType = document.createElement('td');
//                 colType.textContent = order.order_type;
//                 row.appendChild(colType);

//                 // Kolom pesanan dan harga
//                 const colItems = document.createElement('td');
//                 colItems.innerHTML = order.items
//                     .map(item => `- ${item.name}: Rp${item.price.toLocaleString()}`)
//                     .join('<br>');
//                 row.appendChild(colItems);

//                 // Kolom total harga
//                 const colTotal = document.createElement('td');
//                 colTotal.textContent = `Rp${order.total_amount.toLocaleString()}`;
//                 row.appendChild(colTotal);

//                 // Tambahkan baris ke tabel
//                 tableBody.appendChild(row);
//             });
//         } else {
//             console.error('Gagal mengambil data:', data);
//         }
//     } catch (err) {
//         console.error('Terjadi kesalahan:', err.message);
//     }
// }

// // Panggil fungsi untuk memuat data ketika halaman selesai dimuat
// document.addEventListener('DOMContentLoaded', loadOrderHistory);