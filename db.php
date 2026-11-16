<?php
session_start();

$conn = new mysqli("localhost", "root", "", "complaint_db");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>