<?php
require "../includes/config.php";
require "../includes/session.php";
require "../includes/function.php";
include "../includes/tgl_indo.php";
check_session();



// Ambil riwayat pesanan
$orders = getOrderHistory($conn);

$jumlahOrder = count($orders);


?>

<?php

$pageTitle = "Data Transaksi";
include("layouts/header.php");

?>

<body>
    <?php include "sidebar.php"; ?>
    <div class="content col-md-10">
        <div class="top-fixed line"></div>
        <div class="container">
            <div class="title text-center mt-5">
                <span>Data Transaksi</span>
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
                        <div class="table-responsive mt-2">
                            <table class="table table-bordered" id="data_table" style="width: 150%;">
                                <thead>
                                    <tr class="text-center">
                                        <th>Order ID</th>
                                        <th>Pembeli</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah/barang</th>
                                        <th>Total Harga Barang</th>
                                        <th>Tanggal</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order) : ?>
                                        <tr>
                                            <td><?php echo $order['order_id']; ?></td>
                                            <td><?php echo $order['customer_name']; ?></td>
                                            <td><?php echo $order['product_name'] . " - (" . $order['variation_name'] . ")"; ?></td>
                                            <td class="text-center"><?php echo $order['quantity']; ?></td>
                                            <td>Rp. <?php echo number_format($order['total_amount'], 2, '.', ','); ?></td>
                                            <td><?php echo $order['order_date']; ?></td>
                                            <td><?php echo $order['customer_address']; ?></td>
                                            <td class="text-center"> <?php echo $order['status_name'] ?> </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else : ?>
                        <div class="text-center text-muted" style="margin-top: 20%;">
                            <h3>-- Tidak Ada Transaksi --</h3>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <?php include("layouts/footer.php") ?>
    <script>
        $(document).ready(function() {
            $('#data_table').DataTable({
                dom: 'Bfrtilp',
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'All']
                ],
                buttons: [{
                        extend: 'pdf',
                        exportOptions: {
                            columns: [':not(:last-child)']
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [':not(:last-child)']
                        }

                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [':not(:last-child)']
                        }

                    },
                    'colvis'
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