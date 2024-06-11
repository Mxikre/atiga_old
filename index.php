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

    <!-- Feather Icon -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <title>Atiga Ditigal Printing</title>
</head>

<body>
    <?php include 'includes/preloader.php';
    ?>

    <!-- NavBar -->
    <?php include 'includes/navbar.php'; ?>
    <!-- End Navbar -->

    <!-- Banner -->
    <section class="banner vh-100">
        <div class="content h-100">
            <div id="MyCarousel" class="carousel slide h-100 carousel-hero" data-bs-ride="carousel">
                <div class="carousel-indicators mb-0">
                    <button type="button" data-bs-target="#MyCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#MyCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#MyCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>

                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6 py-5 left-slide">
                                    <h1>Banner Kustom dengan Hasil Cetak Berkualitas Tinggi.</h1>
                                    <p>Kami menyediakan banner kustom berkualitas tinggi yang cocok untuk semua kebutuhan. Apakah Anda seorang pemilik bisnis yang ingin mempromosikan usaha Anda atau perlu banner untuk acara anda. Tunggu apa lagi, ayo pesan sekarang!</p>
                                    <div class="banner-btn mt-5">
                                        <a href="<?= base_url() ?>product-page?kategori=Banner">Pesan Sekarang</a>
                                    </div>
                                </div>
                                <div class="col-lg-6 d-flex justify-content-center right-slide">
                                    <img src="<?= base_url() ?>assets/img/illust/illust3.webp">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6 py-5 left-slide">
                                    <h1>Sablon Kaos Terbaik untuk design Kustom Anda.</h1>
                                    <p>Hasilkan kaos sesuai keinginan Anda! Di Atiga Media, kami memberikan layanan cetak kaos custom dengan kualitas terbaik. Biarkan design Anda bersinar di kaos berkualitas tinggi. Tunggu apa lagi, ayo pesan sekarang!</p>
                                    <div class="banner-btn mt-5">
                                        <a href="<?= base_url() ?>product-page?kategori=Sablon+Digital">Pesan Sekarang</a>
                                    </div>
                                </div>
                                <div class="col-lg-6 d-flex justify-content-center right-slide">
                                    <img src="<?= base_url() ?>assets/img/illust/illust2.webp">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6 py-5 left-slide ">
                                    <h1>Cetak Kertas A3+ dengan design anda.</h1>
                                    <p>Berikan sentuhan visual maksimal pada ide kreatif Anda dengan layanan cetak desain A3+ kami! Dengan teknologi cetak terkini dan kualitas cetak premium. Ayo pesan dan wujudkan design anda dengan kualitas cetak terbaik!</p>
                                    <div class="banner-btn mt-5">
                                        <a href="<?= base_url() ?>product-page?kategori=Print+Laser+A3">Pesan Sekarang</a>
                                    </div>
                                </div>
                                <div class="col-lg-6 d-flex justify-content-center right-slide">
                                    <img src="<?= base_url() ?>assets/img/illust/illust1.webp">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev justify-content-start" type="button" data-bs-target="#MyCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next justify-content-end" type="button" data-bs-target="#MyCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>

    </section>
    <!-- end banner -->

    <section class="info h-100">
        <div class="container text-center pt-5">
            <div class="row">
                <div class="col-lg-4 px-4">
                    <i data-feather="thumbs-up"></i>
                    <h4>Kualitas Tinggi</h4>
                    <p>Kami menjamin hasil cetak berkualitas tinggi dengan menggunakan peralatan terkini dan bahan terbaik.</p>
                </div>
                <div class="col-lg-4 px-4">
                    <i data-feather="truck"></i>
                    <h4>Pengiriman Cepat</h4>
                    <p>Layanan pengiriman cepat untuk memastikan produk Anda tiba tepat waktu.</p>
                </div>
                <div class="col-lg-4 px-4">
                    <i data-feather="credit-card"></i>
                    <h4>Harga Terjangkau</h4>
                    <p>Kami menawarkan harga yang kompetitif untuk semua produk kami tanpa mengorbankan kualitas.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Product -->
    <section class="product h-100">
        <div class="container text-center mt-5 pb-2">
            <div class="title d-flex justify-content-between">
                <h1>Produk Kami</h1>
                <span class="pt-3"><a href="<?= base_url() ?>product-page">Lihat semua ></a></span>
            </div>
            <div class="row">
                <?php
                $dataProduct = getProductByCategory($conn, "Banner");
                foreach ($dataProduct as $data) { ?>
                    <div class="col-lg-4 col-md-12 mb-4 right-slide">
                        <div class="card">
                            <div class="card-image">
                                <img src="<?= base_url() ?>assets/img/product-images/<?php echo $data['image']; ?>" class="w-100" />
                            </div>
                            <div class="card-body">
                                <a href="<?= base_url() ?>product-detail?name=<?php echo urlencode($data['product_name']); ?>">
                                    <h3 class="card-title mb-3"><?php echo $data['product_name']; ?></h3>
                                </a>
                                <a href="<?= base_url() ?>product-page?kategori=<?php echo $data['category_name']; ?>">
                                    <p><?php echo $data['category_name']; ?></p>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- PAYEMENT INFO -->
    <div class="mt-3 mb-5 text-center">
        <div class="container pt-4" style="border-top: 1px solid #ddd;">
            <div class="d-flex">
                <img src="<?= base_url() ?>assets/img/illust/cod.png" alt="cod" style="width: 500px; height: 500px;" class="cod left-slide">
                <div class="desc-cod ms-4">
                    <h2 class="fw-bold mb-3">Pembayaran mudah dengan system COD</h2>
                    <p>Anda hanya tinggal siapkan jumlah pembayaran yang mencukupi lalu bayarkan ke kurir.</p>
                </div>
            </div>
        </div>
    </div>


    <!-- Footer -->
    <?php
    include 'includes/footer.php';
    ?>


    <!-- JS -->
    <script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery-3.7.1.min.js"></script>
    <script src="<?= base_url() ?>assets/js/functions.js"></script>
    <script src="<?= base_url() ?>assets/js/script.js"></script>
    <script>
        feather.replace()
    </script>

</body>

</html>