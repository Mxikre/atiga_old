<?php
require '../assets/config.php';

$errors = [];

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    $password = $_POST['pass'];
    $confirm_password = $_POST['cpass'];

    $user_type = 'customer';

    // validasi
    if (empty($name) || empty($email) || empty($telp) || empty($alamat) || empty($password) || empty($confirm_password)) {
        $errors[] = 'Semua kolom harus diisi.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Format email tidak valid.';
    }

    if ($password !== $confirm_password) {
        $errors[] = 'Konfirmasi password tidak sesuai.';
    }

    // Password strength validation
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
        $errors[] = 'Password harus terdiri dari setidaknya 8 karakter, termasuk huruf besar, huruf kecil, angka, dan karakter khusus.';
    }

    // Check email
    $stmt = $conn->prepare("SELECT * FROM customers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $errors[] = 'Email sudah terdaftar.';
    }

    // jika tidak error maka 
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, password, user_type) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $hashed_password, $user_type);
        $stmt->execute();
        $user_id = $stmt->insert_id;
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO customers (user_id, name, email, no_telp, alamat, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ississ", $user_id, $name, $email, $telp, $alamat, $hashed_password);
        $stmt->execute();
        $stmt->close();

        // ketika registrasi berhasil, redirect ke halaman login
        header('location: login.php');
        exit();
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
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <title>Atiga Ditigal Printing</title>
</head>

<body>
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
            <div class="txt_field">
                <input type="password" name="pass" id="pass" required>
                <span></span>
                <label for="pass">Password</label>
                <i id="togglePassword" onclick="togglePasswordVisibility()">
                    <i data-feather="eye"></i>
                    <i data-feather="eye-off" style="display: none;"></i>
                </i>
            </div>
            <div class="txt_field">
                <input type="password" name="cpass" id="cpass" required>
                <span></span>
                <label for="cpass">Konfirmasi Password</label>
            </div>
            <input type="submit" name="register" value="Daftar">
            <div class="signup_link">
                Sudah punya akun? <a href="login.php">Login</a>
            </div>
        </form>
    </div>

    <script src="../assets/js/script.js"></script>
    <script src="../assets/js/functions.js"></script>
    <script>
        feather.replace()
    </script>
</body>

</html>