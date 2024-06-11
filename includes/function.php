<?php

function base_url()
{
    return "http://localhost/atiga/";
}


// AMBIL DATA DARI DATABASE //

function getData($conn, $table)
{
    // Using a prepared statement to avoid SQL injection
    $sql = "SELECT * FROM $table";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Kesalahan dalam persiapan statement: " . $conn->error);
    }

    // Execute the statement
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    if (!$result) {
        die("Kesalahan dalam mendapatkan hasil query: " . $stmt->error);
    }

    // Fetch data as an associative array
    $data = $result->fetch_all(MYSQLI_ASSOC);

    // Close the statement
    $stmt->close();

    return $data;
}


function getProductWithCategory($conn)
{
    $queryProduct = mysqli_query($conn, "SELECT a.*, b.category_name AS category_name FROM products a JOIN categories b ON a.category_id = b.category_id");

    return $queryProduct;
}

// --------------------------- //

// AMBIL DATA PRODUCT BERDASARKAN NAMA //

function getProductByName($conn, $name)
{
    $queryProduct = mysqli_query($conn, "SELECT * FROM products WHERE product_name = '$name'");
    $product = mysqli_fetch_array($queryProduct);

    return $product;
}

function getProductByCategory($conn, $cat)
{
    $queryProduct = mysqli_query($conn, "SELECT a.*, b.category_name AS category_name FROM products a JOIN categories b ON a.category_id = b.category_id WHERE b.category_name = '$cat'");

    return $queryProduct;
}

// --------------------------- //

// AMBIL NAMA TYPE PRODUCT BERDASARKAN ID TYPE PRODUCT //

function getProductTypeName($conn, $type_id)
{
    $typeQuery = mysqli_query($conn, "SELECT type_name FROM product_types WHERE type_id = $type_id");
    $typeData = mysqli_fetch_array($typeQuery);

    if (isset($typeData['type_name'])) {
        return $typeData['type_name'];
    }
    return '';
}

// --------------------------- //

// AMBIL NAMA PRODUCT BERDASARKAN ID PRODUCT //

function getProductName($conn, $product_id)
{
    $query = mysqli_query($conn, "SELECT product_name FROM products WHERE product_id = $product_id");
    $productData = mysqli_fetch_array($query);

    if (isset($productData['product_name'])) {
        return $productData['product_name'];
    }
    return '';
}

// --------------------------- //

