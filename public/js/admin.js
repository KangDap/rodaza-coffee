const subMenu = document.getElementById("sub-menu");
function toggleMenu() {
    subMenu.classList.toggle("open-menu");
}


// FEEDBACK TABLE
document.addEventListener('DOMContentLoaded', async () => {
    const feedbackTable = document.getElementById('feedback-table');

    try {
        const response = await fetch('http://localhost:8080/api/feedbacks');
        const data = await response.json();

        if (data.feedbacks && Array.isArray(data.feedbacks)) {
            data.feedbacks.forEach((feedback, index) => {
                const row = document.createElement('tr');

                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${feedback.username}</td>
                    <td>${feedback.email}</td>
                    <td>${feedback.message}</td>
                `;

                feedbackTable.appendChild(row);
            });
        } else {
            feedbackTable.innerHTML = '<tr><td colspan="4">Tidak ada data feedback</td></tr>';
        }
    } catch (error) {
        console.error('Error fetching feedbacks:', error);
        feedbackTable.innerHTML = '<tr><td colspan="4">Gagal memuat data</td></tr>';
    }
});


// ORDER TABLE (DELIVERY & DINE-IN)
document.addEventListener('DOMContentLoaded', async () => {
    const deliveryTable = document.querySelector('table.delivery tbody');
    const dineInTable = document.querySelector('table.dine-in tbody');

    let indexDelivery = 0;
    let indexDineIn = 0;

    try {
        const response = await fetch('http://localhost:8080/api/orders');
        const data = await response.json();

        data.forEach((orderData) => {
            const order = orderData.order;
            const orderItems = orderData.orderItems;
            const user = orderData.user;
            const products = orderData.products;

            // Siapkan detail pesanan untuk modal dengan nama produk
            const orderDetailsArray = orderItems.map(item => {
                const product = products.find(p => p.product_id == item.product_id);
                const productName = product ? product.product_name : `Produk ${item.product_id}`;
                return `${productName} (Rp ${parseFloat(item.price).toLocaleString()}) x ${item.quantity}`;
            });

            // Escape string untuk digunakan di @click
            const orderDetailsStr = JSON.stringify(orderDetailsArray).replace(/"/g, '&quot;');
            const totalPrice = `Rp ${parseFloat(order.total_amount).toLocaleString()},00`;
            const orderID = JSON.stringify(order.order_id).replace(/"/g, '&quot;');

            console.log(orderDetailsStr);
            console.log(totalPrice);
            console.log(orderID);

            // Tentukan tabel target dan indeks yang digunakan
            let targetTable, index;
            if (order.order_type === 'delivery') {
                indexDelivery++;
                targetTable = deliveryTable;
                index = indexDelivery;
            } else {
                indexDineIn++;
                targetTable = dineInTable;
                index = indexDineIn;
            }

            // Buat baris tabel
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${index}</td>
                <td>${order.order_type === 'delivery' ? 'Delivery' : 'Dine-In'}</td>
                <td>${order.order_type === 'delivery' ? (order.address || '-') : order.table_number}</td>
                <td>${user.username}</td>
                <td>${order.payment_status}</td>
                <td>${order.order_status}</td>
                <td>
                    <button class="detail-btn"
                        @click="showModal = true; orderDetails = JSON.parse('${orderDetailsStr}'); totalPrice = '${totalPrice}'; orderID = ${orderID}">
                        Lihat Detail
                    </button>

                    <!-- Tombol Proses jika status order adalah 'menunggu' -->
                    ${order.order_status === 'menunggu' ? `
                        <button class="detail-btn"
                            onclick="if (confirm('Apakah Anda yakin ingin memproses pesanan ini?')) {
                                        window.location.href = 'http://localhost:8080/admin/process-order/${order.order_id}';
                                    }">
                            Proses
                        </button>
                    ` : ''}

                    <!-- Tombol Selesai jika status order adalah 'diproses' -->
                    ${order.order_status === 'diproses' ? `
                        <button class="detail-btn"
                            onclick="if (confirm('Apakah Anda yakin ingin menyelesaikan pesanan ini?')) {
                                        window.location.href = 'http://localhost:8080/admin/complete-order/${order.order_id}';
                                    }">
                            Selesai
                        </button>
                    ` : ''}
                </td>
            `;

            targetTable.appendChild(row);
        });
    } catch (error) {
        console.error('Error fetching orders:', error);
    }
});

// NOTIFICATION
document.addEventListener('DOMContentLoaded', () => {
    const notification = document.querySelector('.notification-popup');
    if (notification) {
        setTimeout(() => {
            notification.style.opacity = 0;
        }, 2000);
    }
});
