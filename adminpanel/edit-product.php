    <?php
    require "../includes/config.php";
    require "../includes/session.php";
    check_session();
    error_reporting(E_ALL);
    require "../includes/function.php";

    $querykategori = getData($conn, "categories");


    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];

        $variationAndPricing = fetchProductVariationsAndPricing($conn, $product_id);
        $variations = $variationAndPricing['variations'];
        $pricingData = $variationAndPricing['pricingData'];

        // Retrieve product details for editing
        $queryEditProduct = mysqli_query($conn, "SELECT a.*, b.category_name AS category_name FROM products a JOIN categories b ON a.category_id = b.category_id WHERE a.product_id = $product_id");

        $data = mysqli_fetch_assoc($queryEditProduct);
    } else {
        // Redirect to the product list page if product_id is not set
        header("Location: product.php");
        exit();
    }

    if (isset($_POST['save_edit'])) {
        $id = htmlspecialchars($_POST['product_id']);
        $nama = htmlspecialchars($_POST["new_nama"]);
        $kategori = htmlspecialchars($_POST['new_kategori']);
        $detail = htmlspecialchars($_POST["new_desc"]);

        // Check if a new image is uploaded
        if (!empty($_FILES['new_foto']['name'])) {
            $new_name = uploadImage($_FILES['new_foto'], "../assets/img/product-images/");

            if (is_string($new_name)) {
                $result = editProduct($conn, $id, $kategori, $nama, $new_name, $detail);
            } else {
                echo '<div class="alert alert-success position-absolute text-center" style="width: 100%;" role="alert">' . $new_name . '</div>';
                echo '<meta http-equiv="refresh" content="1; url=edit-product.php?product_id=' . $data['product_id'] . '" />';
                exit();
            }
        } else {
            // No new image is uploaded, keep the existing image
            $queryExistingImage = mysqli_query($conn, "SELECT image FROM products WHERE product_id = $id");
            $existingImageData = mysqli_fetch_assoc($queryExistingImage);
            $existingImage = $existingImageData['image'];
            $result = editProduct($conn, $id, $kategori, $nama, $existingImage, $detail);
        }

        if ($result === true) {
            echo '<div class="alert alert-success position-absolute text-center" style="width: 100%; role="alert">Data Berhasil Diubah!</div>';
            echo '<meta http-equiv="refresh" content="1; url=edit-product.php?product_id=' . $data['product_id'] . '" />';
        } else {
            echo '<div class="alert alert-danger position-absolute text-center" style="width: 100%; role="alert">Data gagal diubah!</div>';
            echo '<meta http-equiv="refresh" content="1; url=edit-product.php?product_id=' . $data['product_id'] . '" />';
        }
    }



    if (isset($_POST['add_variation'])) {

        $product_id = $_POST['product_id'];
        $type_product = $_POST['type_product'];
        $harga = $_POST['harga'];

        // Call the addVariation function to add the variation
        $result = addVariation($conn, $product_id, $type_product, $harga);

        if ($result === true) {
            echo '<div class="alert alert-success position-absolute text-center" style="width: 100%; role="alert">Variasi berhasil Ditambahkan!</div>';
            echo '<meta http-equiv="refresh" content="1; url=edit-product.php?product_id=' . $data['product_id'] . '" />';
        } else {
            echo '<div class="alert alert-danger position-absolute text-center" style="width: 100%;" role="alert">' . $result . '</div>';
            echo '<meta http-equiv="refresh" content="1; url=edit-product.php?product_id=' . $data['product_id'] . '" />';
        }
    }

    if (isset($_POST['delete_variation'])) {
        $id = htmlspecialchars($_POST['variation_id']);
        $result = deleteVariation($conn, $id);

        if ($result === true) {
            echo '<div class="alert alert-success position-absolute text-center" style="width: 100%; role="alert">Data Berhasil dihapus!</div>';
            echo '<meta http-equiv="refresh" content="1; url=edit-product.php?product_id=' . $data['product_id'] . '" />';
        } else {
            echo '<div class="alert alert-danger position-absolute text-center" style="width: 100%; role="alert">' . $result . '</div>';
            echo '<meta http-equiv="refresh" content="1; url=edit-product.php?product_id=' . $data['product_id'] . '" />';
        }
    }

    if (isset($_POST['add_pricing'])) {
        $id = htmlspecialchars($_POST['variation_id']);
        $min = htmlspecialchars($_POST['min_quantity']);
        $max = htmlspecialchars($_POST['max_quantity']);
        $price = htmlspecialchars($_POST['price']);

        $result = addVariationPricing($conn, $id, $min, $max, $price);

        if ($result === true) {
            echo '<div class="alert alert-success position-absolute text-center" style="width: 100%; role="alert">Data Berhasil Dibuat!</div>';
            echo '<meta http-equiv="refresh" content="1; url=edit-product.php?product_id=' . $data['product_id'] . '" />';
        } else {
            echo '<div class="alert alert-danger position-absolute text-center" style="width: 100%; role="alert">' . $result . '</div>';
            echo '<meta http-equiv="refresh" content="1; url=edit-product.php?product_id=' . $data['product_id'] . '" />';
        }
    }
    // } else if (isset($_POST['delete_pricing'])) {
    //     $id = htmlspecialchars($_POST['pricing_id']);
    //     $result = deletePricing($conn, $id);

    //     if ($result === true) {
    //         echo '<div class="alert alert-success position-absolute text-center" style="width: 100%; role="alert">Data Berhasil dihapus!</div>';
    //         echo '<meta http-equiv="refresh" content="1; url=edit-product.php?product_id=' . $data['product_id'] . '" />';
    //     } else {
    //         echo '<div class="alert alert-danger position-absolute text-center" style="width: 100%; role="alert">' . $result . '</div>';
    //         echo '<meta http-equiv="refresh" content="1; url=edit-product.php?product_id=' . $data['product_id'] . '" />';
    //     }
    // } else if (isset($_POST['save_editPricing'])) {
    //     $id = htmlspecialchars($_POST['pricing_id']);
    //     $varId = htmlspecialchars($_POST['variation_id']);
    //     $min = htmlspecialchars($_POST['new_min_quantity']);
    //     $max = htmlspecialchars($_POST['new_max_quantity']);
    //     $price = htmlspecialchars($_POST['new_price']);

    //     $result = updatePricing($conn, $pricing_id, $variation_id, $min_quantity, $max_quantity, $price);

    //     if ($result === true) {
    //         echo '<div class="alert alert-success position-absolute text-center" style="width: 100%; role="alert">Data Berhasil Dibuat!</div>';
    //         echo '<meta http-equiv="refresh" content="1; url=edit-product.php?product_id=' . $data['product_id'] . '" />';
    //     } else {
    //         echo '<div class="alert alert-danger position-absolute text-center" style="width: 100%; role="alert">' . $result . '</div>';
    //         echo '<meta http-equiv="refresh" content="1; url=edit-product.php?product_id=' . $data['product_id'] . '" />';
    //     }
    // }

    $queryVariations = mysqli_query($conn, "SELECT pv.*, pt.type_name FROM product_variations pv JOIN product_types pt ON pv.type_id = pt.type_id WHERE product_id = $product_id");

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
        <title>Data Produk</title>
    </head>

    <body>
        <?php require "sidebar.php"; ?>
        <div class="content col-md-10">
            <div class="top-fixed line"></div>
            <div class="container">
                <div class="back ps-5 mt-5">
                    <a class="btn btn-outline-secondary" onclick="history.back()"><i data-feather="arrow-left"></i>Kembali</a>
                </div>
                <div class="title text-center mt-4">
                    <span>Edit Produk</span>
                </div>

                <div class="content-body mt-5 pb-5 px-5">
                    <div class="edit-product">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="product-image">
                                        <img src="../assets/img/product-images/<?php echo $data['image'] ?>" alt="<?php echo $data['product_name'] ?>" class="w-100 mb-2">
                                        <input type="file" name="new_foto" id="new_foto" class="form-control">
                                        <small class="form-text text-danger">*Upload gambar baru untuk mengubah gambar.</small>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="product-data">
                                        <input type="hidden" name="product_id" value="<?php echo $data['product_id']; ?>">
                                        <div class="form-group">
                                            <label for="new_nama">Nama Produk</label>
                                            <input type="text" id="new_nama" name="new_nama" class="form-control" value="<?php echo $data['product_name']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="new_kategori">Kategori</label>
                                            <select name="new_kategori" id="new_kategori" class="form-control" required>
                                                <?php
                                                foreach ($querykategori as $kategori) {
                                                    $selected = ($kategori['category_id'] == $data['category_id']) ? 'selected' : '';
                                                ?>
                                                    <option value="<?php echo $kategori['category_id']; ?>" <?php echo $selected; ?>><?php echo $kategori['category_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="new_desc">Deskripsi</label>
                                            <textarea name="new_desc" id="new_desc" class="form-control" rows="5"><?php echo $data['description']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 pt-2 text-end" style="border-top: 1px solid #999;">
                                <button type="submit" class="btn btn-primary me-2 w-100" name="save_edit">Simpan Perubahan</button>
                            </div>
                        </form>

                        <!-- VARIATIONS -->
                        <div class="row mt-5 pt-2" style="border-top: 1px solid #ddd;">
                            <h5 class="fs-2">Daftar Variasi Produk</h5>
                            <div class="col-lg-8 variasi-list">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama Jenis</th>
                                            <th>Harga</th>
                                            <th>Harga khusus</th>
                                            <th>Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $queryVariations = getProductVariations($conn, $product_id);
                                        $variasi = count($queryVariations);
                                        if ($variasi == 0) { ?>
                                            <tr>
                                                <td colspan="6" class="text-center">Tidak Ada Varian</td>
                                            </tr>
                                            <?php } else {
                                            foreach ($queryVariations as $variationData) { ?>
                                                <tr>
                                                    <td><?php echo $variationData['type_name']; ?></td>
                                                    <td>Rp. <?php echo $variationData['price']; ?></td>
                                                    <td class="text-center">
                                                        <?php
                                                        $varID = $variationData['variation_id'];
                                                        $pricingQuery = mysqli_query($conn, "SELECT variation_id FROM variation_pricing WHERE variation_id = '$varID'");
                                                        $pricing = mysqli_fetch_array($pricingQuery);

                                                        if ($pricing) { ?>
                                                            <form action="edit-harga.php" method="get">
                                                                <input type="hidden" name="variation_id" value="<?php echo $variationData['variation_id']; ?>">
                                                                <button type="submit" class="btn btn-outline-primary ms-2"><i data-feather="edit"></i></button>
                                                            </form>
                                                        <?php } else {
                                                            echo '<small class="text-danger fst-italic">Tidak ada harga khusus</small>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <form action="product.php" method="post">
                                                            <input type="hidden" name="variation_id" value="<?php echo $variationData['variation_id']; ?>">
                                                            <button type="submit" class="btn btn-outline-danger" name="delete_variation"><i data-feather="trash-2"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                        <?php }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-4 variasi-form ps-4">
                                <div class="dropdown-center pt-2">
                                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" style="background-color: var(--primary); color: #fff;">
                                        <i data-feather="plus-circle"></i>Tambah Variasi
                                    </button>
                                    <div class="dropdown-menu w-100 px-2 py-2">
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="type_product">Nama Jenis Variasi</label>
                                                <input type="text" id="type_product" name="type_product" class="form-control" autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <label for="harga">Harga</label>
                                                <input type="number" id="harga" name="harga" class="form-control" autocomplete="off">
                                            </div>
                                            <input type="hidden" name="product_id" value="<?php echo $data['product_id']; ?>">
                                            <button type="submit" class="btn btn-primary w-100" name="add_variation">Tambah</button>
                                        </form>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-warning mt-2 w-100" data-bs-toggle="modal" data-bs-target="#addPricingModal">
                                    <span class="feather"><i data-feather="plus"></i></i></span>Buat Harga Khusus
                                </button>
                                <div class="price-list pt-2">
                                    <span class="product-det">
                                        <h1 data-product-name="<?php echo $data['product_name'] ?>" hidden></h1>
                                    </span>
                                    <label for="variation">Pilih jenis variasi :</label>
                                    <div class="d-flex pb-2">
                                        <select name="variation" id="variation" class="form-select" style="width: 200px;">
                                            <?php
                                            foreach ($queryVariations as $varData) { ?>
                                                <option value="<?php echo $varData['variation_id'] ?>" data-price="<?php echo $varData['price']; ?>"><?php echo $varData['type_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div id="pricing-container">
                                        <!-- Pricing information will be displayed here -->
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- END VARIATIONS -->
                    </div>
                </div>

                <!-- ADD PRICING MODAL -->
                <div class="modal" id="addPricingModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: var(--primary);">
                                <h5 class="modal-title text-white fw-bold">Tambah Harga Khusus</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Pricing Form -->
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label for="variation_id">Jenis Variasi : </label>
                                        <select name="variation_id" id="variation_id" class="form-select" required>
                                            <option selected disabled hidden value="default">Pilih Jenis Variasi</option>
                                            <?php
                                            foreach ($queryVariations as $varData) {
                                                echo '<option value="' . $varData['variation_id'] . '">' . $varData['type_name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="min_quantity">Min. Jumlah :</label>
                                        <input type="number" id="min_quantity" name="min_quantity" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="max_quantity">Max. Jumlah :</label>
                                        <input type="number" id="max_quantity" name="max_quantity" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Atur Harga :</label>
                                        <input type="text" id="price" name="price" class="form-control" required>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" name="add_pricing">Tambah</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END MODAL -->
            </div>
        </div>

        <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/pricing.js"></script>
        <script>
            var pricingData = <?php echo json_encode($pricingData); ?>
        </script>
        <script>
            feather.replace()
        </script>
    </body>

    </html>