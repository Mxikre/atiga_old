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
    <link rel="icon" type="image/x-icon" href="assets/img/atiga-xicon.png">
    <!-- CSS -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/contact.css">

    <!-- Feather Icon -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <title>Atiga Ditigal Printing</title>
</head>

<body>
    <?php include 'includes/navbar.php'; ?>

    <!-- End Navbar -->

    <section class="banner-contact">
        <div class="container">
            <div class="banner-text">
                <h1>Kontak Kami</h1>
                <p>Apa pertanyaanmu?</p>
            </div>
        </div>

    </section>

    <!-- About -->
    <section class="contact" id="contact">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-4">
                    <div class="card card-contact">
                        <div class="card-body">
                            <h3>Informasi Kontak</h3>
                            <div class="card-info">
                                <div class="d-flex justify-content-start align-items-start mt-2">
                                    <span class="me-3">
                                        <i data-feather="home"></i>
                                    </span>
                                    <span>
                                        Jalan Raya Lohbener Lama Celeng Blok Bukasem, Lohbener, Kec. Lohbener, Kabupaten Indramayu,
                                        Jawa Barat 45252
                                    </span>
                                </div>
                                <div class="d-flex justify-content-start align-items-start mt-4">
                                    <span class="me-3">
                                        <i data-feather="message-circle"></i>
                                    </span>
                                    <span>
                                        +6212-1234-4256
                                    </span>
                                </div>
                                <div class="d-flex justify-content-start align-items-start mt-4">
                                    <span class="me-3">
                                        <i data-feather="mail"></i>
                                    </span>
                                    <span>
                                        atiga.dp@gmail.com
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="message-form col-lg-8">
                    <div class="card card-contact">
                        <div class="card-body">
                            <h3>Kirim Pertanyaan Anda</h3>
                            <form method="post">
                                <div class="form-floating mb-3 mt-3">
                                    <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
                                    <label for="name">Nama Anda</label>
                                </div>
                                <div class="form-floating mb-3 mt-3">
                                    <input type="text" class="form-control" id="email" placeholder="Enter email" name="email">
                                    <label for="email">Email</label>
                                </div>
                                <div class="form-floating mb-3 mt-3">
                                    <input type="text" class="form-control" id="telepon" placeholder="Enter no. telepon" name="telepon">
                                    <label for="telepon">No. Telepon</label>
                                </div>
                                <div class="form-floating mb-3 mt-3">
                                    <textarea class="form-control" name="message" id="message" placeholder="Enter Message" style="height: 200px;"></textarea>
                                    <label for="message">Pesan</label>
                                </div>
                                <button type="submit" class="btn btn-warning mt-3">Submit</button>
                            </form>
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
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/functions.js"></script>
    <script>
        feather.replace()
    </script>

</body>

</html>