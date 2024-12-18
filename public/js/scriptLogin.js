// READ MORE //
document.getElementById('read-more-button').addEventListener('click', function (e) {
    e.preventDefault();

    const moreTextElements = document.querySelector('.more-text');
    const aboutContainer = document.querySelector('.about-container');
    const paragraphs = moreTextElements.querySelectorAll('p');

    const currentDisplay = window.getComputedStyle(moreTextElements).display;

    if (currentDisplay === 'none') {
        aboutContainer.style.height = '700px';
        moreTextElements.style.display = 'block';
        paragraphs.forEach((paragraph, index) => {
            setTimeout(function () {
                paragraph.style.opacity = '1';
            }, index * 100);
        });


        document.getElementById('read-more-button').textContent = 'Read less...';
    } else {
        paragraphs.forEach(paragraph => {
            paragraph.style.opacity = '0';
        });

        setTimeout(function () {
            moreTextElements.style.display = 'none';
            aboutContainer.style.height = '300px';
        }, 300);

        document.getElementById('read-more-button').textContent = 'Read more...';
    }
});

// NAVBAR //
const cartButtons = document.querySelectorAll('.cart-button');
const sidebar = document.querySelector('.cart-side');
cartButtons.forEach(button => {
    button.onclick = () => {
        sidebar.classList.toggle('active');
    };
});

// BEST PRODUCT DOM //
document.addEventListener('DOMContentLoaded', () => {
    const bestProductIds = [1, 22, 14, 13, 9, 17, 18, 21, 26, 20];
    const productList = document.getElementById('product-list');
    const apiURL = "http://localhost:8080/api/products";
    
    fetch(apiURL)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            // Pastikan data produk ada
            if (data.products && data.products.length > 0) {
                // Filter produk berdasarkan ID yang sesuai
                const bestProducts = data.products.filter(product =>
                    bestProductIds.includes(parseInt(product.product_id))
                ); 
                displayProducts(bestProducts);
            } else {
                productList.innerHTML = '<p>Produk tidak tersedia.</p>';
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            productList.innerHTML = '<p>Terjadi kesalahan saat mengambil produk.</p>';
        });

    // Fungsi untuk menampilkan produk
    function displayProducts(products) {
        products.forEach(product => {
            const productCard = document.createElement('div');
            productCard.classList.add('product-card');

            const img = document.createElement('img');
            img.src = product.image; // URL gambar dari API
            img.alt = product.product_name;

            const h3 = document.createElement('h3');
            h3.textContent = product.product_name; // Nama produk dari API

            const p = document.createElement('p');
            p.textContent = product.description; // Deskripsi produk dari API

            productCard.appendChild(img);
            productCard.appendChild(h3);
            productCard.appendChild(p);

            productList.appendChild(productCard);
        });
    }

    const scrollLeft = document.getElementById('scroll-left');
    const scrollRight = document.getElementById('scroll-right');

    scrollLeft.addEventListener('click', () => {
        productList.scrollBy({
            left: -300,
            behavior: 'smooth'
        });
    });

    scrollRight.addEventListener('click', () => {
        productList.scrollBy({
            left: 300,
            behavior: 'smooth'
        });
    });
});

// ALPINE IMPLEMENTATION //
document.addEventListener('alpine:init', () => {
    Alpine.data('products', () => ({
        selectedCategory: 'all',
        categories: [],
        items: [],
        loading: true, // Status loading

        async fetchData() {
            try {
                this.loading = true;
        
                const response = await fetch('http://localhost:8080/api/categories');
                const data = await response.json();
        
                // Format data API ke struktur yang digunakan
                this.categories = data.map(cat => ({
                    category: cat.category,
                    products: cat.products.map(prod => ({
                        id: prod.product_id,
                        name: prod.product_name,
                        img: prod.image,
                        price: parseFloat(prod.price), // Konversi ke angka
                        description: prod.description,
                        stock: parseInt(prod.stock, 10), // Konversi ke angka
                        dataSet: cat.category // Tetapkan kategori untuk filter
                    }))
                }));
        
                // Menggabungkan semua produk
                this.items = this.categories.flatMap(category => category.products);
                console.log('Items:', this.items);
            } catch (error) {
                console.error('Error fetching data:', error);
            } finally {
                this.loading = false;
            }
        },

        filterItems() {
            if (this.selectedCategory === 'all') {
                // Tampilkan semua produk
                this.items = this.categories.flatMap(category => category.products);
            } else {
                // Tampilkan produk berdasarkan kategori
                const category = this.categories.find(cat => cat.category === this.selectedCategory);
                this.items = category ? category.products : [];
            }
        },

        init() {
            this.fetchData(); // Panggil saat Alpine.js diinisialisasi
        }
    }));

    // Alpine Store untuk Keranjang Tetap Sama
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


const rupiah = (number) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 2,
    }).format(number);
};

const subMenu = document.getElementById("sub-menu");
function toggleMenu() {
    subMenu.classList.toggle("open-menu");
}

function showNotification() {
    const notification = document.getElementById("notificationPopup");
    notification.style.opacity = 1;
    setTimeout(() => {
        notification.style.opacity = 0;
    }, 1000);
}

document.addEventListener('DOMContentLoaded', () => {
    const notification = document.querySelector('.notification-popup2');
    if (notification) {
        setTimeout(() => {
            notification.style.opacity = 0;
        }, 2000);
    }
});