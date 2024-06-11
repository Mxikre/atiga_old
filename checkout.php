<?php
//checkout.php
require "includes/config.php";
require "includes/session.php";
require "includes/function.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: pages/login.php");
    exit();
}


if (isset($_POST['checkout'])) {
    $user_id = $_SESSION['user_id'];
    $cartItems = getCartItems($conn, $user_id);


    $order_id = processOrder($conn, $user_id, $cartItems);

    // Clear keranjang belanja setelah checkout
    clearCart($conn, $user_id);

    // Redirect ke halaman terima kasih atau halaman konfirmasi pesanan
    header("Location: transaction.php");
    exit();
}
