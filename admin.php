<?php

session_start();

if (!isset($_SESSION["admin"])) {

    header("Location: login.php");

    exit();

}

include "../db.php";


$query = "SELECT COUNT(*) AS total FROM products";

$result = mysqli_query($conn, $query);

$data = mysqli_fetch_assoc($result);

$total_products = $data["total"];

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard - Aavaiz Perfumes</title>

    <link rel="stylesheet" href="admin.css">

</head>


<body>


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



<main class="dashboard-container">


    <h1>
        Admin Dashboard
    </h1>


    <p class="welcome">
        Welcome, <?php echo htmlspecialchars($_SESSION["admin"]); ?>!
    </p>



    <div class="dashboard-cards">


        <!-- PRODUCTS -->

        <div class="dashboard-card">

            <h3>
                Products
            </h3>


            <div class="dashboard-number">

                <?php echo $total_products; ?>

            </div>


            <p>
                Total products available in your store.
            </p>


            <a
                href="manage_products.php"
                class="dashboard-button">

                Manage Products

            </a>

        </div>



        <!-- ADD PRODUCT -->

        <div class="dashboard-card">

            <h3>
                Add Product
            </h3>


            <p>
                Add a new perfume product to your collection.
            </p>


            <a
                href="add_product.php"
                class="dashboard-button">

                Add Product

            </a>

        </div>



        <!-- ADMIN -->

        <div class="dashboard-card">

            <h3>
                Admin Account
            </h3>


            <p>
                You are logged in as an administrator.
            </p>


            <a
                href="logout.php"
                class="dashboard-button">

                Logout

            </a>

        </div>

    </div>



    <!-- QUICK ACTIONS -->

    <div class="quick-actions">

        <a href="manage_products.php">
            Manage Products
        </a>


        <a href="add_product.php">
            Add New Product
        </a>

    </div>


</main>


</body>

</html>
