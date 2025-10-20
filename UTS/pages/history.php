<?php
    $orders = $_SESSION['orders'] ?? [];
    $orderDetails = $_SESSION['order_menu'] ?? [];
    $menuMap = $_SESSION['menu'] ?? []; 
?>



<div class="riwayat-pemesanan">
    <h1>Riwayat Pemesanan</h1>

    <?php if (empty($orders)): ?>
        <p>Belum ada riwayat pemesanan yang tersimpan.</p>
    <?php else: ?>

        <?php 
        $orders = array_reverse($orders); 
        ?>

        <?php foreach ($orders as $order): 
            $orderId = $order['id'];
        ?>
            <div class="order-card" id="order-<?php echo $orderId; ?>">
                <h2>Pesanan #<?php echo $order['id']; ?></h2>
                
                <button class="delete-order-btn" 
                        data-order-id="<?php echo $orderId; ?>" 
                        type="button">
                    Hapus Order
                </button>
                
                <p><strong>Pelanggan:</strong> <?php echo htmlspecialchars($order['nama_pelanggan']); ?></p>
                
                <p><strong>Tipe Order:</strong> <?php echo htmlspecialchars(ucwords($order['order_type'] ?? 'Dine In')); ?></p>
                
                <p><strong>Tanggal:</strong> <?php echo date('d F Y, H:i', strtotime($order['created_at'])); ?></p>
                <p><strong>Total Bayar:</strong> Rp<?php echo number_format($order['total_bayar'], 0, ',', '.'); ?></p>
                <p><strong>Metode Pembayaran:</strong> <?php echo htmlspecialchars(strtoupper($order['payment_method'])); ?></p>
                
                
                <h3>Detail Item</h3>
                <table class="order-detail-table">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th>Qty</th>
                            <th>Harga Satuan</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $currentOrderDetails = array_filter($orderDetails, function($detail) use ($orderId) {
                            return ($detail['orders_id'] ?? null) == $orderId;
                        });
                        
                        foreach ($currentOrderDetails as $detail):
                            $menuItem = $menuMap[$detail['menus_id']] ?? null;
                            $hargaSatuan = $menuItem['harga'] ?? 0;
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($menuItem['name'] ?? 'Menu Tidak Dikenal'); ?></td>
                                <td><?php echo $detail['qty']; ?></td>
                                <td>Rp<?php echo number_format($hargaSatuan, 0, ',', '.'); ?></td>
                                <td>Rp<?php echo number_format($detail['harga'], 0, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <hr>
        <?php endforeach; ?>

    <?php endif; ?>
</div>