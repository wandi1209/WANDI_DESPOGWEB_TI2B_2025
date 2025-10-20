<?php
    date_default_timezone_set('Asia/Jakarta');

    $fmt = new IntlDateFormatter(
        'id_ID',
        IntlDateFormatter::LONG,
        IntlDateFormatter::SHORT
    );

    $kategori = $_SESSION['kategori'] ?? [];
    $menu = $_SESSION['menu'] ?? [];

    $defaultKategoriName = 'Nasi';
    if (!empty($kategori) && isset($kategori[0]['name'])) {
        $defaultKategoriName = $kategori[0]['name'];
    }

    $selectedKategori = $_GET['kategori'] ?? $defaultKategoriName;
    
    $selectedKategoriId = null;
    foreach ($kategori as $kat) {
        if (strtolower($kat['name']) === strtolower($selectedKategori)) {
            $selectedKategoriId = $kat['id'];
            break;
        }
    }
?>

<div class="content">
    <img src="assets/images/icons/logo.svg" alt="Na Wan">
    <h3 class="date-now">
        <?php echo $fmt->format(new DateTime()); ?>
    </h3>
    
    <div class="kategori">
        <?php foreach ($kategori as $kat): ?>
            <a href="#" 
               data-kategori-id="<?php echo $kat['id']; ?>" 
               class="kategori-item kategori-link <?php echo (strtolower($selectedKategori) === strtolower($kat['name'])) ? 'active' : ''; ?>">
                <?php echo $kat['name']; ?>
            </a>
        <?php endforeach; ?>
    </div>
    
    <div class="divider red"></div>
    
    <div class="card-menu">
        <div id="menu-list-container" class="card-list">
            <?php 
                $menuFound = false;
                foreach ($menu as $m): 
                    if(($m['kategori_id'] ?? null) == $selectedKategoriId){ 
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
            <?php } endforeach; 
                if (!$menuFound && $selectedKategoriId !== null) {
                    echo '<p style="padding:20px;">Menu untuk kategori ini belum tersedia.</p>';
                }
            ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/orders.php'; ?>