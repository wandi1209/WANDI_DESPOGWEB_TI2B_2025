<?php
session_start();
header('Content-Type: application/json');

$menu = $_SESSION['menu'] ?? [];
$kategoriId = isset($_POST['kategori_id']) ? (int)$_POST['kategori_id'] : null;

if ($kategoriId === null) {
    echo json_encode(['success' => false, 'html' => 'ID kategori tidak ditemukan.']);
    exit;
}

ob_start();
$menuFound = false;

foreach ($menu as $m): 
    if(($m['kategori_id'] ?? null) == $kategoriId){ 
        $menuFound = true;
?>
        <div class="card-item">
            <img width="150px" height="150px" class="img-menu" src="<?php echo $m['image_url']; ?>" alt="<?php echo $m['name']; ?>">
            <h3 class="text-menu"><?php echo $m['name']; ?></h3>
            <p class="price-menu">Rp<?php echo number_format($m['harga'], 0, ',', '.'); ?></p>
            <button class="add-to-cart-btn" type="button" data-menu-id="<?php echo $m['id']; ?>">
                <img src="assets/images/icons/add.svg" alt="">
                <span>Tambah</span>
            </button>
        </div>
<?php 
    }
endforeach; 

if (!$menuFound) {
    echo '<p style="padding:20px;">Menu untuk kategori ini belum tersedia.</p>';
}

$htmlContent = ob_get_clean();

echo json_encode([
    'success' => true,
    'html' => $htmlContent
]);
exit;