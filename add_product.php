<?php

session_start();

include "../db.php";


/* =========================
   CHECK LOGIN
========================= */

if (!isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}


/* =========================
   VARIABLES
========================= */

$message = "";
$error = "";


/* =========================
   ADD PRODUCT
========================= */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $product_name = trim($_POST["product_name"]);
    $product_price = $_POST["product_price"];
    $product_quantity = $_POST["product_quantity"];
    $product_category = $_POST["product_category"];
    $product_description = trim($_POST["product_description"]);


    /* =========================
       IMAGE CHECK
    ========================= */

    if (!isset($_FILES["product_image"]) || $_FILES["product_image"]["error"] != 0) {

        $error = "Please select a product image.";

    } else {

        $image_name = $_FILES["product_image"]["name"];
        $image_tmp = $_FILES["product_image"]["tmp_name"];
        $image_size = $_FILES["product_image"]["size"];


        /* GET FILE EXTENSION */

        $image_extension = strtolower(
            pathinfo($image_name, PATHINFO_EXTENSION)
        );


        /* ALLOWED EXTENSIONS */

        $allowed_extensions = array(
            "jpg",
            "jpeg",
            "png",
            "webp"
        );


        /* CHECK EXTENSION */

        if (!in_array($image_extension, $allowed_extensions)) {

            $error = "Only JPG, JPEG, PNG and WEBP images are allowed.";

        }


        /* CHECK SIZE */

        elseif ($image_size > 5 * 1024 * 1024) {

            $error = "Image size must be less than 5MB.";

        }


        else {

            /* =========================
               CREATE UNIQUE IMAGE NAME
            ========================= */

            $new_image_name =
                time() . "_" .
                uniqid() . "." .
                $image_extension;


            /* =========================
               UPLOAD FOLDER
            ========================= */

            $upload_folder = "../uploads/";


            /* CREATE FOLDER IF NOT EXISTS */

            if (!is_dir($upload_folder)) {

                mkdir($upload_folder, 0777, true);

            }


            /* COMPLETE IMAGE PATH */

            $image_path =
                $upload_folder . $new_image_name;


            /* =========================
               MOVE IMAGE
            ========================= */

            if (move_uploaded_file($image_tmp, $image_path)) {


                /* =========================
                   INSERT PRODUCT
                ========================= */

                $sql = "INSERT INTO products
                (
                    product_name,
                    product_price,
                    product_quantity,
                    product_category,
                    product_description,
                    product_image
                )
                VALUES (?, ?, ?, ?, ?, ?)";


                $stmt = mysqli_prepare($conn, $sql);


                if ($stmt) {

                    mysqli_stmt_bind_param(
                        $stmt,
                        "sdisss",
                        $product_name,
                        $product_price,
                        $product_quantity,
                        $product_category,
                        $product_description,
                        $new_image_name
                    );


                    if (mysqli_stmt_execute($stmt)) {

                        $message = "Product added successfully!";

                    } else {

                        $error =
                            "Product could not be added: " .
                            mysqli_error($conn);

                        /* DELETE UPLOADED IMAGE */

                        if (file_exists($image_path)) {

                            unlink($image_path);

                        }

                    }


                    mysqli_stmt_close($stmt);

                } else {

                    $error =
                        "Database error: " .
                        mysqli_error($conn);

                }

            } else {

                $error =
                    "Image could not be uploaded. Please check the uploads folder.";

            }

        }

    }

}

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Add Product - Aavaiz Perfumes</title>

    <link rel="stylesheet" href="admin.css">

</head>


<body>


<!-- =========================
     NAVBAR
========================= -->

<header class="admin-navbar">

    <div class="admin-logo">
        Aavaiz Perfumes
    </div>


    <nav class="admin-nav-links">

        <a href="admin.php">
            Dashboard
        </a>

        <a href="manage_products.php">
            Products
        </a>

        <a href="add_product.php">
            Add Product
        </a>

        <a href="logout.php">
            Logout
        </a>

    </nav>

</header>



<!-- =========================
     FORM
========================= -->

<main class="form-container">


    <h1>
        Add Product
    </h1>


    <?php if ($message != ""): ?>

        <div class="success-message">

            <?php echo htmlspecialchars($message); ?>

        </div>

    <?php endif; ?>


    <?php if ($error != ""): ?>

        <div class="error">

            <?php echo htmlspecialchars($error); ?>

        </div>

    <?php endif; ?>


    <form
        method="POST"
        enctype="multipart/form-data"
    >


        <!-- PRODUCT NAME -->

        <label>
            Product Name
        </label>

        <input
            type="text"
            name="product_name"
            placeholder="Enter product name"
            required
        >


        <!-- PRICE -->

        <label>
            Price (PKR)
        </label>

        <input
            type="number"
            name="product_price"
            placeholder="Enter price"
            min="0"
            step="0.01"
            required
        >


        <!-- QUANTITY -->

        <label>
            Quantity (ml)
        </label>

        <input
            type="number"
            name="product_quantity"
            placeholder="Example: 50"
            min="1"
            required
        >


        <!-- CATEGORY -->

        <label>
            Category
        </label>

        <select
            name="product_category"
            required
        >

            <option value="">
                Select Category
            </option>

            <option value="Men">
                Men
            </option>

            <option value="Women">
                Women
            </option>

            <option value="Children">
                Children
            </option>

        </select>


        <!-- DESCRIPTION -->

        <label>
            Product Description
        </label>

        <textarea
            name="product_description"
            placeholder="Enter product description"
        ></textarea>


        <!-- IMAGE -->

        <label>
            Product Image
        </label>

        <input
            type="file"
            name="product_image"
            accept=".jpg,.jpeg,.png,.webp"
            required
        >


        <!-- BUTTON -->

        <button type="submit">
            Add Product
        </button>


        <!-- CANCEL -->

        <a
            href="manage_products.php"
            class="cancel-button"
        >
            Cancel
        </a>


    </form>


</main>


</body>

</html>
