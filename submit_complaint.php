<?php
require 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$message = "";
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST["title"] ?? "");
    $category = $_POST["category"] ?? "";
    $description = trim($_POST["description"] ?? "");

    $allowed = ["Technical", "Electrical", "Water", "Other"];

    if (
        $title === "" ||
        $description === "" ||
        !in_array($category, $allowed, true)
    ) {
        $message = "Please enter valid complaint details.";

    } else {

        $user_id = (int) $_SESSION["user_id"];

        $stmt = $conn->prepare(
            "INSERT INTO complaints
            (user_id, title, category, description)
            VALUES (?, ?, ?, ?)"
        );

        if ($stmt) {

            $stmt->bind_param(
                "isss",
                $user_id,
                $title,
                $category,
                $description
            );

            if ($stmt->execute()) {

                $complaint_id = $conn->insert_id;

                $message = "Complaint submitted successfully. Complaint ID: "
                         . $complaint_id;

                $success = true;

            } else {
                $message = "Unable to submit complaint. Please try again.";
            }

            $stmt->close();

        } else {
            $message = "Database error. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Submit Complaint</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h2>Submit Your Complaint</h2>

    <?php if ($message !== ""): ?>
        <p style="color: <?= $success ? 'green' : 'red' ?>;">
            <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>

    <?php if (!$success): ?>

        <form method="POST" action="submit_complaint.php">

            <input
                type="text"
                name="title"
                placeholder="Complaint Title"
                maxlength="255"
                required
            >

            <select name="category" required>
                <option value="">Select Category</option>
                <option value="Technical">Technical</option>
                <option value="Electrical">Electrical</option>
                <option value="Water">Water</option>
                <option value="Other">Other</option>
            </select>

            <textarea
                name="description"
                placeholder="Describe your complaint"
                required
            ></textarea>

            <button type="submit">Submit Complaint</button>

        </form>

    <?php endif; ?>

    <br>

    <a href="dashboard.php">Back to Dashboard</a>

</div>

</body>
</html>