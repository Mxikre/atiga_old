<?php
require "includes/config.php";
require "includes/session.php";
require "includes/function.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: pages/login.php");
    exit();
}

$userID = $_SESSION['user_id'];

$user = mysqli_query($conn, "SELECT c.* FROM customers c JOIN users u ON c.user_id = u.user_id WHERE c.user_id = '$userID'");

if (isset($_POST['set'])) {
    $userName = $_POST['name'];
    $telp = $_POST['telp'];
    $email = $_POST['email'];
    $address = $_POST['alamat'];


    $sql = "UPDATE customers SET name=?, email=?, no_telp=?, address=? WHERE user_id=? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisi", $userName, $email, $telp, $address, $userID);

    $stmt->execute();

    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// if (isset($_POST['uploadImage'])) {


//     $uploadResult = uploadImage($_FILES['profileImage'], 'assets/img/profile/');

//     if (is_string($uploadResult)) {

//         echo $uploadResult;
//     } else {

//         $sqlUpdateImage = "UPDATE customers SET profile_pics=? WHERE user_id=?";
//         $stmtUpdateImage = $conn->prepare($sqlUpdateImage);
//         $stmtUpdateImage->bind_param("si", $uploadResult, $userID);
//         $stmtUpdateImage->execute();
//         $stmtUpdateImage->close();
//     }

//     // Redirect atau tanggapi pengguna sesuai kebutuhan
//     header("Location: " . $_SERVER['PHP_SELF']);
//     exit();
// }



?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" http-equiv="refresh" content="10">
    <link rel="icon" type="image/x-icon" href="<?= base_url() ?>assets/img/atiga-xicon.png">
    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">

    <!-- Feather Icon -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <title>Profil Pengguna</title>

</head>

<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="user-profile">
        <div class="container vh-100" style="padding-top: 200px;">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="title">
                            <h1>Profil</h1>
                        </div>
                        <div class="card-body text-center">
                            <?php foreach ($user as $data) : ?>
                                <div class="user-info">
                                    <form action="" method="post" id="picsForm" enctype="multipart/form-data">
                                        <span class="profileImg">
                                            <label class="form-label btn-upload" for="uploadImg"><i data-feather="camera"></i></label>
                                            <input type="file" id="uploadImg" name="profileImage" class="form-control d-none">
                                            <span class="bg-image">
                                                <img src="<?= base_url() ?>assets/img/profile/<?= $data['profile_pics']; ?>" alt="profile picture - <?= $data['name']; ?>" class="profile-img rounded-circle" style="width: 100px; height: 100px; object-fit: cover; cursor: pointer;" onclick="openProfilePicModal()">
                                            </span>
                                            <div class="modal fade" id="profilePicModal" tabindex="-1" aria-labelledby="profilePicModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="ratio ratio-16x9">
                                                                <img src="<?= base_url() ?>assets/img/profile/<?= $data['profile_pics']; ?>" alt="profile picture - <?= $data['name']; ?>" style="object-fit: contain;">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer btn-group link-light d-flex justify-content-center" data-bs-dismiss="modal" aria-label="Close" role="button">
                                                            <button class="btn-close btn-close-white"></button>Kembali
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </span>
                                    </form>
                                    <div class="data pt-2">
                                        <h3><?php echo $data['name'] ?></h3>
                                        <p>0<?php echo $data['no_telp'] ?></p>
                                        <p><?php echo $data['email'] ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <form method="post">
                                <div class="form-floating mb-3 mt-3">
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $data['name'] ?>">
                                    <label for="name">Nama Anda</label>
                                </div>
                                <div class="form-floating mb-3 mt-3">
                                    <input type="text" class="form-control" id="email" name="email" value="<?php echo $data['email'] ?>">
                                    <label for="email">Email Anda</label>
                                </div>
                                <div class="form-floating mb-3 mt-3">
                                    <input type="tel" class="form-control" id="telp" name="telp" value="<?php echo $data['no_telp'] ?>">
                                    <label for="telp">No. Telepon</label>
                                </div>
                                <div class="form-floating mb-3 mt-3">
                                    <textarea class="form-control" name="alamat" id="alamat" style="height: 100px;"><?php echo $data['address'] ?></textarea>
                                    <label for="alamat">Alamat</label>
                                </div>
                                <button type="submit" name="set" class="btn btn-warning mt-3">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include 'includes/footer.php'; ?>

    <!-- JS -->
    <script src="<?= base_url() ?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/js/functions.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery-3.7.1.min.js"></script>
    <script>
        feather.replace();
    </script>
    <script>
        $(document).ready(function() {
            $("#uploadImg").change(function() {
                var formData = new FormData();
                formData.append("uploadImage", true);
                formData.append("profileImage", $("#uploadImg")[0].files[0]);

                $.ajax({
                    url: "profile_picture.php", // Replace with the actual PHP script handling the upload
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);

                        location.reload();
                    },
                    error: function(error) {
                        // Handle the error
                        console.error(error);
                    }
                });
            });
        });

        function openProfilePicModal() {
            $('#profilePicModal').modal('show');
        }

        function adjustModalSize(img) {
            var modalContent = document.getElementById('dynamicModalContent');
            modalContent.style.width = img.width + 'px';
            modalContent.style.height = img.height + 'px';
        }
    </script>


</body>

</html>