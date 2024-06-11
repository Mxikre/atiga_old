<?php
require "../includes/config.php";
require "../includes/session.php";
require "../includes/function.php";
check_session();
error_reporting(E_ALL);

// $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
// $limit = 5; // Jumlah data per halaman
// $offset = ($currentPage - 1) * $limit; // Menghitung offset

$queryCustomer = getData($conn, 'customers');
$jumlahPengguna = count($queryCustomer);

// $totalPages = ceil($jumlahPengguna / $limit);
// $query = mysqli_query($conn, "SELECT * FROM customers LIMIT $offset, $limit");

// $nomorUrutKeseluruhan = ($currentPage - 1) * $limit + 1;

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
                <span>Data Pengguna</span>
            </div>
            <div class="content-body mt-5">
                <div class="mt-2">
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered" id="data_table">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No. Telepon</th>
                                    <th>Alamat</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($jumlahPengguna == 0) { ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Data tidak tersedia</td>
                                    </tr>
                                    <?php } else {
                                    $jumlah = 1;
                                    foreach ($queryCustomer as $data) { ?>
                                        <tr>
                                            <td><?php echo $jumlah; ?></td>
                                            <td><?php echo $data['name']; ?></td>
                                            <td><?php echo $data['email']; ?></td>
                                            <td><?php echo $data['no_telp']; ?></td>
                                            <td><?php echo $data['address']; ?></td>
                                            <td>
                                                <div class="action d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-outline-danger me-2" name="delete"><i data-feather="trash-2"></i></button>
                                                    <button type="submit" class="btn btn-outline-primary ms-2" name="edit"><i data-feather="edit"></i></button>
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
                    <!-- <?php include 'pagination-nav.php'; ?> -->
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Footer -->
    <?php include("layouts/footer.php") ?>
    <script src="../assets/js/dataTables.js"></script>

</body>

</html>