function getProductVariations($conn, $product_id)
{
    $query = "SELECT pv.*, pt.type_name
              FROM product_variations pv
              JOIN product_types pt ON pv.type_id = pt.type_id
              WHERE pv.product_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();

    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// FUNCTION TAMPILKAN DAFTAR VARIASI //

function productVariationSelect($conn, $selectedProductId)
{
    $selectedProductId = mysqli_real_escape_string($conn, $selectedProductId);
    $sql = "SELECT pv.variation_id, pt.type_name, pv.price FROM product_variations pv INNER JOIN product_types pt ON pv.type_id = pt.type_id WHERE pv.product_id = $selectedProductId";
    $result = $conn->query($sql);

    return $result;
}

// --------------------------- //

function getUserData($conn, $userID)
{
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}





// CATEGORY FUNCTIONS

// TAMBAH KATEGORI

function addCategory($conn, $kategori)
{
    // Periksa apakah kategori sudah ada
    $queryExist = mysqli_query($conn, "SELECT category_name FROM categories WHERE category_name='$kategori'");
    $jumlahdatakategoribaru = mysqli_num_rows($queryExist);

    if ($jumlahdatakategoribaru > 0) {
        echo '<div class="alert alert-danger position-absolute text-center" style="width: 100%;" role="alert">Nama Kategori sudah ada!</div>';
    } else {
        // Simpan kategori jika belum ada
        $querysimpan = mysqli_query($conn, "INSERT INTO categories(category_name) VALUES ('$kategori')");
        if ($querysimpan) {
            return 'Data berhasil tersimpan';
        }
    }
}

// --------------------------- //

// HAPUS KATEGORI

function deleteCategory($conn, $id)
{
    // PERIKSA APAKAH ADA PRODUCT YANG TERKAIT DENGAN KATEGORI YANG INGIN DIHAPUS
    $querycheck = mysqli_query($conn, "SELECT * FROM products WHERE category_id='$id'");

    if ($querycheck) {
        // JIKA QUERY BERHASIL DIJALANKAN, PERIKSA APAKAH ADA PRODUCT YANG TERKAIT
        $dataCount = mysqli_num_rows($querycheck);

        if ($dataCount > 0) {
            return "Data tidak bisa dihapus";
        } else {
            // HAPUS KATEGORI JIKA TIDAK ADA PRODUCT YANG TERKAIT
            $querydelete = mysqli_query($conn, "DELETE FROM categories WHERE category_id='$id'");
            if ($querydelete) {
                return "Data dihapus";
            } else {
                return "Terjadi kesalahan saat menghapus data";
            }
        }
    } else {
        return "Terjadi kesalahan saat menghapus data";
    }
}

// --------------------------- //

// MODIFIKASI KATEGORI

function editCategory($conn, $id, $newCategoryName)
{
    // CHECK APAKAH NAMA KATEGORI SUDAH ADA
    $queryExist = mysqli_query($conn, "SELECT category_name FROM categories WHERE category_name='$newCategoryName'");
    $jumlahdatakategoribaru = mysqli_num_rows($queryExist);

    if ($jumlahdatakategoribaru > 0) {
        return 'Nama Kategori sudah ada!';
    } else {
        // UPDATE NAMA KATEGORI
        $queryEdit = mysqli_query($conn, "UPDATE categories SET category_name='$newCategoryName' WHERE category_id='$id'");

        if ($queryEdit) {
            return 'Data berhasil diubah';
        } else {
            return 'Terjadi kesalahan saat mengubah data';
        }
    }
}

// --------------------------- //






// PRODUCT FUNCTIONS

// MERUBAH NAMA ASLI FILE
function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// --------------------------- //

// UPLOAD GAMBAR DAN VALIDASI KESESUAIAN GAMBAR DENGAN KETENTUAN YANG BERLAKU

function uploadImage($imageFile, $target_directory)
{
    $target_dir = $target_directory;
    $nama_file = basename($imageFile['name']);
    $target_file = $target_dir . $nama_file;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $image_size = $imageFile['size'];

    $new_name = generateRandomString() . '.' . $imageFileType;

    if ($image_size > 100000000) {
        return 'File tidak boleh lebih dari 100MB';
    } elseif (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'pdf'])) {
        return 'File harus dalam format JPG, PNG, atau JPEG';
    } else {
        if (move_uploaded_file($imageFile['tmp_name'], $target_dir . $new_name)) {
            return $new_name; // MENGEMBALIKAN NAMA BARU FILE GAMBAR DARI DATABASE 
        } else {
            return 'Terjadi kesalahan saat mengunggah file';
        }
    }
}

// --------------------------- //

// Fungsi untuk mengambil data pengiriman
function getDeliverys($conn) {
    $query = "SELECT * FROM deliverys";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query error: " . mysqli_error($conn));
    }

    $deliveryData = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $deliveryData[] = $row;
    }

    return $deliveryData;
}

// Fungsi untuk mengambil riwayat pengiriman
function getDeliverysHistorys($conn) {
    $query = "SELECT * FROM deliverys_history";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query error: " . mysqli_error($conn));
    }

    $deliveryHistoryData = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $deliveryHistoryData[] = $row;
    }

    return $deliveryHistoryData;
}
// TAMBAH PRODUCT 

function addProduct($conn, $kategori, $nama, $image, $detail)
{
    $querytambah = mysqli_query($conn, "INSERT INTO products (category_id, product_name, image, description) VALUES ('$kategori', '$nama', '$image', '$detail')");

    if ($querytambah) {
        return 'Data disimpan';
    } else {
        return 'Terjadi kesalahan saat menyimpan data';
    }
}

// --------------------------- //

// HAPUS PRODUCT

function deleteProduct($conn, $id)
{
    $sql = mysqli_query($conn, "SELECT variation_id FROM product_variations WHERE product_id='$id'");
    $variations = mysqli_fetch_array($sql);
    $variationID = ($variations) ? $variations[0] : null;

    $deleteVariationPricing = mysqli_query($conn, "DELETE FROM variation_pricing WHERE variation_id='$variationID'");

    $deleteVariation = mysqli_query($conn, "DELETE FROM product_variations WHERE product_id='$id'");

    if ($deleteVariation && $deleteVariationPricing) {

        $deleteProduct = mysqli_query($conn, "DELETE FROM products WHERE product_id='$id'");

        if ($deleteProduct) {
            return true;
        } else {
            return false;
        }
    } else {
        echo "Terjadi Kesalahan";
    }
}

