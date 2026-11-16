<?php
require 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($name === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)
        || strlen($password) < 8) {

        $message = "Enter valid details. Password must have at least 8 characters.";

    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
            "INSERT INTO users (name, email, password) VALUES (?, ?, ?)"
        );

        $stmt->bind_param("sss", $name, $email, $hash);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            $message = "Registration failed. The email may already exist.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>User Registration</h2>

    <p><?= htmlspecialchars($message) ?></p>

    <form method="POST">
        <input type="text" name="name"
               placeholder="Full Name" required>

        <input type="email" name="email"
               placeholder="Email Address" required>

        <input type="password" name="password"
               placeholder="Password (minimum 8 characters)"
               minlength="8" required>

        <button type="submit">Register</button>
    </form>

    <p>Already registered? <a href="login.php">Login</a></p>
</div>

</body>
</html>