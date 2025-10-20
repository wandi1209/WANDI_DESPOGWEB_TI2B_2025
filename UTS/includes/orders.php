<?php 
    $keranjang = $_SESSION['keranjang'] ?? []; 
    $menu = $_SESSION['menu'] ?? []; 
    $orders = $_SESSION['orders'] ?? [];
    
    $menuMap = [];
    foreach ($menu as $m) {
        if (isset($m['id'])) {
            $menuMap[$m['id']] = $m;
        }
    }

    $grandTotal = 0;

    function calculateInitialTotal(array $keranjang, array $menuMap) {
        $total = 0;
        foreach ($keranjang as $item) {
            $itemId = $item['menus_id'] ?? null;
            $qty = $item['qty'] ?? 0;
            if ($itemId && isset($menuMap[$itemId]['harga'])) {
                $total += $menuMap[$itemId]['harga'] * $qty;
            }
        }
        return $total;
    }
    
    $grandTotal = calculateInitialTotal($keranjang, $menuMap);

    $nextOrderId = 1000; 
    
    if (!empty($orders)) {
        $lastOrderId = 0;
        foreach ($orders as $o) {
            if (($o['id'] ?? 0) > $lastOrderId) {
                $lastOrderId = $o['id'];
            }
        }
        $nextOrderId = $lastOrderId + 1;
    }
?>

<div id="orders">
    <div class="header-order">
        <h1>Order #<?php echo $nextOrderId; ?></h1>
        <div class="radio-button-group">
            <input type="radio" id="radio-dine-in" name="order-type" value="dine-in" checked>
            <label for="radio-dine-in">Dine In</label>
            <input type="radio" id="radio-to-go" name="order-type" value="to-go">
            <label for="radio-to-go">To Go</label>
        </div>
        <div class="divider"></div>
        <div class="cart">
            <?php foreach ($keranjang as $k){ 
                $menuItem = $menuMap[$k['menus_id']];
            ?>    
                <div class="cart-list">
                    <img class="cart-img" src="<?php echo $menuItem['image_url'] ?>" alt="Image">
                    <div>
                        <h1><?php echo $menuItem['name']?></h1>
                        <p class="cart-price">Rp<?php 
                            $subtotal = $menuItem['harga'] * $k['qty'];
                            echo number_format($subtotal, 0, ',', '.');
                        ?></p>
                    </div>
                   <div class="handler-qty" 
                        data-menu-id="<?php echo $k['menus_id']; ?>"> 
                        
                        <button type="button" class="qty-btn" data-action="decrement">-</button>
                        
                        <span class="qty-display" id="qty-<?php echo $k['menus_id']; ?>">
                            <?php echo $k['qty']?>
                        </span>
                        
                        <button type="button" class="qty-btn" data-action="increment">+</button>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="divider"></div>
        <div class="footer-order">
            <div class="metode-pembayaran">
                <h1>Metode Pembayaran :</h1>
                <input type="radio" id="radio-qris" name="payment-method" value="qris">
                <label for="radio-qris">
                    <?php include 'assets/images/icons/qris.svg'; ?>
                    <span>QRIS</span>
                </label>
                <input type="radio" id="radio-cash" name="payment-method" value="cash" checked>
                <label for="radio-cash">
                    <?php include 'assets/images/icons/cash.svg'; ?>
                    <span>CASH</span>
                </label>
            </div>
            <div class="total-bayar">
                <h3>Total Bayar :</h3>
                <h3>Rp<?php echo number_format($grandTotal, 0, ',', '.'); ?></h3>
            </div>
            <div id="payment-modal" class="modal-overlay" style="display:none;">
                <div class="modal-content">
                    <h2>Detail Pelanggan</h2>
                    <div class="modal-body">
                        <label for="customer-name">Nama Pelanggan:</label>
                        <input type="text" id="customer-name" name="customer-name" required>
                    </div>
                    <div class="modal-footer">
                        <button id="close-modal-btn" class="btn-cancel">Batal</button>
                        <button id="process-order-btn" class="btn-confirm">Proses Pesanan</button>
                    </div>
                </div>
            </div>
            <button class="confirm-button" type="button" id="confirm-payment-btn">Konfirmasi Pembayaran</button>
        </div>
    </div>
</div>