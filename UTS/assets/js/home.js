$(function() {
    const categoryApiUrl = 'api/get_menu_by_kategori.php'; 

    $('body').on('click', '.kategori-link', function(e) {
        e.preventDefault(); 
        
        const $link = $(this);
        const kategoriId = $link.data('kategori-id');
        
        $('.kategori-link').removeClass('active');
        $link.addClass('active'); 
        
        const $menuContainer = $('#menu-list-container');
        $menuContainer.css('opacity', 0.5); 
        $menuContainer.html('<p style="text-align:center; padding: 40px;">Memuat menu...</p>');
        
        $.ajax({
            url: categoryApiUrl,
            method: 'POST',
            data: {
                kategori_id: kategoriId
            },
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    
                    $menuContainer.html(data.html);
                } else {
                    $menuContainer.html('<p style="padding:20px;">Error: Gagal memuat menu. ' + data.html + '</p>');
                }
            },
            error: function() {
                $menuContainer.html('<p style="padding:20px;">Kesalahan koneksi saat memuat menu.</p>');
            },
            complete: function() {
                
                $menuContainer.css('opacity', 1); 
            }
        });
    });

    const addToCartUrl = 'api/add_to_cart.php'; 

    $('body').on('click', '.add-to-cart-btn', function() {
        
        const $button = $(this);
        const menuId = $button.data('menu-id');
        
        $button.prop('disabled', true).find('span').text('Menambah...'); 

        $.ajax({
            url: addToCartUrl,
            method: 'POST',
            data: {
                menu_id: menuId
            },
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    $('.total-bayar h3:last-child').text('Rp' + data.new_grand_total);
                    
                    const $existingItemQty = $(`#qty-${data.menu_id}`);
                    
                    if ($existingItemQty.length) {
                        $existingItemQty.text(data.item_new_qty);
                    } else {
                        $('.cart').append(data.new_item_html);
                    }
                } else {
                    alert('Gagal menambahkan item: ' + data.message);
                }
            },
            error: function() {
                showNotification('Terjadi kesalahan koneksi.', 'error');
            },
            complete: function() {
                $button.prop('disabled', false).find('span').text('Tambah');
            }
        });
    });
});