function showNotification(message, type) {
        const $container = $('#notification-container');
        
        const $alert = $('<div>')
            .addClass('custom-alert ' + type)
            .html(message)
            .hide();

        $container.append($alert);
        $alert.slideDown(300, function() {
            $(this).addClass('show');
        });

        setTimeout(function() {
            $alert.removeClass('show').slideUp(300, function() {
                $(this).remove(); 
            });
        }, 4000);
    }

$(function() {
    const confirmUrl = 'api/confirm_order.php'; 

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
    
});