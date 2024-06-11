<?php
session_start();


if (isset($_SESSION['login'])) {
    $userRole = $_SESSION['user_type'];

    if ($userRole === 'admin') {
        $adminpanel = array('dashboard.php', 'category.php', 'customer.php', 'product.php', 'customer-order.php', 'data-transaksi.php', 'edit-product.php', 'edit-harga.php');

        $current_page = basename($_SERVER['PHP_SELF']);

        if (!in_array($current_page, $adminpanel)) {
            header("location: adminpanel/dashboard.php");
        } 
        if (!in_array($current_page, $employeepanel)) {
            header("location: employeepanel/dashboard.php");
        } 
        elseif ($userRole === 'customer') {
            header("location: " . base_url());
            exit;
        }
    }
}

function check_session()
{
    if (!isset($_SESSION['login'])) {
        header("location: ../pages/login.php");
        exit;
    }
}
