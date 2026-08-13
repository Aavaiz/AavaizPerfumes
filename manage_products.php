<?php

session_start();

if (!isset($_SESSION["admin"])) {

    header("Location: login.php");

    exit();

}

include "../db.php";


$query = "SELECT * FROM products ORDER BY id DESC";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Products - Aavaiz Perfumes</title>

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



<main class="admin-container">


    <div class="page-heading">


        <h1>
            Manage Products
        </h1>


        <a
            href="add_product.php"
            class="add-button">

            + Add Product

        </a>


    </div>



    <div class="table-container">


        <table>


            <thead>

                <tr>

                    <th>ID</th>

                    <th>Image</th>

                    <th>Name</th>

                    <th>Price</th>

                    <th>Quantity</th>

                    <th>Category</th>

                    <th>Actions</th>

                </tr>

            </thead>



            <tbody>


            <?php if (mysqli_num_rows($result) > 0): ?>


                <?php while ($product = mysqli_fetch_assoc($result)): ?>


                    <tr>


                        <td>
                            <?php echo $product["id"]; ?>
                        </td>


                        <td>

                            <?php if (!empty($product["product_image"])): ?>

                                <img
                                    src="../uploads/<?php echo htmlspecialchars($product["product_image"]); ?>"
                                    class="product-image"
                                    alt="Product">

                            <?php else: ?>

                                No Image

                            <?php endif; ?>

                        </td>


                        <td>
                            <?php echo htmlspecialchars($product["product_name"]); ?>
                        </td>


                        <td>
                            Rs.
                            <?php echo number_format($product["product_price"], 2); ?>
                        </td>


                        <td>
                            <?php echo $product["product_quantity"]; ?>
                        </td>


                        <td>
                            <?php echo htmlspecialchars($product["product_category"]); ?>
                        </td>


                        <td>


                            <a
                                href="edit_product.php?id=<?php echo $product["id"]; ?>"
                                class="edit-button">

                                Edit

                            </a>


                            <a
                                href="delete_product.php?id=<?php echo $product["id"]; ?>"
                                class="delete-button"
                                onclick="return confirm('Are you sure you want to delete this product?');">

                                Delete

                            </a>


                        </td>


                    </tr>


                <?php endwhile; ?>


            <?php else: ?>


                <tr>

                    <td
                        colspan="7"
                        style="text-align:center; padding:30px;">

                        No products added yet.

                    </td>

                </tr>


            <?php endif; ?>


            </tbody>


        </table>


    </div>


</main>


</body>

</html>
