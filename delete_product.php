<?php

session_start();

if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}

include "../db.php";


if (!isset($_GET["id"])) {
    header("Location: manage_products.php");
    exit();
}


$id = intval($_GET["id"]);


/* GET IMAGE */

$query = "SELECT product_image FROM products WHERE id = ?";

$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$product = mysqli_fetch_assoc($result);


/* DELETE DATABASE RECORD */

$query = "DELETE FROM products WHERE id = ?";

$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);


/* DELETE IMAGE */

if ($product && !empty($product["product_image"])) {

    $image_path = "../uploads/" . $product["product_image"];

    if (file_exists($image_path)) {
        unlink($image_path);
    }
}


header("Location: manage_products.php");
exit();

?>