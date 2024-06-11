<?php
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

        $stmt = $conn->prepare("INSERT INTO customers (user_id, name, email, no_telp, address, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ississ", $user_id, $name, $email, $telp, $alamat, $hashed_password);
        $stmt->execute();
        $stmt->close();

        // ketika registrasi berhasil, redirect ke halaman login
        header('location: login.php');
        exit();
    }
}
