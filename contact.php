<?php

include "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $user_message = trim($_POST["message"]);

    if ($name != "" && $email != "" && $user_message != "") {

        $stmt = $conn->prepare(
            "INSERT INTO contacts (name, email, message)
             VALUES (?, ?, ?)"
        );

        $stmt->bind_param(
            "sss",
            $name,
            $email,
            $user_message
        );

        if ($stmt->execute()) {
            $message = "Thank you! Your message has been sent successfully.";
        } else {
            $message = "Something went wrong. Please try again.";
        }

        $stmt->close();

    } else {

        $message = "Please fill all fields.";

    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Aavaiz Fragrances - Contact</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>


<!-- NAVBAR -->

<nav class="navbar">

    <div class="logo">
        Aavaiz Fragrances
    </div>

    <div class="nav-links">

        <a href="index.php">Home</a>

        <a href="about.php">About</a>

        <a href="collection.php">Collection</a>

        <a href="cart.php">Cart</a>

        <a href="contact.php">Contact</a>

    </div>

</nav>


<!-- CONTACT INFORMATION -->

<div class="contact-info">

    <h1>
        Get In Touch
    </h1>

    <p>
        Have a question about our fragrances?
        We would love to hear from you.
        Send us a message and our team will
        get back to you.
    </p>

</div>


<!-- CONTACT FORM -->

<form
    method="POST"
    class="contact-form"
>

    <h2>
        Send Us a Message
    </h2>


    <?php if ($message != "") { ?>

        <p class="message">

            <?php echo htmlspecialchars($message); ?>

        </p>

    <?php } ?>


    <input
        type="text"
        name="name"
        placeholder="Your Name"
        required
    >


    <input
        type="email"
        name="email"
        placeholder="Your Email"
        required
    >


    <textarea
        name="message"
        placeholder="Write your message..."
        required
    ></textarea>


    <button type="submit">
        Send Message
    </button>

</form>


<!-- FOOTER -->

<footer class="footer">

    <p>
        &copy; 2026 Aavaiz Fragrances. All Rights Reserved.
    </p>

</footer>

</body>

</html>