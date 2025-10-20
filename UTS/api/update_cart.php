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

$menuId = isset($_POST['menu_id']) ? (int)$_POST['menu_id'] : null;
$action = isset($_POST['action']) ? $_POST['action'] : null;

if ($menuId === null || !in_array($action, ['increment', 'decrement'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Input tidak valid.']);
    exit;
}

if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}
$keranjang = &$_SESSION['keranjang']; 

$newQty = 0; 
$itemFound = false;

foreach ($keranjang as $i => $item) {
    
    if (($item['menus_id'] ?? null) == $menuId) {
        $itemFound = true;

        if ($action == 'increment') {
            $keranjang[$i]['qty']++;
            $newQty = $keranjang[$i]['qty'];
            
        } elseif ($action == 'decrement') {
            if ($keranjang[$i]['qty'] > 1) {
                $keranjang[$i]['qty']--;
                $newQty = $keranjang[$i]['qty'];
            } else {
                unset($keranjang[$i]);
                $newQty = 0;
            }
        }
        break;
    }
}

if ($newQty === 0 && $itemFound) {
    $_SESSION['keranjang'] = array_values($keranjang);
}

$grandTotal = 0;
foreach ($_SESSION['keranjang'] as $item) {
    $itemId = $item['menus_id'] ?? null; 
    $qty = $item['qty'] ?? 0;
    
    if ($itemId && isset($menuMap[$itemId]['harga'])) {
        $harga = $menuMap[$itemId]['harga'];
        $grandTotal += $harga * $qty;
    }
}

echo json_encode([
    'success' => true,
    'menu_id' => $menuId,
    'new_qty' => $newQty,
    'new_grand_total' => number_format($grandTotal, 0, '.', ','),
    'message' => 'Kuantitas berhasil diperbarui.'
]);