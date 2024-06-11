<?php
require "../includes/config.php";
require "../includes/session.php";
check_session();
error_reporting(E_ALL);
require "../includes/function.php";

// $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
// $limit = 5; // Jumlah data per halaman
// $offset = ($currentPage - 1) * $limit; // Menghitung offset

$queryProduct = mysqli_query($conn, "SELECT a.*, b.category_name AS category_name FROM products a JOIN categories b ON a.category_id = b.category_id");

$jumlahproduk = mysqli_num_rows($queryProduct);



// $totalPages = ceil($jumblahproduk / $limit);

// $query = mysqli_query($conn, "SELECT a.*, b.category_name AS category_name FROM products a JOIN categories b ON a.category_id = b.category_id LIMIT $offset, $limit");

// $nomorUrutKeseluruhan = ($currentPage - 1) * $limit + 1;

$querykategori = getData($conn, "categories");

if (isset($_POST['simpan'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $kategori = htmlspecialchars($_POST['kategori']);
    $detail = htmlspecialchars($_POST['desc']);

    $new_name = uploadImage($_FILES['foto'], "../assets/img/product-images/");

    if (empty($nama) || empty($kategori)) {
        echo '<div class="alert alert-danger" style="width: 100%; role="alert">Nama, Kategori wajib diisi!</div>';
    } else {
        if (is_string($new_name)) {
            $result = addProduct($conn, $kategori, $nama, $new_name, $detail);
            if ($result === 'Data disimpan') {
                echo '<div class="alert alert-success position-absolute text-center" style="width: 100%; role="alert">Data Berhasil Tersimpan!</div>';
                echo '<meta http-equiv="refresh" content="1; url=product.php" />';
            } else {
                echo '<div class="alert alert-success position-absolute text-center" style="width: 100%; role="alert">' . $result . '</div>';
                echo '<meta http-equiv="refresh" content="1; url=product.php" />';
            }
        } else {
            echo '<div class="alert alert-danger position-absolute text-center" style="width: 100%;" role="alert">' . $new_name . '</div>';
            echo '<meta http-equiv="refresh" content="1; url=product.php" />';
        }
    }
} else if (isset($_POST['delete'])) {
    $id = htmlspecialchars($_POST['product_id']);
    $result = deleteProduct($conn, $id);

    if ($result === true) {
        echo '<div class="alert alert-success position-absolute text-center" style="width: 100%; role="alert">Data Berhasil dihapus!</div>';
        echo '<meta http-equiv="refresh" content="1; url=product.php" />';
    } else {
        echo '<div class="alert alert-danger position-absolute text-center" style="width: 100%; role="alert">Data gagal dihapus</div>';
        echo '<meta http-equiv="refresh" content="1; url=product.php" />';
    }
}

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
    <title>Data Produk</title>
</head>

<body>
    <?php require "sidebar.php"; ?>
    <div class="content col-md-10">
        <div class="top-fixed line"></div>
        <div class="container">
            <div class="title text-center mt-5">
                <span>Data Produk</span>
            </div>
            <div class="content-body mt-5 px-5 pb-3">
                <!-- ADD PRODUK -->
                <div class="modal" id="addProductModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Produk</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="product.php" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" id="nama" name="nama" class="form-control" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="kategori">Kategori</label>
                                        <select name="kategori" id="kategori" class="form-select" required>
                                            <option selected disabled hidden value="default">Pilih satu</option>
                                            <?php foreach ($querykategori as $data) { ?>
                                                <option class="selectItem" value="<?php echo $data['category_id']; ?>"><?php echo $data['category_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="foto">Gambar</label>
                                        <input type="file" name="foto" id="foto" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="desc">Deskripsi</label>
                                        <textarea name="desc" id="desc" cols="30" rows="10" class="form-control"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END ADD PRODUK -->


                <!-- TABLE LIST PRODUCT -->
                <div class="mt-3">
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-add" data-bs-toggle="modal" data-bs-target="#addProductModal">
                            <i data-feather="plus-circle"></i>
                            Tambah Produk
                        </button>
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered" id="data_table">
                            <thead>
                                <tr class="text-center">
                                    <th>NO</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Gambar</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $jumlah = 1;
                                while ($data = mysqli_fetch_array($queryProduct)) { ?>
                                    <tr class="text-center">
                                        <td><?php echo $jumlah; ?></td>
                                        <td><?php echo $data['product_name']; ?></td>
                                        <td><?php echo $data['category_name']; ?></td>
                                        <td><img src="../assets/img/product-images/<?php echo $data['image'] ?>" style="width: 50px;" alt="<?php echo $data['image'] ?>"></td>
                                        <td>
                                            <div class="action d-flex justify-content-center">
                                                <form action="product.php" method="post">
                                                    <input type="hidden" name="product_id" value="<?php echo $data['product_id']; ?>">
                                                    <button type="submit" class="btn btn-outline-danger me-2" name="delete"><i data-feather="trash-2"></i></button>
                                                </form>
                                                <form action="edit-product.php" method="get">
                                                    <input type="hidden" name="product_id" value="<?php echo $data['product_id']; ?>">
                                                    <button type="submit" class="btn btn-outline-primary ms-2"><i data-feather="edit"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                    $jumlah++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- END TABLE -->

                    <!-- <?php include 'pagination-nav.php' ?> -->







                </div>
            </div>

            <!-- Footer -->
            <?php include("layouts/footer.php") ?>
            <script>
                $(document).ready(function() {
                    $('#data_table').DataTable({
                        info: false,
                        dom: 'Bfrtilp',
                        lengthMenu: [
                            [10, 25, 50, -1],
                            [10, 25, 50, 'All']
                        ],
                        buttons: [{
                                extend: 'pdf',
                                exportOptions: {
                                    columns: [0, 1, 2]
                                }
                            },
                            {
                                extend: 'print',
                                exportOptions: {
                                    columns: [0, 1, 2]
                                }

                            },
                            {
                                extend: 'excel',
                                exportOptions: {
                                    columns: [0, 1, 2]
                                }

                            }
                        ],
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
                        },
                    });
                });
            </script>

</body>

</html>