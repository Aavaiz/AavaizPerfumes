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


$query = "SELECT * FROM products WHERE id = ?";

$stmt = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$product = mysqli_fetch_assoc($result);


if (!$product) {
    header("Location: manage_products.php");
    exit();
}


$error = "";
$message = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $product_name = trim($_POST["product_name"]);
    $product_price = $_POST["product_price"];
    $product_quantity = $_POST["product_quantity"];
    $product_category = trim($_POST["product_category"]);
    $product_description = trim($_POST["product_description"]);

    $product_image = $product["product_image"];


    /* NEW IMAGE */

    if (isset($_FILES["product_image"]) && $_FILES["product_image"]["error"] == 0) {

        $image_name = $_FILES["product_image"]["name"];
        $image_tmp = $_FILES["product_image"]["tmp_name"];

        $extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        $allowed_extensions = ["jpg", "jpeg", "png", "webp"];


        if (!in_array($extension, $allowed_extensions)) {

            $error = "Only JPG, JPEG, PNG and WEBP images are allowed.";

        } else {

            $new_image = time() . "_" . basename($image_name);

            $upload_path = "../uploads/" . $new_image;


            if (move_uploaded_file($image_tmp, $upload_path)) {

                if (!empty($product["product_image"])) {

                    $old_image = "../uploads/" . $product["product_image"];

                    if (file_exists($old_image)) {
                        unlink($old_image);
                    }

                }

                $product_image = $new_image;

            } else {

                $error = "Image upload failed.";

            }

        }
    }


    if ($error == "") {

        $sql = "UPDATE products SET
                product_name = ?,
                product_price = ?,
                product_quantity = ?,
                product_category = ?,
                product_description = ?,
                product_image = ?
                WHERE id = ?";


        $stmt = mysqli_prepare($conn, $sql);


        mysqli_stmt_bind_param(
            $stmt,
            "sdisssi",
            $product_name,
            $product_price,
            $product_quantity,
            $product_category,
            $product_description,
            $product_image,
            $id
        );


        if (mysqli_stmt_execute($stmt)) {

            header("Location: manage_products.php");
            exit();

        } else {

            $error = "Product could not be updated.";

        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Product - Aavaiz Perfumes</title>

    <link rel="stylesheet" href="admin.css">

</head>


<body>


<header class="admin-navbar">

    <div class="admin-logo">
        Aavaiz Perfumes
    </div>

    <nav class="admin-nav-links">

        <a href="admin.php">Dashboard</a>

        <a href="manage_products.php">Products</a>

        <a href="add_product.php">Add Product</a>

        <a href="logout.php">Logout</a>

    </nav>

</header>



<div class="form-container">

    <h1>Edit Product</h1>


    <?php if ($error != ""): ?>

        <div class="error">
            <?php echo $error; ?>
        </div>

    <?php endif; ?>


    <?php if (!empty($product["product_image"])): ?>

        <img
            src="../uploads/<?php echo htmlspecialchars($product["product_image"]); ?>"
            class="edit-image"
            alt="Product Image">

    <?php endif; ?>


    <form method="POST" enctype="multipart/form-data">


        <label>
            Product Name
        </label>

        <input
            type="text"
            name="product_name"
            value="<?php echo htmlspecialchars($product["product_name"]); ?>"
            required>



        <label>
            Price (PKR)
        </label>

        <input
            type="number"
            name="product_price"
            value="<?php echo $product["product_price"]; ?>"
            min="0"
            step="0.01"
            required>



        <label>
            Quantity
        </label>

        <input
            type="number"
            name="product_quantity"
            value="<?php echo $product["product_quantity"]; ?>"
            min="0"
            required>



        <label>
            Category
        </label>

        <select name="product_category" required>

            <option value="Men"
                <?php if ($product["product_category"] == "Men") echo "selected"; ?>>
                Men
            </option>

            <option value="Women"
                <?php if ($product["product_category"] == "Women") echo "selected"; ?>>
                Women
            </option>

            <option value="Children"
                <?php if ($product["product_category"] == "Children") echo "selected"; ?>>
                Children
            </option>

        </select>



        <label>
            Product Description
        </label>

        <textarea
            name="product_description"><?php echo htmlspecialchars($product["product_description"]); ?></textarea>



        <label>
            Change Product Image
        </label>

        <input
            type="file"
            name="product_image"
            accept=".jpg,.jpeg,.png,.webp">



        <button type="submit">
            Update Product
        </button>


        <a
            href="manage_products.php"
            class="cancel-button">
            Cancel
        </a>


    </form>

</div>


</body>
</html>