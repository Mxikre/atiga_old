<?php
session_start();

if (!isset($_SESSION['login']) && basename($_SERVER['PHP_SELF']) != 'login.php') {
    header("location: pages/login.php");
    exit;
}
