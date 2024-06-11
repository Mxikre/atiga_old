<?php
require "includes/config.php";
require "includes/session.php";
require "includes/function.php";

if (isset($_GET['name'])) {
    $productName = htmlspecialchars($_GET['name']);
    $product = getProductByName($conn, $productName);


    // Pastikan produk ditemukan sebelum melanjutkan
    if ($product) {
        $variationAndPricing = fetchProductVariationsAndPricing($conn, $product['product_id']);
        $variations = $variationAndPricing['variations'];
        $pricingData = $variationAndPricing['pricingData'];
    } else {
        // Handle ketika produk tidak ditemukan
        echo "Produk tidak ditemukan.";
        exit();
    }
} else {
    // Handle ketika parameter 'name' tidak ada
    echo "Parameter 'name' tidak ditemukan.";
    exit();
}

if (isset($_POST['pesan'])) {
    // Periksa apakah 'user_id' telah diset dalam sesi
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        // Handle ketika 'user_id' tidak diset dalam sesi
        header('Location: pages/login.php');
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $variation_id = $_POST['variation_id'];
    $length = isset($_POST['length']) ? $_POST['length'] : null;
    $width = isset($_POST['width']) ? $_POST['width'] : null;
    $quantity = $_POST['Jumlah'];
    $keterangan = $_POST['keterangan'];

    $totalHarga = calculateProductPrice($conn, $variation_id, $quantity);


    $new_name = uploadImage($_FILES['customFile'], "assets/img/designUser/");
    if (is_string($new_name)) {
        // File upload success
        if (addToCart($conn, $user_id, $product_id, $variation_id, $length, $width, $quantity, $keterangan, $new_name, $totalHarga)) {
            header('Location: cart.php');
            exit();
        } else {
            echo '<div class="alert alert-danger position-absolute text-center" style="width: 100%; z-index:999;" role="alert"> Gagal menambahkan barang ke keranjang!</div>';
            echo '<meta http-equiv="refresh" content="1; url=product-detail.php?name=' . $product['product_name'] . '" />';
        }
    } else {
        // File upload failed
        echo '<div class="alert alert-danger position-absolute text-center" style="width: 100%; z-index:999;" role="alert">' . $new_name . '</div>';
        echo '<meta http-equiv="refresh" content="1; url=product-detail.php?name=' . $product['product_name'] . '" />';
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
    <!--  -->
    <?php include "includes/preloader.php"; ?>
    <!-- NavBar -->

    <?php include 'includes/navbar.php'; ?>

    <!-- End Navbar -->

    <!-- PRODUCT DETAILS -->
    <section class="product-detail h-100">
        <div class="container" style="margin-bottom: 260px;">
            <div class="row mb-4 pb-4">
                <div class="col-lg-6 pe-4">
                    <div class="product-image">
                        <img src="<?= base_url() ?>assets/img/product-images/<?php echo $product['image'] ?>" alt="<?php echo $product['product_name'] ?>" class="w-100">
                    </div>
                </div>
                <div class="col-lg-6 ps-5">
                    <div class="product-det border-bottom">
                        <h1 class="fw-bold" data-product-name="<?php echo $product['product_name'] ?>"><?php echo $product['product_name'] ?></h1>
                        <p><?php echo $product['description'] ?></p>
                    </div>
                    <form method="post" action="product-detail.php?name=<?php echo $product['product_name']; ?>" enctype="multipart/form-data">
                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">

                        <div class="varian pt-4">
                            <label>Pilih Jenis atau Bahan :</label>
                            <select id="variation" name="variation_id" class="form-select">
                                <?php
                                foreach ($variations as $variationId => $variationName) {
                                    echo '<option value="' . $variationId . '" data-price="' . $variationName['price'] . '">' . $variationName['type_name'] . '</option>';
                                }
                                ?>
                            </select>

                        </div>
                        <div class="price py-4 border-bottom" id="pricing-container">
                            <h3>Harga</h3>
                        </div>

                        <div class="atribut py-4">
                            <div class="mb-3">
                                <?php
                                if ($product['product_name'] === 'Banner Horizontal') { ?>
                                    <div class="row w-55">
                                        <div class="col-sm-6">
                                            <label for="length" class="form-label">Panjang : </label>
                                            <div class="d-flex me-2">
                                                <input type="number" name="length" id="length" class="form-control" placeholder="ex: 1.5" style="width: 100px;">
                                                <small class="bg-secondary text-white py-2 px-2">meter</small>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="length" class="form-label">Lebar : </label>
                                            <div class="d-flex">
                                                <input type="number" name="width" id="width" class="form-control" placeholder="ex: 3" style="width: 100px;">
                                                <small class="bg-secondary text-white py-2 px-2">meter</small>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="mb-3">
                                <label for="Jumlah" class="form-label">Jumlah :</label>
                                <div class="d-flex">
                                    <input type="number" name="Jumlah" id="Jumlah" class="form-control" value="1" style="width: 100px;">
                                    <span class="text-danger ms-2 py-2">*min order : 1</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="keterangan" class="form-label">keterangan :</label>
                                <textarea class="form-control" name="keterangan" id="keterangan" rows="3"></textarea>
                            </div>
                        </div>


                        <div class="pb-5">
                            <div class="d-flex justify-content-start">
                                <div class="btn btn-rounded btn-warning">
                                    <label class="form-label text-white m-1" for="customFile"><i data-feather="upload"></i> Masukkan Design Anda</label>
                                    <input type="file" class="form-control" name="customFile" id="customFile" placeholder="Pilih" hidden onchange="displayFileName()">
                                </div>
                                <div class="text-center py-2 px-2">
                                    <small id="fileNameDisplay" class="text-muted mb-0"></small>
                                </div>
                            </div>
                            <div class="fileInfo d-flex flex-column mt-2">
                                <small class="text-danger">*File harus dalam format JPG, PNG, JPEG atau PDF</small>
                                <small class="text-danger">*max. ukuran File adalah 100MB</small>
                            </div>
                        </div>

                        <div class=" py-3 d-flex justify-content-end" style="border-top: 1px solid #ddd;">
                            <button type="submit" name="pesan" class="btn cart-btn"><i data-feather="shopping-cart"></i> Buat Pesanan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- END PRODUCT DETAILS -->

    <!-- Footer -->

    <?php include 'includes/footer.php'; ?>

    <!-- End Footer -->


    <!-- JS -->
    <script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/js/pricing.js"></script>
    <script src="<?= base_url() ?>assets/js/functions.js"></script>
    <script>
        var pricingData = <?php echo json_encode($pricingData); ?>
    </script>
    <script>
        feather.replace()
    </script>
    <script>
        function displayFileName() {
            var input = document.getElementById('customFile');
            var fileNameDisplay = document.getElementById('fileNameDisplay');

            if (input.files.length > 0) {
                var fileName = input.files[0].name;
                fileNameDisplay.innerHTML = 'Design anda : ' + fileName + ' <i data-feather="check-circle" style="color: green;"></i>';
                feather.replace(); // Refresh Feather icons after updating content
            } else {
                fileNameDisplay.innerHTML = ''; // Clear the display if no file is selected
            }
        }
    </script>

</body>

</html>