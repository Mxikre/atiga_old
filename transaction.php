<?php
require "includes/config.php";
require "includes/session.php";
require "includes/function.php";
include "includes/tgl_indo.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: pages/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];



// Ambil pesanan yang sedang diproses
$Orders = getProcessingOrdersDetails($conn, $user_id);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="<?= base_url() ?>assets/img/atiga-xicon.png">
    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">

    <!-- Feather Icon -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <title>Transaksi</title>

</head>

<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="transaction-data h-100">
        <div class="container">
            <?php if (count($Orders) > 0) :
                // Create an associative array to group orders by order_id
                $groupedOrders = [];
                foreach ($Orders as $order) {
                    $order_id = $order['order_id'];
                    if (!isset($groupedOrders[$order_id])) {
                        $groupedOrders[$order_id] = [];
                    }
                    $groupedOrders[$order_id][] = $order;
                }
            ?>
                <h1 class="fw-bold mb-5">Transaksi</h1>
                <?php foreach ($groupedOrders as $order_id => $groupedOrder) :
                    $itemsPrice = $groupedOrder[0]['quantity'] * $groupedOrder[0]['price'];
                ?>
                    <div class="card mb-4 px-3 py-3">
                        <?php $firstOrder = $groupedOrder[0]; ?>
                        <div class="card-header bg-white d-flex justify-content-between">
                            <div class="order-date d-flex">
                                <i data-feather="shopping-bag" class="mt-2" style="color: var(--primary);"></i>
                                <span class="ms-3">
                                    <p>Dipesan pada</p>
                                    <h5><?php echo tgl_indo($firstOrder['order_date']); ?>
                                    </h5>
                                </span>
                            </div>
                            <?php if ($firstOrder['status_id'] === 1) : ?>
                                <div class="status" style="padding-top: 20px;">
                                    <span class="processing">
                                        <?php echo $firstOrder['status_name']; ?>
                                    </span>
                                </div>
                            <?php elseif ($firstOrder['status_id'] === 2 || $firstOrder['status_id'] === 3) : ?>
                                <div class="status" style="padding-top: 20px;">
                                    <span class="inOrder">
                                        <?php echo $firstOrder['status_name']; ?>
                                    </span>
                                </div>
                            <?php elseif ($firstOrder['status_id'] === 4) : ?>
                                <div class="status" style="padding-top: 20px;">
                                    <span class="done">
                                        <?php echo $firstOrder['status_name']; ?>
                                    </span>
                                </div>
                            <?php endif; ?>

                        </div>
                        <div class="card-body">
                            <?php foreach ($groupedOrder as $order) :
                                $itemsPrice = $order['total'];
                            ?>

                                <h2><?php echo $order['product_name']; ?></h2>
                                <p style="font-size: 12px;"><?php echo $order['variation_name']; ?></p>
                                <p style="font-size: 12px;"><?php echo $order['quantity']; ?> X Rp. <?php echo number_format($itemsPrice, 0, ',', '.'); ?></p>
                            <?php endforeach; ?>
                        </div>
                        <div class="card-footer bg-white text-end pt-3">
                            <h4>Total Belanja : Rp. <?php echo number_format($firstOrder['total_amount'], 0, ',', '.'); ?></h4>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php else : ?>
                <div class="no-transaction vh-100 mt-5 pt-5 text-center">
                    <p class="fs-2 text-muted">Tidak ada Transaksi yang dilakukan.</p>
                    <img src="<?= base_url() ?>assets/img/illust/no.webp" alt="nothing.png" class="w-35">
                </div>
            <?php endif; ?>
        </div>
    </div>


    <?php include 'includes/footer.php'; ?>

    <!-- JS -->
    <script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery-3.7.1.min.js"></script>
    <script src="<?= base_url() ?>assets/js/functions.js"></script>
    <script>
        feather.replace()
    </script>

</body>

</html>