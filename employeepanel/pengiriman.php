<?php
require "../includes/config.php";
require "../includes/session.php";
check_session();
error_reporting(E_ALL);
require "../includes/function.php";

// Ambil data pengiriman
$queryDelivery = mysqli_query($conn, "SELECT * FROM deliverys");
$deliveryData = [];
while ($data = mysqli_fetch_assoc($queryDelivery)) {
    $deliveryData[] = $data;
}

$jumlahDelivery = count($deliveryData);

?>

<!DOCTYPE html>
<html lang="id">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../assets/img/atiga-xicon.png">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../assets/css/buttons.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <title>Data Pengiriman</title>
    <!-- Tambahkan CSS Anda di sini jika diperlukan -->
</head>

<body>
    <?php require "sidebar.php"; ?>
    <div class="content col-md-10">
        <div class="top-fixed line"></div>
        <div class="container">
            <div class="title text-center mt-5">
                <span>Data Pengiriman</span>
            </div>
            <div class="content-body mt-5 px-5 pb-3">
                <a href="javascript:history.back()" class="btn btn-primary mb-3">Kembali</a>
                <?php
                // Cek apakah ada data pengiriman
                if (!empty($deliveryData)) {
                    // Tampilkan data pengiriman menggunakan foreach loop
                    foreach ($deliveryData as $delivery) {
                        echo "<p>Delivery ID: " . $delivery['delivery_id'] . "</p>";
                        echo "<p>Delivery Date: " . $delivery['delivery_date'] . "</p>";
                        echo "<p>Customer Name: " . $delivery['customer_name'] . "</p>";
                        echo "<p>Status: " . $delivery['status'] . "</p>";
                        echo "<hr>";
                    }
                } else {
                    echo "<p>Tidak ada data pengiriman.</p>";
                }
                ?>
            </div>
        </div>
    </div>
    <!-- Tambahkan script JS Anda di sini jika diperlukan -->
</body>

</html>
