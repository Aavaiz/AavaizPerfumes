<?php

session_start();

include "../db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM admin WHERE username = ? LIMIT 1";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $username);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);


    if (mysqli_num_rows($result) == 1) {

        $admin = mysqli_fetch_assoc($result);


        if ($password === $admin["password"]) {

            $_SESSION["admin"] = $admin["username"];

            header("Location: admin.php");

            exit();

        } else {

            $error = "Incorrect password.";

        }

    } else {

        $error = "Username not found.";

    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login - Aavaiz Perfumes</title>

    <link rel="stylesheet" href="admin.css">

</head>


<body>

<div class="login-container">

    <div class="login-box">

        <h1>Aavaiz Perfumes</h1>

        <h2>Admin Login</h2>


        <?php if ($error != ""): ?>

            <div class="error">
                <?php echo $error; ?>
            </div>

        <?php endif; ?>


        <form method="POST">

            <label>Username</label>

            <input
                type="text"
                name="username"
                placeholder="Enter username"
                required>


            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Enter password"
                required>


            <button type="submit">
                Login
            </button>

        </form>

    </div>

</div>

</body>

</html>
