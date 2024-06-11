<?php

require 'config.php';

$queryProduct = mysqli_query($conn, "SELECT product_name, image FROM products");

$queryCategory = mysqli_query($conn, "SELECT * FROM categories");
