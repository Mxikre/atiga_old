<nav id="navHeader" class="navbar navbar-expand-lg bg-light fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= base_url() ?>">
            <img src="<?= base_url() ?>assets/img/atiga-logo2.png" alt="Atiga-icon">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
            <div class="row ms-4">
                <!-- SEARCH BOX -->
                <div class="container-search ms-3 mt-3">
                    <form method="get" action="product-page">
                        <div class="search d-flex justify-content-between">
                            <input type="text" class="search-input" name="keyword" id="search-box" placeholder="cari produk ...">
                            <button type="submit" class="search-icon"><i data-feather="search"></i></button>
                        </div>
                    </form>
                </div>

                <!-- /// -->
                <ul class="navbar-nav fs-5 fw-bold">
                    <li class="nav-item px-3">
                        <a class="nav-link" aria-current="page" href="<?= base_url() ?>">Beranda</a>
                    </li>
                    <li class="nav-item dropdown px-3" id="kategoriDropdown">
                        <a class="nav-link dropdown dropdown-toggle" href="#">
                            Produk
                        </a>
                        <ul class="dropdown-menu">
                            <?php
                            $dataCategory = getData($conn, "categories");
                            foreach ($dataCategory as $data) { ?>
                                <li><a class="dropdown-item" href="<?= base_url() ?>product-page?kategori=<?php echo urlencode($data['category_name']) ?>"><?php echo $data['category_name'] ?></a></li>
                            <?php } ?>
                        </ul>

                    </li>
                    <li class="nav-item px-3">
                        <a class="nav-link" href="<?= base_url() ?>about">Tentang</a>
                    </li>
                    <li class="nav-item px-3">
                        <a class="nav-link" href="<?= base_url() ?>contact">Kontak Kami</a>
                    </li>
                </ul>
            </div>
            <div class="nav-extra mt-4 d-flex">
                <span class="login-icon">
                    <?php
                    if (!isset($_SESSION['username'])) { ?>
                        <i data-feather="user"></i>
                        <button class="btn btn-login btn-shape me-2" onclick="login()">Masuk</button>
                        <button class="btn btn-register btn-shape" onclick="register()">Daftar</button>
                    <?php } else {  ?>
                        <span class="dropdown">
                            <a role="button" data-bs-toggle="dropdown" class="userprofile text-decoration-none d-flex gap-1 align-items-center">
                                <?php
                                $user_id = $_SESSION['user_id'];
                                $dataPics = getUsersById($conn, $user_id);
                                foreach ($dataPics as $data) { ?>
                                    <img src="<?= base_url() ?>assets/img/profile/<?= $data['profile_pics'] ?>" alt="<?php echo $data['name']; ?>" class="profile-img rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
                                    <span class="username dropdown-toggle">
                                        <?php echo $data['name']; ?>
                                    </span>
                                <?php } ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= base_url() ?>profile">Lihat Profil</a></li>
                                <li><a class="dropdown-item" href="<?= base_url() ?>transaction">Transaksi</a></li>
                                <li><a class="dropdown-item" href="#" onclick="logout()">Keluar</a></li>
                            </ul>
                        </span>
                    <?php  } ?>
                </span>
                <?php
                if (isset($_SESSION['user_id'])) { ?>
                    <a href='cart' class='cart-icon'>
                        <i data-feather='shopping-cart'></i>
                        <?php
                        $queryCart = getData($conn, "cart");
                        $cart = count($queryCart);
                        if ($cart > 0) { ?>
                            <span class="item-count bg-warning px-2"><?php echo $cart ?></span>
                        <?php } ?>
                    </a>

                <?php } else { ?>
                    <span class="dropdown">
                        <a class='cart-icon text-decoration-none' role="button" data-bs-toggle="dropdown">
                            <i data-feather='shopping-cart' class="icon"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-content dropdown-menu-end text-center p-2" style="width: 450px;">
                            Login terlebih dahulu Untuk mengakses Keranjang
                        </ul>
                    </span>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>