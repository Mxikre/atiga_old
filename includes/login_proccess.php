<?php
session_start();
require '../includes/config.php';
require '../includes/function.php';

if (isset($_SESSION['login'])) {
    header("location: " . base_url());
    exit;
}

$error = '';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['pass'];

    // Validasi input
    if (empty($username) || empty($password)) {
        $error = "Username dan password harus diisi.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $user_id = $row['user_id'];

            if (password_verify($password, $row['password'])) {
                $_SESSION['login'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $user_id;

                if ($row['user_type'] === 'admin') {
                    $_SESSION['user_type'] = 'admin';
                    header("location: ../adminpanel/dashboard.php");
                    exit;
                } elseif ($row['user_type'] === 'customer') {
                    $_SESSION['user_type'] = 'customer';
                    header("location: " . base_url());
                    exit;
                } elseif ($row['user_type'] === 'employee') {
                    $_SESSION['user_type'] = 'employee';
                    header("location: ../employeepanel/dashboard.php");
                    exit;
                }
            } else {
                $error = "Username atau password salah.";
            }
        } else {
            $error = "Username tidak terdaftar.";
        }
    }
}
?>
