<?php
require 'db.php';

if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: admin.php");
    exit;
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$status = $_POST["status"] ?? "";

$allowed = ["Pending", "In Progress", "Resolved"];

if (!$id || !in_array($status, $allowed, true)) {
    die("Invalid complaint ID or status.");
}

$stmt = $conn->prepare(
    "UPDATE complaints SET status = ? WHERE id = ?"
);

$stmt->bind_param("si", $status, $id);
$stmt->execute();

header("Location: admin.php");
exit;
?>