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

if ($menuId === null || !isset($menuMap[$menuId])) {
    echo json_encode(['success' => false, 'message' => 'ID menu tidak valid atau tidak ditemukan.']);
    exit;
}

if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}
$keranjang = &$_SESSION['keranjang']; 

$itemFound = false;
$newQty = 1;

foreach ($keranjang as $key => $item) {
    if (($item['menus_id'] ?? null) == $menuId) { 
        $keranjang[$key]['qty']++; 
        $newQty = $keranjang[$key]['qty'];
        $itemFound = true;
        break;
    }
}

$new_item_html = null;
if (!$itemFound) {
    $keranjang[] = [
        'menus_id' => $menuId, 
        'qty' => 1
    ];
    $newQty = 1;
    
    $menuItemDetail = $menuMap[$menuId];
    
    ob_start();
    ?>
    <div class="cart-list">
        <img class="cart-img" src="<?php echo $menuItemDetail['image_url'] ?? ''; ?>" alt="Image">
        <div>
            <h1><?php echo $menuItemDetail['name'] ?? 'Menu Tidak Dikenal'; ?></h1>
            <p class="cart-price">Rp<?php echo number_format($menuItemDetail['harga'] ?? 0, 0, ',', '.'); ?></p>
        </div>
        <div class="handler-qty" data-menu-id="<?php echo $menuId; ?>"> 
            <button type="button" class="qty-btn" data-action="decrement">-</button>
            <span class="qty-display" id="qty-<?php echo $menuId; ?>">1</span>
            <button type="button" class="qty-btn" data-action="increment">+</button>
        </div>
    </div>
    <?php
    $new_item_html = ob_get_clean(); 
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
    'item_new_qty' => $newQty,
    'new_grand_total' => number_format($grandTotal, 0, '.', ','),
    'new_item_html' => $new_item_html,
    'message' => 'Item berhasil ditambahkan.'
]);