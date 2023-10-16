<?php
session_start();
require '../assets/config.php';

if (isset($_SESSION['login'])) {
    header("location: ../index.php");
    exit;
}

$error = '';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['pass'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' ");
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            if ($row['user_type'] === 'admin') {

                $_SESSION['login'] = true;

                header("location: ../adminpanel/index.php");
                exit;
            } elseif ($row['user_type'] === 'customer') {

                $_SESSION['login'] = true;

                header("location: ../index.php");
                exit;
            }
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Username tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../assets/img/atiga-xicon.png">
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/login.css">

    <!-- Feather Icon -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>


    <title>Atiga Ditigal Printing</title>
</head>

<body>
    <div class="center">
        <h1>Login</h1>
        <form action="" method="post">
            <?php
            if (!empty($error)) {
                echo '<div class="error-container">';
                echo '<div class="error-msg">' . $error . '</div>';
                echo '</div>';
            }
            ?>

            <div class="txt_field">
                <input type="text" name="username" id="username" required>
                <span></span>
                <label for="username">Username</label>
            </div>
            <div class="txt_field position-relative">
                <input type="password" name="pass" id="pass" required>
                <span></span>
                <label for="pass">Password</label>
                <span class="eye-icon position-absolute" id="togglePassword" onclick="togglePasswordVisibility()">
                    <i data-feather="eye-off" id="eyeOffIcon"></i>
                    <i data-feather="eye" id="eyeIcon" class="eye"></i>
                </span>
            </div>
            <div class="pass">Lupa Password?</div>
            <input type="submit" name="login" value="Login">
            <div class="signup_link">
                Belum punya akun? <a href="register.php">Daftar</a>
            </div>
        </form>
    </div>

    <script src="../assets/js/functions.js"></script>
    <script>
        feather.replace()
    </script>
</body>

</html>