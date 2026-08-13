<?php

require_once "db.php";

$query = "SELECT * FROM products ORDER BY id DESC";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Collection - Aavaiz Perfumes</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>


<!-- =========================
     NAVBAR
========================= -->

<header class="navbar">

    <div class="logo">
        Aavaiz Perfumes
    </div>

    <nav class="nav-links">

        <a href="index.php">Home</a>

        <a href="about.php">About</a>

        <a href="collection.php">Collection</a>

        <a href="cart.php">Cart</a>

        <a href="contact.php">Contact</a>

    </nav>

</header>



<!-- =========================
     COLLECTION
========================= -->

<section class="collection-section">

    <h1 class="collection-title">
        Our Collection
    </h1>

    <p class="collection-subtitle">
        Discover our beautiful collection of perfumes.
    </p>


    <div class="collection-products">


        <?php if ($result && mysqli_num_rows($result) > 0): ?>


            <?php while ($product = mysqli_fetch_assoc($result)): ?>


                <div class="collection-product-card">


                    <!-- IMAGE -->

                    <div class="collection-product-image">

                        <?php

                        $image = trim($product['product_image']);

                        if (!empty($image)):

                        ?>

                            <img
                                src="uploads/<?php echo htmlspecialchars($image); ?>"
                                alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                            >

                        <?php else: ?>

                            <div class="no-image">
                                No Image
                            </div>

                        <?php endif; ?>

                    </div>



                    <!-- INFORMATION -->

                    <div class="collection-product-info">


                        <h2>
                            <?php
                            echo htmlspecialchars($product['product_name']);
                            ?>
                        </h2>


                        <div class="collection-product-price">

                            PKR
                            <?php
                            echo htmlspecialchars($product['product_price']);
                            ?>

                        </div>


                        <div class="collection-product-category">

                            <?php
                            echo htmlspecialchars($product['product_category']);
                            ?>

                        </div>


                        <p class="collection-product-description">

                            <?php
                            echo htmlspecialchars($product['product_description']);
                            ?>

                        </p>


                        <p class="collection-product-quantity">

                            Quantity:
                            <?php
                            echo htmlspecialchars($product['product_quantity']);
                            ?>
                            ml

                        </p>



                        <!-- ADD TO CART -->

                        <form action="cart.php" method="POST">


                            <input
                                type="hidden"
                                name="product_id"
                                value="<?php echo htmlspecialchars($product['id']); ?>"
                            >


                            <input
                                type="hidden"
                                name="product_name"
                                value="<?php echo htmlspecialchars($product['product_name']); ?>"
                            >


                            <input
                                type="hidden"
                                name="product_price"
                                value="<?php echo htmlspecialchars($product['product_price']); ?>"
                            >


                            <input
                                type="hidden"
                                name="product_category"
                                value="<?php echo htmlspecialchars($product['product_category']); ?>"
                            >


                            <input
                                type="hidden"
                                name="product_description"
                                value="<?php echo htmlspecialchars($product['product_description']); ?>"
                            >


                            <input
                                type="hidden"
                                name="product_quantity"
                                value="<?php echo htmlspecialchars($product['product_quantity']); ?>"
                            >


                            <input
                                type="hidden"
                                name="product_image"
                                value="<?php echo htmlspecialchars($product['product_image']); ?>"
                            >


                            <button
                                type="submit"
                                class="add-cart-btn"
                            >
                                Add to Cart
                            </button>


                        </form>


                    </div>


                </div>


            <?php endwhile; ?>


        <?php else: ?>


            <div class="no-products">

                <h2>
                    No Products Available
                </h2>

                <p>
                    Please add products from the Admin Panel.
                </p>

            </div>


        <?php endif; ?>


    </div>

</section>


</body>

</html>