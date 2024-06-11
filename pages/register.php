<?php
require '../includes/config.php';
include 'register_proccess.php';
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
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <title>Atiga Ditigal Printing</title>
</head>

<body>
    <div class="form-container">
        <div class="center">
            <h1>Daftar</h1>
            <form action="" method="POST">
                <?php
                if (isset($errors) && !empty($errors)) {
                    foreach ($errors as $error) {
                        echo '<div class="error-container">';
                        echo '<div class="error-msg">' . $error . '</div>';
                        echo '</div>';
                    }
                }
                ?>
                <div class="txt_field">
                    <input type="text" name="name" id="name" required>
                    <span></span>
                    <label for="name">Username</label>
                </div>
                <div class="txt_field">
                    <input type="email" name="email" id="email" required>
                    <span></span>
                    <label for="email">Email</label>
                </div>
                <div class="txt_field">
                    <input type="tel" name="no_telp" id="no_telp" required>
                    <span></span>
                    <label for="no_telp">No Telpon</label>
                </div>
                <div class="txt_field">
                    <input type="text" name="alamat" id="alamat" required>
                    <span></span>
                    <label for="alamat">Alamat</label>
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
                <div class="txt_field position-relative">
                    <input type="password" name="cpass" id="cpass" required>
                    <span></span>
                    <label for="cpass">Konfirmasi Password</label>
                    <span class="eye-icon position-absolute" id="togglePassword2" onclick="togglePasswordVisibility('cpass','eyeOffIcon2','eyeIcon2')">
                        <i data-feather="eye-off" id="eyeOffIcon2"></i>
                        <i data-feather="eye" id="eyeIcon2" class="eye"></i>
                    </span>
                </div>

                <input type="submit" name="submit_registration" value="Daftar">
                <div class="signup_link">
                    Sudah punya akun? <a href="login.php">Login</a>
                </div>

            </form>
        </div>
    </div>

    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/functions.js"></script>
    <script>
        feather.replace()
    </script>
</body>

</html>