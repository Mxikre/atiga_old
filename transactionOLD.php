<?php
require "includes/config.php";
require "includes/session.php";
require "includes/function.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: pages/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil riwayat pesanan
$orderHistory = getOrderHistoryDetails($conn, $user_id);

// Ambil pesanan yang sedang diproses
$processingOrders = getProcessingOrdersDetails($conn, $user_id);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/img/atiga-xicon.png">
    <!-- CSS -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Feather Icon -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <title>Transaksi</title>

    <style>
        .processing {
            background-color: var(--secondary);
            padding: 2px 5px;
            color: white;
            border-radius: 20px;
        }
    </style>
</head>

<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="transaction-data vh-100">
        <div class="container pb-5" style="padding-top: 12rem;">
            <?php if (count($processingOrders) > 0) : ?>
                <h2 class="fw-bold mb-5">Transaksi</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Detail Produk</th>
                            <th>Total Harga</th>
                            <th>Waktu</th>
                            <th class="text-center">Status</th>
                            <!-- Tambahkan kolom lain sesuai kebutuhan -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($processingOrders as $order) :
                            $itemsPrice = $order['quantity'] * $order['price'];
                        ?>

                            <tr>
                                <td>
                                    <span>
                                        <h4><?php echo $order['product_name']; ?></h4>
                                        <p style="font-size: 12px;"><?php echo $order['variation_name']; ?></p>
                                        <p style="font-size: 12px;"><?php echo $order['quantity']; ?> X <?php echo $itemsPrice; ?></p>
                                    </span>
                                </td>
                                <td><?php echo $order['total_amount']; ?></td>
                                <td><?php echo $order['order_date'] ?></td>
                                <td class="pt-5 text-center">
                                    <?php if ($order['status_id'] === 1) : ?>
                                        <span class="processing">
                                        <?php endif; ?>
                                        <?php echo $order['status_name']; ?>
                                        </span>
                                </td>
                                <!-- Tambahkan kolom lain sesuai kebutuhan -->
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            <?php else : ?>
                <div class="no-transaction vh-100 mt-5 pt-5 text-center">
                    <p class="fs-2 text-muted">Tidak ada Transaksi yang dilakukan.</p>
                    <img src="assets/img/no.png" alt="nothing.png">
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <!-- JS -->
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="assets/js/functions.js"></script>
    <script>
        feather.replace()
    </script>

</body>

</html>