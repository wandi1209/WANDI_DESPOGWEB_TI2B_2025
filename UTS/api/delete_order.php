<?php

session_start();
header('Content-Type: application/json');

$orderId = isset($_POST['order_id']) ? (int)$_POST['order_id'] : null;

if ($orderId === null) {
    echo json_encode(['success' => false, 'message' => 'ID Order tidak valid.']);
    exit;
}

$orderDeleted = false;
if (isset($_SESSION['orders'])) {
    foreach ($_SESSION['orders'] as $key => $order) {
        if (($order['id'] ?? null) == $orderId) {
            unset($_SESSION['orders'][$key]);
            $_SESSION['orders'] = array_values($_SESSION['orders']); 
            $orderDeleted = true;
            break;
        }
    }
}
if (isset($_SESSION['order_menu'])) {
    $_SESSION['order_menu'] = array_values(array_filter($_SESSION['order_menu'], function($detail) use ($orderId) {
        return ($detail['orders_id'] ?? null) != $orderId;
    }));
}


if ($orderDeleted) {
    echo json_encode(['success' => true, 'message' => 'Order berhasil dihapus.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Order tidak ditemukan di sesi.']);
}
exit;