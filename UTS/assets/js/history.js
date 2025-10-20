$(function() {
    const deleteOrderUrl = 'api/delete_order.php'; 

    $('body').on('click', '.delete-order-btn', function() {
        
        const $button = $(this);
        const orderId = $button.data('order-id');
        
        if (!confirm(`Apakah Anda yakin ingin menghapus Pesanan #${orderId} secara permanen?`)) {
            return;
        }

        $button.prop('disabled', true).text('Menghapus...');

        $.ajax({
            url: deleteOrderUrl,
            method: 'POST',
            data: {
                order_id: orderId
            },
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    showNotification(`Pesanan #${orderId} berhasil dihapus.`, 'success');
                    
                    $(`#order-${orderId}`).fadeOut(500, function() {
                        $(this).next('hr').remove(); 
                        $(this).remove(); 
                        
                        if ($('.order-card').length === 0) {
                             $('.riwayat-pemesanan').append('<p>Belum ada riwayat pemesanan yang tersimpan.</p>');
                        }
                    });
                    
                } else {
                    showNotification('Gagal menghapus pesanan: ' + data.message, 'error');
                }
            },
            error: function() {
                showNotification('Terjadi kesalahan koneksi atau server.', 'error');
            },
            complete: function() {
                if ($(`#order-${orderId}`).length) {
                    $button.prop('disabled', false).text('Hapus Order');
                }
            }
        });
    });
});