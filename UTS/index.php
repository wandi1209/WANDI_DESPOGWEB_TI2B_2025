<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Na Wan</title>
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/home.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/orders.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/history.css?v=<?php echo time(); ?>">
</head>
<body>

<?php 
    session_start();
    $data = require __DIR__ . '/data.php';

    if (!is_array($data)) {
        $data = ['kategori' => [], 'menus' => [], 'keranjang' => [], 'orders' => []];
    }

    
    if(!isset($_SESSION['menu'])){
        $_SESSION['kategori'] = $data['kategori'];
        $_SESSION['menu'] = $data['menus'];
        $_SESSION['keranjang'] = $data['keranjang'];
        $_SESSION['order_menu'] = $data['order_menu'];
        $_SESSION['order'] = $data['orders'];
    }
    
    include __DIR__ . '/includes/sidebar.php'; 
?>
<div id="notification-container"></div>

<div id="page">
    <?php
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';
        $file = __DIR__ . '/pages/' . $page . '.php';

        if (file_exists($file)) {
            include $file;
        } else {
            echo "<h1>404 - Halaman tidak ditemukan</h1>";
        }
    ?>
</div>

<script src="assets/js/jquery-3.7.1.js"></script>
<script src="assets/js/main.js?v=<?php echo time(); ?>"></script>
<script src="assets/js/home.js?v=<?php echo time(); ?>"></script>
<script src="assets/js/order.js?v=<?php echo time(); ?>"></script>
<script src="assets/js/history.js?v=<?php echo time(); ?>"></script>
</body>
</html>