// --------------------------- //

// MODIFIKASI PRODUCT

function editProduct($conn, $id, $category_id, $product_name, $image, $description)
{
    $query = mysqli_query($conn, "UPDATE products SET category_id='$category_id', product_name='$product_name', image='$image', description='$description' WHERE product_id='$id'");
    if ($query) {
        return true;
    } else {
        return false;
    }
}

// --------------------------- //




// FUNCTION VARIATIONS //

// TAMBAH VARIASI // 

function addVariation($conn, $product_id, $type_product, $harga)
{
    $product_id = mysqli_real_escape_string($conn, $product_id);
    $type_product = mysqli_real_escape_string($conn, $type_product);
    $harga = mysqli_real_escape_string($conn, $harga);

    // Cek apakah type_product sudah ada di tabel product_types
    $checkTypeQuery = "SELECT type_id FROM product_types WHERE type_name = '$type_product'";
    $typeResult = mysqli_query($conn, $checkTypeQuery);

    if (!$typeResult) {
        return "Error: " . mysqli_error($conn);
    }

    // Jika type_product tidak ditemukan dalam tabel product_types, tambahkan jenis produk baru
    if (mysqli_num_rows($typeResult) == 0) {
        $addTypeQuery = "INSERT INTO product_types (type_name) VALUES ('$type_product')";
        if (mysqli_query($conn, $addTypeQuery)) {
            // Dapatkan type_id yang baru saja ditambahkan
            $type_id = mysqli_insert_id($conn);
        } else {
            return "Error: " . mysqli_error($conn);
        }
    } else {
        $typeData = mysqli_fetch_assoc($typeResult);
        $type_id = $typeData['type_id'];
    }

    // Lakukan kueri SQL untuk memasukkan data variasi produk
    $query = "INSERT INTO product_variations (product_id, type_id, price) VALUES ('$product_id', '$type_id', '$harga')";

    // Jalankan kueri SQL
    if (mysqli_query($conn, $query)) {
        return true;
    } else {
        return "Error: " . mysqli_error($conn);
    }
}

// --------------------------- //

// HAPUS VARIASI //

function deleteVariation($conn, $variation_id)
{
    // First, retrieve the product type associated with the variation
    $query = mysqli_query($conn, "SELECT type_id FROM product_variations WHERE variation_id='$variation_id'");

    if ($query) {
        $row = mysqli_fetch_assoc($query);
        $type_id = $row['type_id'];

        // Next, delete the variation
        $deleteVariationQuery = mysqli_query($conn, "DELETE FROM product_variations WHERE variation_id='$variation_id'");

        // Then, delete the related product type
        $deleteTypeQuery = mysqli_query($conn, "DELETE FROM product_types WHERE type_id='$type_id'");

        if ($deleteVariationQuery && $deleteTypeQuery) {
            return true;
        } else {
            return 'Data Gagal dihapus';
        }
    }
}

// --------------------------- //

// PRICING //

function addVariationPricing($conn, $variation_id, $min_quantity, $max_quantity, $price)
{
    $sql = "INSERT INTO variation_pricing (variation_id, min_quantity, max_quantity, price) VALUES ('$variation_id', '$min_quantity', '$max_quantity', '$price')";
    $queryPricing = $conn->query($sql);
    if ($queryPricing) {
        return true;
    } else {
        return false;
    }
}


