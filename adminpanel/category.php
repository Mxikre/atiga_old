<?php
require "../includes/config.php";
require "../includes/session.php";
check_session();

require "../includes/function.php";

// $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
// $limit = 5; // Jumlah data per halaman
// $offset = ($currentPage - 1) * $limit; // Menghitung offset

$querykategori = getData($conn, "categories");
$jumlahkategori = count($querykategori);

// $totalPages = ceil($jumlahkategori / $limit);

// $query = mysqli_query($conn, "SELECT * FROM categories LIMIT $offset, $limit");

// $nomorUrutKeseluruhan = ($currentPage - 1) * $limit + 1;


if (isset($_POST['simpan'])) {
    $kategori = htmlspecialchars($_POST["kategori"]);
    $result = addCategory($conn, $kategori);

    if ($result === "Data berhasil tersimpan") {
        echo '<div class="alert alert-success position-absolute text-center" style="width: 100%;" role="alert">Data berhasil tersimpan!</div>';
        echo '<meta http-equiv="refresh" content="1; url=category.php"/>';
    } else {
        echo '<div class="alert alert-danger position-absolute text-center" style="width: 100%;" role="alert">' . $result . '</div>';
        echo '<meta http-equiv="refresh" content="1; url=category.php"/>';
    }
} else if (isset($_POST['delete'])) {
    $id = htmlspecialchars($_POST['category_id']);
    $result = deleteCategory($conn, $id);

    if ($result === "Data dihapus") {
        echo '<div class="alert alert-success position-absolute text-center" style="width: 100%;" role="alert">Data berhasil dihapus!</div>';
        echo '<meta http-equiv="refresh" content="1; url=category.php"/>';
    } else {
        echo '<div class="alert alert-danger position-absolute text-center" style="width: 100%;" role="alert">' . $result . '</div>';
        echo '<meta http-equiv="refresh" content="1; url=category.php"/>';
    }
} else if (isset($_POST['save_edit'])) {
    $id = htmlspecialchars($_POST['category_id']);
    $newCategoryName = htmlspecialchars($_POST['new_category_name']);
    $result = editCategory($conn, $id, $newCategoryName);

    if ($result === "Data berhasil diubah") {
        echo '<div class="alert alert-success position-absolute text-center" style="width: 100%;" role="alert">Data berhasil diubah!</div>';
        echo '<meta http-equiv="refresh" content="1; url=category.php"/>';
    } else {
        echo '<div class="alert alert-danger position-absolute text-center" style="width: 100%;" role="alert">' . $result . '</div>';
        echo '<meta http-equiv="refresh" content="1; url=category.php"/>';
    }
}

?>

<!-- HEADER -->
<?php

$pageTitle = "Data Pelanggan";
include("layouts/header.php");

?>
<!-- END HEADER -->

<body>
    <?php include "sidebar.php"; ?>
    <div class="content col-md-10">
        <div class="top-fixed line"></div>
        <div class="container">
            <div class="title text-center mt-5">
                <span>Data Kategori</span>
            </div>
            <div class="content-body mt-5 px-5">
                <!-- Modal Untuk Tambah kategori -->
                <div class="modal" id="addCategoryModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Kategori</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="category.php" method="post" enctype="multipart/form-data">
                                    <div>
                                        <label for="kategori">Nama Kategori</label>
                                        <input type="text" id="kategori" name="kategori" class="form-control" autocomplete="off" required>
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


                <div class="mt-3">
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-add" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                            <i data-feather="plus-circle"></i>
                            Tambah Kategori
                        </button>
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered" id="data_table">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Nama Kategori</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($jumlahkategori == 0) { ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Data tidak tersedia</td>
                                    </tr>
                                    <?php } else {
                                    $jumlah = 1;
                                    foreach ($querykategori as $data) { ?>
                                        <tr>
                                            <td><?php echo $jumlah; ?></td>
                                            <td><?php echo $data['category_name']; ?></td>
                                            <td>
                                                <div class="action d-flex justify-content-center">
                                                    <form action="category.php" method="post">
                                                        <input type="hidden" name="category_id" value="<?php echo $data['category_id']; ?>">
                                                        <button type="submit" class="btn btn-outline-danger me-2" name="delete"><i data-feather="trash-2"></i></button>
                                                    </form>
                                                    <button type="submit" class="btn btn-outline-primary ms-2" name="edit" data-bs-toggle="modal" data-bs-target="#editCategoryModal<?php echo $data['category_id']; ?>"><i data-feather="edit"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                        $jumlah++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- <?php include 'pagination-nav.php' ?> -->

                    <!-- Modal Untuk Edit Kategori -->
                    <?php
                    foreach ($querykategori as $data) { ?>
                        <div class="modal" id="editCategoryModal<?php echo $data['category_id']; ?>" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Kategori</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="category.php" method="post">
                                            <input type="hidden" name="category_id" value="<?php echo $data['category_id']; ?>">
                                            <div>
                                                <label for="new_category_name">Nama Kategori Baru</label>
                                                <input type="text" id="new_category_name" name="new_category_name" class="form-control" value="<?php echo $data['category_name']; ?>" autocomplete="off" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary" name="save_edit">Simpan</button>
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

    <!-- FOOTER -->

    <?php include("layouts/footer.php"); ?>
    <script src="../assets/js/dataTables.js"></script>
</body>

</html>