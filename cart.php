<?php

session_start();


// =========================
// CREATE CART
// =========================

if (!isset($_SESSION['cart'])) {

    $_SESSION['cart'] = [];

}


// =========================
// ADD TO CART
// =========================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $product = [

        'id' => $_POST['product_id'] ?? '',

        'name' => $_POST['product_name'] ?? '',

        'price' => $_POST['product_price'] ?? '',

        'category' => $_POST['product_category'] ?? '',

        'description' => $_POST['product_description'] ?? '',

        'quantity' => $_POST['product_quantity'] ?? '',

        'image' => $_POST['product_image'] ?? ''

    ];


    $_SESSION['cart'][] = $product;


    header("Location: cart.php");

    exit;

}


// =========================
// REMOVE PRODUCT
// =========================

if (isset($_GET['remove'])) {


    $index = (int) $_GET['remove'];


    if (isset($_SESSION['cart'][$index])) {


        unset($_SESSION['cart'][$index]);


        $_SESSION['cart'] = array_values($_SESSION['cart']);

    }


    header("Location: cart.php");

    exit;

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

    <title>
        Cart - Aavaiz Perfumes
    </title>


    <link
        rel="stylesheet"
        href="style.css"
    >

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


        <a href="index.php">
            Home
        </a>


        <a href="about.php">
            About
        </a>


        <a href="collection.php">
            Collection
        </a>


        <a href="cart.php">
            Cart
        </a>


        <a href="contact.php">
            Contact
        </a>


    </nav>


</header>



<!-- =========================
     CART
========================= -->

<section class="cart-section">


    <h1 class="cart-title">

        Your Cart

    </h1>



    <?php if (!empty($_SESSION['cart'])): ?>


        <div class="cart-products">


            <?php foreach ($_SESSION['cart'] as $index => $item): ?>


                <div class="cart-product">


                    <!-- IMAGE -->

                    <div class="cart-product-image">


                        <?php if (!empty($item['image'])): ?>


                            <img
                                src="uploads/<?php echo htmlspecialchars($item['image']); ?>"
                                alt="<?php echo htmlspecialchars($item['name']); ?>"
                            >


                        <?php else: ?>


                            <div class="no-image">

                                No Image

                            </div>


                        <?php endif; ?>


                    </div>



                    <!-- DETAILS -->

                    <div class="cart-product-details">


                        <h2>

                            <?php
                            echo htmlspecialchars($item['name']);
                            ?>

                        </h2>



                        <p class="cart-price">

                            Price:
                            PKR
                            <?php
                            echo htmlspecialchars($item['price']);
                            ?>

                        </p>



                        <p>

                            <strong>
                                Category:
                            </strong>

                            <?php
                            echo htmlspecialchars($item['category']);
                            ?>

                        </p>



                        <p>

                            <strong>
                                Description:
                            </strong>

                            <?php
                            echo htmlspecialchars($item['description']);
                            ?>

                        </p>



                        <p>

                            <strong>
                                Quantity:
                            </strong>

                            <?php
                            echo htmlspecialchars($item['quantity']);
                            ?>

                            ml

                        </p>



                        <!-- REMOVE BUTTON -->

                        <a
                            href="cart.php?remove=<?php echo $index; ?>"
                            class="remove-cart-btn"
                        >

                            Remove

                        </a>


                    </div>


                </div>


            <?php endforeach; ?>


        </div>


    <?php else: ?>


        <div class="empty-cart">


            <h2>

                Your Cart is Empty

            </h2>


            <p>

                Please add a product from our collection.

            </p>


            <a
                href="collection.php"
                class="cart-collection-btn"
            >

                View Collection

            </a>


        </div>


    <?php endif; ?>


</section>


</body>

</html>