// Function to update a variation_pricing record
function updatePricing($conn, $pricing_id, $min_quantity, $max_quantity, $price)
{
    $sql = "UPDATE variation_pricing SET min_quantity='$min_quantity', max_quantity='$max_quantity', price='$price' WHERE pricing_id=$pricing_id";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil diperbarui";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Function to delete a variation_pricing record
function deletePricing($conn, $pricing_id)
{
    $sql = "DELETE FROM variation_pricing WHERE pricing_id=$pricing_id";

    if ($conn->query($sql) === TRUE) {
        echo "Data Berhasil dihapus";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}


function fetchProductVariationsAndPricing($conn, $productId)
{
    $variations = [];
    $pricingData = [];

    // Fetch variations for the product
    $productvarian = productVariationSelect($conn, $productId);

    if ($productvarian->num_rows > 0) {
        while ($row = $productvarian->fetch_assoc()) {
            $variations[$row['variation_id']] = [
                'type_name' => $row['type_name'],
                'price' => $row['price']
            ];
        }

        // Fetch pricing data for each variation
        foreach ($variations as $variationId => $variation) {
            $pricingData[$variationId] = fetchPricingData($conn, $variationId);
        }
    }

    return [
        'variations' => $variations,
        'pricingData' => $pricingData
    ];
}

function fetchPricingData($conn, $variationId)
{
    $pricingData = [];
    $sql = "SELECT min_quantity, max_quantity, price FROM variation_pricing WHERE variation_id = $variationId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pricingData[] = [
                'min_quantity' => $row['min_quantity'],
                'max_quantity' => $row['max_quantity'],
                'price' => $row['price']
            ];
        }
    }

    return $pricingData;
}

// CART


// includes/function.php

function addToCart($conn, $user_id, $product_id, $variation_id, $length, $width, $quantity, $keterangan, $designFile, $totalHarga)
{
    $query = "INSERT INTO cart (user_id, product_id, variation_id, length, width, quantity, keterangan, design_file, total_price)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);


    $stmt->bind_param("iiisssssi", $user_id, $product_id, $variation_id, $length, $width, $quantity, $keterangan, $designFile, $totalHarga);


    $result = $stmt->execute();

    if (!$result) {
        die("Error: " . $stmt->error);
    }

    return $result;
}



// Add this function in your includes/function.php file

function getCartItems($conn, $user_id)
{
    $query = "SELECT p.product_name, pt.type_name, pv.price, c.*
              FROM cart c
              JOIN product_variations pv ON c.variation_id = pv.variation_id
              JOIN products p ON pv.product_id = p.product_id
              JOIN product_types pt ON pv.type_id = pt.type_id
              WHERE c.user_id = ?"; // Using '?' as a placeholder for user_id

    $stmt = $conn->prepare($query);

    // Bind the user_id parameter
    $stmt->bind_param('i', $user_id); // Assuming user_id is an integer
    $stmt->execute();

    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}



function deleteItemCart($conn, $cart_id)
{
    $query = "DELETE FROM cart WHERE cart_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $cart_id);
    $stmt->execute();

    // Tambahkan penanganan kesalahan
    if ($stmt->affected_rows > 0) {
        $stmt->close();
        return true; // Berhasil dihapus
    } else {
        $stmt->close();
        return false; // Gagal dihapus
    }
}




function saveOrder($conn, $user_id, $cartItems, $totalPrice)
{
    $defaultStatusId = 1; // Misalnya, status "Dalam Proses"
    $queryOrder = "INSERT INTO orders (user_id, total_amount, order_date, status_id) VALUES (?, ?, NOW(), ?)";
    $stmtOrder = $conn->prepare($queryOrder);
    $stmtOrder->bind_param('idi', $user_id, $totalPrice, $defaultStatusId);
    $stmtOrder->execute();

    $orderId = $stmtOrder->insert_id;

    // Simpan setiap item pesanan ke dalam tabel 'order_items'
    $queryOrderItem = "INSERT INTO order_items (order_id, product_id, variation_id, quantity, price, design_file) VALUES (?, ?, ?, ?, ?, ?)";
    $stmtOrderItem = $conn->prepare($queryOrderItem);

    foreach ($cartItems as $cartItem) {
        $stmtOrderItem->bind_param(
            'iiidds',
            $orderId,
            $cartItem['product_id'],
            $cartItem['variation_id'],
            $cartItem['quantity'],
            $cartItem['total_price'],
            $cartItem['design_file']
        );
        $stmtOrderItem->execute();
    }

    // Tutup statement
    $stmtOrder->close();
    $stmtOrderItem->close();

    // Hapus semua item dari keranjang berdasarkan user_id
    clearCart($conn, $user_id);
}


function clearCart($conn, $user_id)
{
    // Hapus semua item dari keranjang berdasarkan user_id
    $query = "DELETE FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->close();
}

function processOrder($conn, $user_id, $cartItems)
{
    // Hitung total harga pesanan
    $totalPrice = calculateTotalPrice($cartItems);

    // Simpan detail pesanan ke dalam database
    saveOrder($conn, $user_id, $cartItems, $totalPrice);

    // Lakukan tindakan lain seperti pemotongan stok, verifikasi pembayaran, dll.
}


