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
