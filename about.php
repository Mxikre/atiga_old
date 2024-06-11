<?php
require "includes/config.php";
require "includes/session.php";
require "includes/function.php";

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
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/about.css">

    <!-- Feather Icon -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <title>Atiga Ditigal Printing</title>
</head>

<body>
    <?php include 'includes/navbar.php'; ?>

    <!-- End Navbar -->

    <section class="banner-about">
        <div class="container-fluid">
            <div class="banner-text">
                <h1><span style="color: var(--primary);">Tentang </span>Kami</h1>
            </div>
        </div>

    </section>

    <!-- About -->
    <section class="about" id="about">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="image-about col-lg-6">
                    <img src="<?= base_url() ?>assets/img/about-img.webp" alt="tentang-kami">
                </div>
                <div class="about-text col-lg-6">
                    <p class="fs-5"><span class="first">Atiga Digital Printing</span>
                        Adalah Sebuah Perusahaan yang bergerak di bidang digital printing yang didirikan pada tahun <span class="first">2023</span></p>
                    <p>Dengan dedikasi kami dalam memberikan layanan berkualitas tinggi, kami telah menjadi pilihan terpercaya pelanggan dalam mencetak berbagai produk mulai dari brosur, pamflet, kartu nama, hingga spanduk.
                        Komitmen kami adalah memberikan hasil cetak berkualitas, dan terjangkau untuk memenuhi kebutuhan cetak Anda. Dari cetakan brosur eye-catching hingga spanduk promosi yang kreatif, tim kami siap melayani pesanan produk cetak Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="visi-misi">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="title">
                            <h2>Visi Kami</h2>
                        </div>
                        <div class="vm-text">
                            <p>"Menjadi mitra percetakan digital pilihan utama dengan reputasi unggul dalam inovasi dan pelayanan pelanggan, menciptakan dampak positif dalam dunia cetak digital."</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="title">
                            <h2>Misi Kami</h2>
                        </div>
                        <div class="vm-text">
                            <p>"Memberikan solusi cetak digital yang unggul dan inovatif kepada pelanggan kami. Kami berkomitmen untuk menyediakan layanan berkualitas tinggi dengan standar terdepan dalam industri percetakan."</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php
    include 'includes/footer.php';
    ?>


    <!-- JS -->
    <script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery-3.7.1.min.js"></script>
    <script src="<?= base_url() ?>assets/js/functions.js"></script>
    <script>
        feather.replace()
    </script>

</body>

</html>