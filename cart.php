<?php
require "includes/config.php";
require "includes/session.php";
require "includes/function.php";
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    // Handle ketika 'user_id' tidak diset dalam sesi
    header('Location: pages/login.php');
    exit;
}


$cartItems = getCartItems($conn, $user_id);

if (isset($_POST['del_cart_item'])) {
    $cart_id =  htmlspecialchars($_POST['cart_id']);

    $result = deleteItemCart($conn, $cart_id);

    if ($result) {
        header("Location: cart.php"); // Redirect atau berikan pesan sukses
        exit;
    } else {
        echo "Gagal menghapus item dari keranjang.";
    }
}


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

    <title>Atiga Ditigal Printing</title>
</head>

<body>

    <?php include 'includes/preloader.php'; ?>

    <?php include 'includes/navbar.php';
    ?>

    <div class="cart">
        <div class="container" style="padding-top: 12rem; margin-bottom: 400px;">
            <?php if (count($cartItems) > 0) : ?>
                <div class="row">
                    <div class="col-lg-7">
                        <div class="card w-100">
                            <div class="card-body p-4">
                                <div class="cart-item">
                                    <div class="card-title px-2 pt-3 mb-3" style="border-bottom: 1px solid #ddd;">
                                        <h2 class="fw-bold">Keranjang Anda</h2>
                                    </div>
                                    <table class="table">
                                        <thead>
                                            <tr class="text-muted">
                                                <th>Detail Produk</th>
                                                <th class="text-center">Sub Total</th>
                                                <th class="text-center">Hapus</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $totalPrice = 0;
                                            $itemPrice = 0;

                                            foreach ($cartItems as $cartItem) :
                                                // Hitung total harga per item
                                                $itemPrice = $cartItem['total_price'];
                                                $totalPrice += $itemPrice;
                                            ?>
                                                <tr>
                                                    <td>
                                                        <span>
                                                            <h4><?php echo $cartItem['product_name']; ?></h4>
                                                            <p style="font-size: 12px;"><?php echo $cartItem['type_name']; ?></p>
                                                            <p style="font-size: 12px;">Jumlah: <?php echo $cartItem['quantity']; ?></p>
                                                        </span>
                                                    </td>
                                                    <td class="text-center">Rp. <?php echo number_format($itemPrice, 0, ',', '.'); ?></td>

                                                    <td class="text-center">
                                                        <button type="submit" class="btn" style="color: var(--primary);" data-bs-toggle="modal" data-bs-target="#confirmationModal<?php echo $cartItem['cart_id'] ?>">
                                                            <i data-feather="trash-2"></i>
                                                        </button>

                                                        <div class="modal fade" id="confirmationModal<?php echo $cartItem['cart_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Anda yakin ingin menghapus item ini?
                                                                    </div>
                                                                    <div class="modal-footer d-flex justify-content-center">
                                                                        <form action="cart.php" method="post">
                                                                            <input type="hidden" name="cart_id" value="<?php echo $cartItem['cart_id']; ?>">
                                                                            <button type="submit" name="del_cart_item" class="btn btn-delete">Ya</button>
                                                                        </form>
                                                                        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Batal</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <form method="post" action="checkout.php">
                                                    <input type="hidden" name="itemPrice" value="<?php echo $itemPrice; ?>">
                                                </form>

                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="price-info pt-4 d-flex justify-content-between" style="border-bottom: 1px solid #ddd;">
                                    <p>Total Harga :</p>
                                    <p>Rp. <?php echo number_format($totalPrice, 0, ',', '.'); ?></p>
                                </div>
                                <form method="post" action="checkout.php">
                                    <button type="submit" name="checkout" class="btn btn-primary w-100 mt-2">checkout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <div class="empty-cart vh-100 text-center">
                    <img src="<?= base_url() ?>assets/img/illust/empty-cart.webp" alt="empty-cart" style="opacity: 80%;" class="w-5">
                    <p class="fs-2 text-muted">Keranjang Anda Kosong</p>
                </div>
            <?php endif; ?>
        </div>


    </div>

    <?php include 'includes/footer.php'; ?>

    <!-- End Footer -->


    <!-- JS -->
    <script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery-3.7.1.min.js"></script>
    <script src="<?= base_url() ?>assets/js/functions.js"></script>
    <script>
        var pricingData = <?php echo json_encode($pricingData); ?>
    </script>
    <script>
        feather.replace()
    </script>

</body>

</html>