<?php
session_start();
header('Content-Type: application/json');

$data = require __DIR__ . '/../data.php'; 
$menu = $data['menus'] ?? []; 

$menuMap = [];
foreach ($menu as $m) {
    if (isset($m['id'])) {
        $menuMap[$m['id']] = $m;
    }
}
$keranjang = $_SESSION['keranjang'] ?? [];
$currentOrders = $_SESSION['orders'] ?? []; 


$namaPelanggan = $_POST['nama_pelanggan'] ?? 'Anonim';
$orderType = $_POST['order_type'] ?? 'dine-in';
$paymentMethod = $_POST['payment_method'] ?? 'cash';

if (empty($keranjang)) {
    echo json_encode(['success' => false, 'message' => 'Keranjang kosong, tidak ada yang bisa diorder.']);
    exit;
}

$nextOrderId = 1000;
if (!empty($currentOrders)) {
    $lastOrderId = 0;
    foreach ($currentOrders as $o) {
        if (($o['id'] ?? 0) > $lastOrderId) {
            $lastOrderId = $o['id'];
        }
    }
    $newOrderId = $lastOrderId + 1;
} else {
    $newOrderId = $nextOrderId;
}
$totalTransaksi = 0;

$currentOrderMenu = $_SESSION['order_menu'] ?? [];
$newOrderDetails = [];

foreach ($keranjang as $item) {
    $itemId = $item['menus_id'] ?? null;
    $qty = $item['qty'] ?? 0;
    $menuItemDetail = $menuMap[$itemId] ?? null;
    
    if ($menuItemDetail && $qty > 0) {
        $hargaItem = $menuItemDetail['harga'];
        $subtotal = $hargaItem * $qty;
        $totalTransaksi += $subtotal;
        
        $newOrderDetails[] = [
            'orders_id' => $newOrderId,
            'menus_id' => $itemId,
            'qty' => $qty,
            'harga' => $subtotal,
        ];
    }
}


$newOrderHeader = [
    'id' => $newOrderId,
    'nama_pelanggan' => $namaPelanggan,
    'total_bayar' => $totalTransaksi,
    'order_type' => $orderType,
    'payment_method' => $paymentMethod,
    'created_at' => date('Y-m-d H:i:s'),
];


$_SESSION['order_menu'] = array_merge($currentOrderMenu, $newOrderDetails);
$_SESSION['orders'] = array_merge($currentOrders, [$newOrderHeader]);

$_SESSION['keranjang'] = [];


echo json_encode([
    'success' => true,
    'new_order_id' => $newOrderId,
    'total' => number_format($totalTransaksi, 0, '.', ','),
    'message' => 'Pesanan berhasil dikonfirmasi.'
]);
exit;

?>