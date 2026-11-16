<?php
require 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Welcome, <?= htmlspecialchars($_SESSION["user_name"]) ?>!</h2>

    <h3>Online Complaint Management System</h3>

    <a href="submit_complaint.php" class="btn">
        Submit Complaint
    </a>

    <a href="my_complaint.php" class="btn">
        My Complaints
    </a>

    <a href="logout.php" class="btn">Logout</a>
</div>

</body>
</html>