<?php
require "../includes/config.php";
require "../includes/session.php";
check_session();
error_reporting(E_ALL);
require "../includes/function.php";




if (isset($_GET['variation_id'])) {
    $variation_id = $_GET['variation_id'];

    $queryVariation = mysqli_query($conn, "SELECT product_id FROM product_variations WHERE variation_id = '$variation_id'");
    $product_id = mysqli_fetch_array($queryVariation);



    // Retrieve product details for editing
    $queryEditPricing = mysqli_query($conn, "SELECT * FROM variation_pricing WHERE variation_id = '$variation_id'");
    $pricing_data = mysqli_fetch_assoc($queryEditPricing);
} else {
    // Redirect to the product list page if product_id is not set
    header("Location: product.php");
    exit();
}



if (isset($_POST['delete_pricing'])) {
    $id = htmlspecialchars($_POST['pricing_id']);
    $result = deletePricing($conn, $id);

    if ($result === true) {
        echo '<div class="alert alert-success position-absolute text-center" style="width: 100%; role="alert">Data Berhasil dihapus!</div>';
        echo '<meta http-equiv="refresh" content="1; url=edit-product.php?product_id=' . $product_id['product_id'] . '" />';
    } else {
        echo '<div class="alert alert-danger position-absolute text-center" style="width: 100%; role="alert">' . $result . '</div>';
        echo '<meta http-equiv="refresh" content="1; url=edit-product.php?product_id=' . $product_id['product_id'] . '" />';
    }
} else if (isset($_POST['save_editPricing'])) {
    $id = ($_POST['pricing_id']);
    $min = ($_POST['new_min']);
    $max = ($_POST['new_max']);
    $price = ($_POST['new_price']);

    $result = updatePricing($conn, $id, $min, $max, $price);

    if ($result === true) {
        echo '<div class="alert alert-success position-absolute text-center" style="width: 100%; role="alert">Data Berhasil perbarui!</div>';
        echo '<meta http-equiv="refresh" content="1; url=edit-harga.php?variation_id=' . $variation_id . '" />';
    } else {
        echo '<div class="alert alert-danger position-absolute text-center" style="width: 100%; role="alert">' . $result . '</div>';
        echo '<meta http-equiv="refresh" content="1; url=edit-harga.php?variation_id=' . $variation_id . '" />';
    }
}

$queryVariations = mysqli_query($conn, "SELECT pt.type_name AS variation_name FROM product_variations pv JOIN product_types pt ON pv.type_id = pt.type_id WHERE variation_id = $variation_id");

$varNama = mysqli_fetch_assoc($queryVariations);


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
                <span>Edit Harga</span>
            </div>

            <div class="content-body mt-5 pb-5 px-5">
                <div class="mt-3">
                    <h3><?= $varNama['variation_name'] ?></h3>
                    <div class="table-responsive mt-2 w-20">
                        <table class="table table-bordered" id="data_table">
                            <thead>
                                <tr class="text-center">
                                    <th>min</th>
                                    <th>max</th>
                                    <th>harga</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($queryEditPricing as $data) { ?>
                                    <tr class="text-center">
                                        <td><?php echo $data['min_quantity'] ?></td>
                                        <td><?php echo $data['max_quantity'] ?></td>
                                        <td><?php echo $data['price'] ?></td>
                                        <td>
                                            <div class="action d-flex justify-content-center">
                                                <form action="" method="post">
                                                    <input type="hidden" name="pricing_id" value="<?php echo $data['pricing_id']; ?>">
                                                    <button type="submit" class="btn btn-outline-danger me-2" name="delete_pricing"><i data-feather="trash-2"></i></button>
                                                </form>
                                                <button type="submit" class="btn btn-outline-primary ms-2" name="edit_pricing" data-bs-toggle="modal" data-bs-target="#editPricingModal<?php echo $data['pricing_id']; ?>"><i data-feather="edit"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- END TABLE -->
                </div>
                <?php
                foreach ($queryEditPricing as $data) { ?>
                    <div class="modal" id="editPricingModal<?php echo $data['pricing_id']; ?>" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Harga</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="post">
                                        <input type="hidden" name="pricing_id" value="<?php echo $data['pricing_id']; ?>">
                                        <div class="form-group">
                                            <label for="new_min">min : </label>
                                            <input type="number" id="new_min" name="new_min" class="form-control" value="<?php echo $data['min_quantity']; ?>" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="new_max">max : </label>
                                            <input type="number" id="new_max" name="new_max" class="form-control" value="<?php echo $data['max_quantity']; ?>" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="new_price">price : </label>
                                            <input type="number" id="new_price" name="new_price" class="form-control" value="<?php echo $data['price']; ?>" autocomplete="off" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary" name="save_editPricing">Simpan</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>


    </div>
    </div>

    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        feather.replace()
    </script>
</body>

</html>