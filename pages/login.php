<?php

require '../includes/login_proccess.php';

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
        <form action="login.php" method="post">
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
                <span class="eye-icon position-absolute" id="togglePassword" onclick="togglePasswordVisibility('pass','eyeOffIcon','eyeIcon')">
                    <i data-feather="eye-off" id="eyeOffIcon"></i>
                    <i data-feather="eye" id="eyeIcon" class="eye"></i>
                </span>
            </div>
            <div class="pass">Lupa Password?</div>
            <input type="submit" name="login" value="Login">
            <div class="signup_link">
                Belum punya akun? <a href="register">Daftar</a>
            </div>
        </form>
    </div>

    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/functions.js"></script>
    <script>
        feather.replace()
    </script>
</body>

</html>