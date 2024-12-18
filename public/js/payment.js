const form = document.querySelector('#checkoutForm');
const payButton = document.getElementById('pay-btn');

form.addEventListener('submit', function(e) {
    e.preventDefault();
});

payButton.addEventListener('click', async function (e) {
    e.preventDefault();

    const formData = new FormData(form);

    // Mengirimkan data form ke server untuk mendapatkan snapToken
    fetch('http://localhost:8080/payment', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // Pastikan data yang diterima berisi snapToken
        if (data.snapToken) {
            // Menampilkan pop-up Midtrans dengan token yang diterima
            snap.pay(data.snapToken, {
                onSuccess: function(result) {
                    // Mengirimkan data pembayaran setelah sukses
                    // let dataResult = JSON.stringify(result, null, 2);
                    // let dataObj = JSON.parse(dataResult);

                    fetch('http://localhost:8080/payment/success', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            order_id: data.order_id,
                            user_id: data.user_id,
                            order_date: data.order_date,
                            order_type: data.order_type,
                            order_status: data.order_status,
                            table_number: data.table_number,
                            address: data.table_number ? null : data.address,
                            payment_status: 'sudah bayar',
                            payment_date: new Date().toISOString().slice(0,19).replace('T', ' '),
                            payment_method: result.payment_type,
                            total_amount: data.total_amount,
                            product_ids: data.product_ids,
                            quantity: data.quantity,
                            price: data.price,
                            snapToken: data.snapToken
                        })
                    })
                    .then(response => response.json())
                    .then(result => {
                        console.log('Payment data sent successfully:', result);
                    })
                    .catch(error => {
                        console.error('Error sending payment data:', error);
                    });
                },
                onPending: function(result) {
                    console.log('Payment pending:', result);
                },
                onError: function(result) {
                    console.error('Payment error:', result);
                }
            });
        } else {
            console.error("Snap Token not received.");
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
