<?php
require "../includes/config.php";
require "../includes/session.php";
check_session();
require "../includes/function.php";
$customers = getData($conn, 'customers');
$totalCustomer = count($customers);
$orders = getData($conn, "orders");
$totalOrder = count($orders);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../assets/img/atiga-xicon.png">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <title>Dashboard</title>
</head>

<body>
    <?php include "sidebar.php" ?>
    <div class="content col-md-10">
        <div class="top-fixed line"></div>
        <div class="container">
            <div class="title text-center mt-5">
                <span>Dashboard</span>
            </div>
            <div class="content-body">
                <div class="selection d-flex justify-content-center">
                    <div class="row mt-5 pt-4">
                        <div class="dash-item col-md-4 d-flex justify-content-end">
                            <div class="card" id="card1">
                                <a href="customer.php" class="card-link">
                                    <span class="d-flex"><i data-feather="users"></i>
                                        <h1 class="ms-2"><?php echo $totalCustomer ?></h1>
                                    </span>
                                    <span class="card-text">Pengguna Terdaftar</span>
                                </a>
                            </div>
                        </div>
                        <div class="dash-item col-md-4 d-flex justify-content-center">
                            <div class="card" id="card2">
                                <a href="#" class="card-link">
                                    <span><i data-feather="archive"></i></span>
                                    <span class="card-text">Transaksi</span>
                                </a>
                            </div>
                        </div>
                        <div class="dash-item col-md-4 d-flex justify-content-start">
                            <div class="card" id="card3">
                                <a href="customer-order.php" class="card-link" style="color: #333;">
                                    <span class="d-flex"><i data-feather="shopping-cart" style="color: #333;"></i>
                                        <h1 class="ms-2"><?php echo $totalOrder ?></h1>
                                    </span>
                                    <span class="card-text">Pesanan</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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