function calculateTotalPrice($cartItems)
{
    $totalPrice = 0;

    foreach ($cartItems as $cartItem) {
        // Hitung total harga per item
        $itemPrice = $cartItem['total_price'];
        $totalPrice += $itemPrice;
    }

    return $totalPrice;
}


function getOrder($conn)
{
    $query = "SELECT o.*, oi.quantity AS quantity, oi.design_file AS design, p.product_name, pv.price, pt.type_name AS variation_name, os.status_name, c.name AS customer_name, c.address AS customer_address, u.username
              FROM orders o
              JOIN order_items oi ON o.order_id = oi.order_id
              JOIN products p ON oi.product_id = p.product_id
              JOIN product_variations pv ON oi.variation_id = pv.variation_id
              JOIN product_types pt ON pv.type_id = pt.type_id
              JOIN order_statuses os ON o.status_id = os.status_id
              JOIN customers c ON o.user_id = c.user_id
              JOIN users u ON c.user_id = u.user_id
              WHERE o.status_id != 4 AND o.status_id != 6";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function getOrderHistory($conn)
{
    $query = "SELECT o.*, oi.quantity AS quantity, oi.design_file AS design, p.product_name, pv.price, pt.type_name AS variation_name, os.status_name, c.name AS customer_name, c.address AS customer_address, u.username
              FROM orders o
              JOIN order_items oi ON o.order_id = oi.order_id
              JOIN products p ON oi.product_id = p.product_id
              JOIN product_variations pv ON oi.variation_id = pv.variation_id
              JOIN product_types pt ON pv.type_id = pt.type_id
              JOIN order_statuses os ON o.status_id = os.status_id
              JOIN customers c ON o.user_id = c.user_id
              JOIN users u ON c.user_id = u.user_id
              WHERE o.status_id = 4 OR o.status_id = 6";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}


function getProcessingOrdersDetails($conn, $user_id)
{
    $query = "SELECT o.*, oi.quantity AS quantity, oi.price AS total, p.product_name, pv.price, pt.type_name AS variation_name, os.status_name
              FROM orders o
              JOIN order_items oi ON o.order_id = oi.order_id
              JOIN products p ON oi.product_id = p.product_id
              JOIN product_variations pv ON oi.variation_id = pv.variation_id
              JOIN product_types pt ON pv.type_id = pt.type_id
              JOIN order_statuses os ON o.status_id = os.status_id
              WHERE o.user_id = ? ORDER BY o.order_id desc";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();

    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}


// Fungsi untuk mendapatkan harga berdasarkan quantity
function calculateProductPrice($conn, $variationId, $quantity)
{
    $price = 0;

    $sql = "SELECT price FROM variation_pricing WHERE variation_id = ? 
            AND min_quantity <= ? AND max_quantity >= ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $variationId, $quantity, $quantity);
    $stmt->execute();
    $stmt->bind_result($price);

    if ($stmt->fetch()) {
        $stmt->close();

        return $price;
    }


    $stmt->close();


    $normalPrice = getNormalPrice($conn, $variationId);
    return $normalPrice;
}

function getNormalPrice($conn, $variationId)
{
    $sql = "SELECT price FROM product_variations WHERE variation_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $variationId);
    $stmt->execute();

    // Inisialisasi $normalPrice sebelum menggunakan
    $normalPrice = 0;

    // Bind result setelah execute
    $stmt->bind_result($normalPrice);

    // Ambil nilai jika query mengembalikan hasil
    if ($stmt->fetch()) {
        $stmt->close();
    } else {
        $stmt->close();
    }

    return $normalPrice;
}


// Fungsi untuk mendapatkan harga berdasarkan quantity
function calculateBannerPrice($conn, $variationId, $quantity)
{
    $price = 0;

    $sql = "SELECT price FROM variation_pricing WHERE variation_id = ? 
            AND min_quantity <= ? AND max_quantity >= ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $variationId, $quantity, $quantity);
    $stmt->execute();
    $stmt->bind_result($price);

    if ($stmt->fetch()) {
        $stmt->close();

        return $price;
    }


    $stmt->close();


    $normalPrice = getNormalPrice($conn, $variationId);
    return $normalPrice;
}
