$(function() {
    const updateHandlerUrl = 'api/update_cart.php'; 
    const confirmUrl = 'api/confirm_order.php'; 

    $('body').on('click', '.qty-btn', function () {
        
        const $button = $(this);
        const $handlerDiv = $button.closest('.handler-qty');
        const menuId = $handlerDiv.data('menu-id'); 
        const action = $button.data('action');
        
        const $qtyDisplay = $handlerDiv.find('.qty-display');
        const $cartListItem = $handlerDiv.closest('.cart-list');
        
        let currentQty = parseInt($qtyDisplay.text().trim());
        let newQty = currentQty;

        if (action === 'increment') {
            newQty++;
        } else if (action === 'decrement' && currentQty > 0) {
            newQty--;
        }

        if (newQty < 1 && action === 'decrement') {
            if (!confirm(`Apakah Anda yakin ingin menghapus item ini dari keranjang?`)) {
                return; 
            }
        } else if (newQty < 1) {
            return;
        }

        $qtyDisplay.text(newQty);
        $handlerDiv.find('.qty-btn').prop('disabled', true); 

        $.ajax({
            url: updateHandlerUrl,
            method: 'POST',
            data: { 
                menu_id: menuId, 
                action: action, 
                expected_qty: newQty 
            },
            dataType: 'json',
            success: (function (data) {
                if (data.success) {
                    if (data.new_qty > 0) {
                        $(`#qty-${data.menu_id}`).text(data.new_qty); 
                    } else {
                        $cartListItem.fadeOut(300, function() { $(this).remove(); });
                    }
                    
                    $('.total-bayar h3:last-child').text('Rp' + data.new_grand_total);
                } else {
                    showNotification('Gagal memperbarui: ' + data.message, 'error');
                    $qtyDisplay.text(currentQty);
                }
            }),
            error: (function(xhr, status, error){
                showNotification('Terjadi kesalahan koneksi saat update.', 'error');
                $qtyDisplay.text(currentQty); 
            }),
            complete: function() {
                $handlerDiv.find('.qty-btn').prop('disabled', false); 
            }
        });
    });

    $('#confirm-payment-btn').on('click', function() {
        if ($('.cart-list').length === 0) {
            showNotification('Keranjang belanja masih kosong!', 'error');
            return;
        }
        $('#payment-modal').fadeIn(300); 
    });

    $('#close-modal-btn').on('click', function() {
        $('#payment-modal').fadeOut(300);
    });

    $('#process-order-btn').on('click', function() {
        const customerName = $('#customer-name').val().trim();
        
        if (customerName === '') {
            showNotification('Nama pelanggan wajib diisi.', 'error');
            return;
        }

        const orderType = $('input[name="order-type"]:checked').val();
        const paymentMethod = $('input[name="payment-method"]:checked').val();
        
        const $processButton = $(this);
        $processButton.prop('disabled', true).text('Mengirim...');
        
        $.ajax({
            url: confirmUrl,
            method: 'POST',
            data: {
                order_type: orderType,          
                payment_method: paymentMethod, 
                nama_pelanggan: customerName 
            },
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    showNotification('Pesanan #' + data.new_order_id + ' berhasil dibuat untuk ' + customerName + '.', 'success');
                    
                    $('.cart').empty(); 
                    $('.total-bayar h3:last-child').text('Rp0');
                    $('#customer-name').val('');
                    
                    $('#payment-modal').fadeOut(300); 

                } else {
                    showNotification('Gagal memproses pesanan: ' + data.message, 'error');
                }
            },
            error: function() {
                showNotification('Terjadi kesalahan koneksi.', 'error');
            },
            complete: function() {
                $processButton.prop('disabled', false).text('Proses Pesanan');
            }
        });
    });
});