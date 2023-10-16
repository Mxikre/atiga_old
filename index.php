<?php
session_start();

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/img/atiga-xicon.png">
    <!-- CSS -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Feather Icon -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <title>Atiga Ditigal Printing</title>
</head>

<body>
    <!-- NavBar -->
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="assets/img/atiga-logo.png" alt="Atiga-icon">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
                <div class="row ms-4">
                    <div class="d-flex justify-content-start px-2">
                        <div class="search mt-4">
                            <input type="text" class="search-input" placeholder="SEARCH...">
                            <a href="#" class="search-icon"><i data-feather="search"></i></a>
                        </div>
                    </div>
                    <ul class="navbar-nav mt-2 fs-5 fw-bold">
                        <li class="nav-item px-3">
                            <a class="nav-link" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item dropdown px-3 ">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Kategori
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Banner</a></li>
                                <li><a class="dropdown-item" href="#">Poster</a></li>
                                <li><a class="dropdown-item" href="#">Sablon</a></li>
                            </ul>
                        </li>
                        <li class="nav-item px-3">
                            <a class="nav-link" href="#about">Tentang Kami</a>
                        </li>
                        <li class="nav-item px-3">
                            <a class="nav-link" href="#">Kontak Kami</a>
                        </li>
                    </ul>
                </div>
                <div class="nav-extra">
                    <span class="login-icon">
                        <i data-feather="user"></i>
                        <?php
                        if (!isset($_SESSION['login'])) {
                            echo '<button class="btn login-button" onclick="login()">Masuk</button>';
                        } else {
                            echo '<button class="btn login-button" onclick="logout()">Keluar</button>';
                        }
                        ?>
                    </span>
                    <a href="#" class="cart-icon"><i data-feather="shopping-cart"></i></a>
                </div>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->

    <!-- Banner -->
    <section class="banner h-100 py-5">
        <div id="MyCarousel" class="carousel slide pb-4" data-bs-ride="true">
            <div class="carousel-indicators mb-0">
                <button type="button" data-bs-target="#MyCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#MyCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#MyCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>

            </div>

            <div class="carousel-inner">

                <div class="carousel-item active">
                    <div class="container">
                        <div class="row justify-content-between">
                            <div class="col-lg-6 py-5">
                                <h1>Banner Kustom dengan Hasil Cetak Berkualitas Tinggi.</h1>
                                <p>Kami menyediakan banner kustom berkualitas tinggi yang cocok untuk semua kebutuhan. Apakah Anda seorang pemilik bisnis yang ingin mempromosikan usaha Anda atau perlu banner untuk acara anda. Tunggu apa lagi, ayo pesan sekarang!</p>
                                <button class="btn mt-3">Pesan Sekarang</button>
                            </div>
                            <div class="col-lg-5">
                                <img src="assets/img/vector.png">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="container">
                        <div class="row justify-content-between">
                            <div class="col-lg-6 py-5">
                                <h1>Sablon Kaos Terbaik untuk design Kustom Anda</h1>
                                <p>Hasilkan kaos sesuai keinginan Anda! Di Atiga Media, kami memberikan layanan cetak kaos custom dengan kualitas terbaik. Biarkan design Anda bersinar di kaos berkualitas tinggi. Tunggu apa lagi, ayo pesan sekarang!</p>
                                <button class="btn mt-3">Pesan Sekarang</button>
                            </div>
                            <div class="col-lg-5">
                                <img src="assets/img/illust2.png">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="container">
                        <div class="row justify-content-between">
                            <div class="col-lg-6 py-5">
                                <h1>Banner Kustom dengan Hasil Cetak Berkualitas Tinggi.</h1>
                                <p>Kami menyediakan banner kustom berkualitas tinggi yang cocok untuk semua kebutuhan. Apakah Anda seorang pemilik bisnis yang ingin mempromosikan usaha Anda atau perlu banner untuk acara anda. Tunggu apa lagi, ayo pesan sekarang!</p>
                                <button class="btn mt-3">Pesan Sekarang</button>
                            </div>
                            <div class="col-lg-5">
                                <img src="assets/img/vector.png">
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

    <!-- Product -->
    <section class="product">
        <div class="title d-flex justify-content-center">
            <h1>Produk Kami</h1>
        </div>
        <div class="container mt-5">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-3">
                    <div class="card">
                        <img src="assets/img/rollup280.png" class="card-img-top" alt="rollup">
                        <div class="card-body">
                            <a href="#" class="card-title" data-bs-toggle="modal" data-bs-target="#detail-lengko">Roll Up Banner 280 gsm</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <img src="assets/img/banner.png" class="card-img-top" alt="rollup">
                        <div class="card-body">
                            <a href="#" class="card-title" data-bs-toggle="modal" data-bs-target="#detail-lengko">Flexy China 280 gsm</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <img src="assets/img/banner2.png" class="card-img-top" alt="rollup">
                        <div class="card-body">
                            <a href="#" class="card-title" data-bs-toggle="modal" data-bs-target="#detail-lengko">Flexy Korea 440 gsm</a>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- About -->
    <section class="about" id="about">
        <div class="content">
            <div class="title d-flex justify-content-center">
                <h1><span class="first">Tentang </span>Kami</h1>
            </div>
            <div class="row d-flex justify-content-center mt-3">
                <div class="image-about col-lg-6">
                    <div id="carousel-about" class="carousel slide">
                        <div class="container position-relative">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="assets/img/tentang-kami.jpg" class="d-block" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="assets/img/tentang-kami2.jpg" class="d-block" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="assets/img/tentang-kami3.jpg" class="d-block" alt="...">
                                </div>

                            </div>
                            <button class="carousel-control button-arrow-left position-absolute start-0" type="button" data-bs-target="#carousel-about" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </button>
                            <button class="carousel-control button-arrow-right position-absolute end-0" type="button" data-bs-target="#carousel-about" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="about-text col-lg-4">
                    <p>Atiga Digital Printing Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores dolore ducimus accusantium placeat consequuntur atque iste iusto deserunt laboriosam tempora sequi consectetur, sapiente temporibus ut rem? Architecto quasi minus sunt!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark py-5">
        <div class="container">
            <div class="row text-white g-4">
                <div class="col-md-6 col-lg-3">
                    <img src="assets/img/atiga-footer-img.png" alt="Atiga" width="200" height="200">
                </div>

                <div class="col-md-6 col-lg-3">
                    <h5 class="fw-light">Links</h5>
                    <ul class="list-unstyled">
                        <li class="my-3">
                            <a href="#" class="text-white text-decoration-none text-muted">
                                <i class="me-1" data-feather="chevron-right"></i> Home
                            </a>
                        </li>
                        <li class="my-3">
                            <a href="#" class="text-white text-decoration-none text-muted">
                                <i class="me-1" data-feather="chevron-right"></i> Produk
                            </a>
                        </li>
                        <li class="my-3">
                            <a href="#" class="text-white text-decoration-none text-muted">
                                <i class="me-1" data-feather="chevron-right"></i> Tentang Kami
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-6 col-lg-3">
                    <h5 class="fw-light mb-3">Quick Contact</h5>
                    <div class="d-flex justify-content-start align-items-start my-2 text-muted">
                        <span class="me-3">
                            <i data-feather="map"></i>
                        </span>
                        <span class="fw-light">
                            Jalan Raya Lohbener Lama Celeng Blok Bukasem, Lohbener, Kec. Lohbener, Kabupaten Indramayu, Jawa Barat 45252
                        </span>
                    </div>
                    <div class="d-flex justify-content-start align-items-start my-2 text-muted">
                        <span class="me-3">
                            <i data-feather="mail"></i>
                        </span>
                        <span class="fw-light">
                            atiga.support@gmail.com
                        </span>
                    </div>
                    <div class="d-flex justify-content-start align-items-start my-2 text-muted">
                        <span class="me-3">
                            <i data-feather="phone"></i>
                        </span>
                        <span class="fw-light">
                            +6212-1234-4256
                        </span>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <h5 class="fw-light mb-3">Social Media</h5>
                    <div>
                        <ul class="list-unstyled d-flex">
                            <li>
                                <a href="#" class="text-white text-decoration-none text-muted fs-4 me-4">
                                    <i data-feather="facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-white text-decoration-none text-muted fs-4 me-4">
                                    <i data-feather="twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-white text-decoration-none text-muted fs-4 me-4">
                                    <i data-feather="instagram"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <!-- JS -->
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/functions.js"></script>
    <script>
        feather.replace()
    </script>

</body>

</html>