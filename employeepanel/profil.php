<?php
require "../includes/config.php";
require "../includes/session.php";
check_session();
error_reporting(E_ALL);
require "../includes/function.php";

$userId = $_SESSION['id']; // Mendapatkan ID pengguna dari sesi
$userData = getUserData($conn, $userId);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../assets/img/atiga-xicon.png">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <title>Profil Pengguna</title>
</head>

<body>
    <?php include "sidebar.php"; ?>
    <div class="content col-md-10">
        <div class="top-fixed line"></div>
        <div class="container">
            <div class="title text-center mt-5">
                <span>Profil Pengguna</span>
            </div>
            <div class="content-body">
                <div class="profile-header text-center">
                    <img src="<?php echo $userData['profile_picture']; ?>" alt="Foto Profil" class="profile-picture">
                    <h1 class="user-name"><?php echo $userData['name']; ?></h1>
                    <p class="user-email"><?php echo $userData['email']; ?></p>
                </div>
                <div class="profile-details mt-4">
                    <h2>Detail Profil</h2>
                    <p><strong>Nama Lengkap:</strong> <?php echo $userData['full_name']; ?></p>
                    <p><strong>Nomor Telepon:</strong> <?php echo $userData['phone']; ?></p>
                    <p><strong>Alamat:</strong> <?php echo $userData['address']; ?></p>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/functions.js"></script>
</body>

</html>
