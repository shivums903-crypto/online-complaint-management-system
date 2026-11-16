<?php
require 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

$stmt = $conn->prepare(
    "SELECT id, title, category, description, status, created_at
     FROM complaints
     WHERE user_id = ?
     ORDER BY created_at DESC"
);

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Complaints</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>My Complaints</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Category</th>
            <th>Description</th>
            <th>Status</th>
            <th>Date</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= (int)$row["id"] ?></td>

            <td><?= htmlspecialchars($row["title"]) ?></td>

            <td><?= htmlspecialchars($row["category"]) ?></td>

            <td><?= htmlspecialchars($row["description"]) ?></td>

            <td><?= htmlspecialchars($row["status"]) ?></td>

            <td><?= htmlspecialchars($row["created_at"]) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</div>

</body>
</html>