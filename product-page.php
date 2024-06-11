<?php
require "includes/config.php";
require "includes/session.php";
require "includes/function.php";

// get produk by keyword
if (isset($_GET['keyword'])) {
    $queryProduk = mysqli_query($conn, "SELECT a.*, b.category_name AS category_name FROM products a JOIN categories b ON a.category_id = b.category_id WHERE product_name LIKE '%$_GET[keyword]%'");
}

// get produk by kategori
else if (isset($_GET['kategori'])) {
    $queryGetkategoriId = mysqli_query($conn, "SELECT category_id FROM categories WHERE category_name='$_GET[kategori]'");
    $kategoriId = mysqli_fetch_array($queryGetkategoriId);

    $queryProduk = mysqli_query($conn, "SELECT a.*, b.category_name AS category_name FROM products a JOIN categories b ON a.category_id = b.category_id WHERE a.category_id='$kategoriId[category_id]'");
}

// get produk default
else {
    $queryProduk = mysqli_query($conn, "SELECT a.*, b.category_name AS category_name FROM products a JOIN categories b ON a.category_id = b.category_id");
}

$countData = mysqli_num_rows($queryProduk);
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

    <?php include "includes/preloader.php"; ?>
    <!-- NavBar -->

    <?php include 'includes/navbar.php'; ?>

    <!-- End Navbar -->

    <!-- PRODUCT DETAILS -->
    <section class="product h-100">
        <div class="container mb-5">
            <div class="row">
                <?php
                if ($countData < 1) {
                ?>
                    <span class="vh-100 d-flex align-items-center justify-content-center">
                        <img src="<?= base_url() ?>assets/img/illust/empty-result.webp" alt="empty-result.png" class="w-30">
                        <h3 class="text-muted">Produk yang anda cari tidak ada</h3>
                    </span>
                <?php
                }
                ?>
                <?php
                $previousCategory = null;

                while ($data = mysqli_fetch_array($queryProduk)) {
                    if ($data['category_name'] !== $previousCategory) { ?>

                        <div class="title mt-5">
                            <h1><?php echo $data['category_name']; ?></h1>
                        </div>

                    <?php $previousCategory = $data['category_name'];
                    } ?>
                    <div class="col-lg-4 col-md-12 mb-4">
                        <div class="card text-center">
                            <div class="card-image">
                                <img src="<?= base_url() ?>assets/img/product-images/<?php echo $data['image']; ?>" class="w-100" />
                            </div>
                            <div class="card-body">
                                <a href="<?= base_url() ?>product-detail.php?name=<?php echo $data['product_name']; ?>">
                                    <h3 class="card-title mb-3"><?php echo $data['product_name']; ?></h3>
                                </a>
                                <a href="<?= base_url() ?>product-page.php?kategori=<?php echo $data['category_name']; ?>">
                                    <p><?php echo $data['category_name']; ?></p>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- END PRODUCT DETAILS -->

    <!-- Footer -->

    <?php include 'includes/footer.php'; ?>

    <!-- End Footer -->


    <!-- JS -->
    <script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery-3.7.1.min.js"></script>
    <script src="<?= base_url() ?>assets/js/functions.js"></script>
    <script>
        feather.replace()
    </script>

</body>

</html>