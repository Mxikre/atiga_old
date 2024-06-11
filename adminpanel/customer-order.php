<?php
require "../includes/config.php";
require "../includes/session.php";
require "../includes/function.php";
include "../includes/tgl_indo.php";
check_session();



// Ambil riwayat pesanan
$orders = getOrder($conn);

$statuses = getData($conn, 'order_statuses');

$jumlahOrder = count($orders);


// Handle form submission to update order status
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status_id = $_POST['new_status']; // Set the new status_id for "Diproses"

    // Update the order status in the database
    $updateQuery = "UPDATE orders SET status_id = ? WHERE order_id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param('ii', $new_status_id, $order_id);
    $updateStmt->execute();

    // Redirect or display a success message
    header("Location: customer-order.php");
    exit();
}



?>

<!-- HEADER -->
<?php

$pageTitle = "Data Pesanan";
include("layouts/header.php");

?>

<body>
    <?php include "sidebar.php"; ?>
    <div class="content col-md-10">
        <div class="top-fixed line"></div>
        <div class="container">
            <div class="title text-center mt-5">
                <span>Data Pesanan</span>
            </div>
            <div class="content-body mt-5 mb-5">
                <div class="mt-2">
                    <?php if ($jumlahOrder > 0) : ?>

                        <div class="searchByDate">
                            <h5>Cari berdasarkan tanggal</h5>
                            <table border="0" cellspacing="5" cellpadding="5" class="mb-4">
                                <tbody>
                                    <tr class="mb-4">
                                        <td>Setelah</td>
                                        <td class="px-3">:</td>
                                        <td><input type="text" id="min" name="min" placeholder=" --Masukkan Tanggal--"></td>
                                    </tr>
                                    <tr style="height: 10px;"></tr>
                                    <tr>
                                        <td>Sebelum</td>
                                        <td class="px-3">:</td>
                                        <td><input type="text" id="max" name="max" placeholder=" --Masukkan Tanggal--"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <table class="table table-bordered" id="data_table" style="width: 200%;">
                            <thead>
                                <tr class="text-center">
                                    <th class="text-start">ID</th>
                                    <th class="text-start">Nama Pembeli</th>
                                    <th>Nama Product</th>
                                    <th>Jumlah</th>
                                    <th>Total Harga</th>
                                    <th>Tanggal</th>
                                    <th>Alamat</th>
                                    <th>Status</th>
                                    <th>Design</th>
                                    <th>Update Status Pesanan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order) : ?>
                                    <tr>
                                        <td><?php echo $order['order_id']; ?></td>
                                        <td><?php echo $order['customer_name']; ?></td>
                                        <td><?php echo $order['product_name'] . "(" . $order['variation_name'] . ")"; ?></td>
                                        <td class="text-center"><?php echo $order['quantity']; ?></td>
                                        <td><?php echo $order['total_amount']; ?></td>
                                        <td><?php echo $order['order_date']; ?></td>
                                        <td><?php echo $order['customer_address']; ?></td>
                                        <td class="text-center">
                                            <span class="status">
                                                <?php if ($order['status_id'] === 1) : ?>
                                                    <span class="processing">
                                                    <?php else : ?>
                                                        <span class="confirm">
                                                        <?php endif; ?>
                                                        <?php echo $order['status_name']; ?>
                                                        </span>
                                                    </span>
                                        </td>
                                        <td class="text-center">
                                            <a class="download-btn" href="../assets/img/designUser/<?php echo $order['design']; ?>" download>
                                                <i data-feather="download"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <form method="post" action="customer-order.php">
                                                <div class="update-status d-flex justify-content-start px-3">
                                                    <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                                    <select name="new_status" class="form-select form-select-sm">
                                                        <?php foreach ($statuses as $status) : ?>
                                                            <option value="<?php echo $status['status_id']; ?>" <?php echo ($status['status_id'] == $order['status_id']) ? 'selected' : ''; ?>>
                                                                <?php echo $status['status_name']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <button type="submit" name="update_status" class="btn btn-outline-success btn-sm"><i data-feather="check"></i></button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <div class="text-center text-muted" style="margin-top: 20%;">
                            <h3>-- Tidak Ada Pesanan --</h3>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <?php include("layouts/footer.php"); ?>
    <script>
        $(document).ready(function() {
            $('#data_table').DataTable({
                dom: 'Bfrtilp',
                buttons: ['print', 'colvis'],
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'All']
                ],

                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
                },
                colReorder: true,
                scrollX: 200,
                info: false
            });

            let minDate, maxDate;

            // Custom filtering function which will search data in column four between two values
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                let min = minDate.val();
                let max = maxDate.val();
                let date = new Date(data[5]);

                if (
                    (min === null && max === null) ||
                    (min === null && date <= max) ||
                    (min <= date && max === null) ||
                    (min <= date && date <= max)
                ) {
                    return true;
                }
                return false;
            });

            // Create date inputs
            minDate = new DateTime('#min', {
                format: 'MMMM Do YYYY',
            });
            maxDate = new DateTime('#max', {
                format: 'MMMM Do YYYY',
            });

            // DataTables initialization
            let table = $('#data_table').DataTable();

            // Refilter the table
            document.querySelectorAll('#min, #max').forEach((el) => {
                el.addEventListener('change', () => table.draw());
            });
        });
    </script>

</body>

</html>