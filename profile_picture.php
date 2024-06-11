<?php
require "includes/config.php";
require "includes/session.php";
require "includes/function.php";
error_reporting(E_ALL);

if (!isset($_SESSION['user_id'])) {
    header("Location: pages/login.php");
    exit();
}

$userID = $_SESSION['user_id'];



// Include your database connection and other necessary functions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['uploadImage'])) {

    $uploadResult = uploadImage($_FILES['profileImage'], 'assets/img/profile/');

    if (is_string($uploadResult)) {
        $sqlUpdateImage = "UPDATE customers SET profile_pics=? WHERE user_id=?";
        $stmtUpdateImage = $conn->prepare($sqlUpdateImage);
        $stmtUpdateImage->bind_param("si", $uploadResult, $userID);
        if ($stmtUpdateImage->execute()) {
            echo "Upload successful";
            exit();
        } else {
            echo "Error updating database: " . mysqli_error($conn);
        }
        $stmtUpdateImage->close();
    } else {
        echo "Error";
    }
}
