<?php
require 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    $stmt = $conn->prepare(
        "SELECT id, password FROM admins WHERE username = ?"
    );

    $stmt->bind_param("s", $username);
    $stmt->execute();

    $admin = $stmt->get_result()->fetch_assoc();

    if ($admin &&
        hash_equals(
            $admin["password"],
            hash("sha256", $password)
        )) {

        session_regenerate_id(true);
        $_SESSION["admin_id"] = $admin["id"];

        header("Location: admin.php");
        exit;

    } else {
        $message = "Invalid administrator credentials.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Admin Login</h2>

    <p><?= htmlspecialchars($message) ?></p>

    <form method="POST">
        <input type="text" name="username"
               placeholder="Admin Username" required>

        <input type="password" name="password"
               placeholder="Admin Password" required>

        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>