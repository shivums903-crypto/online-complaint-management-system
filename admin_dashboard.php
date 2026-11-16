<?php
require 'db.php';

if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit;
}

$sql = "SELECT complaints.*, users.name, users.email
        FROM complaints
        JOIN users ON complaints.user_id = users.id
        ORDER BY complaints.created_at DESC";

$result = $conn->query($sql);

if (!$result) {
    die("Database query failed: " . htmlspecialchars($conn->error));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Admin Dashboard</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Email</th>
            <th>Title</th>
            <th>Category</th>
            <th>Description</th>
            <th>Status</th>
            <th>Update Status</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= (int)$row["id"] ?></td>
            <td><?= htmlspecialchars($row["name"]) ?></td>
            <td><?= htmlspecialchars($row["email"]) ?></td>
            <td><?= htmlspecialchars($row["title"]) ?></td>
            <td><?= htmlspecialchars($row["category"]) ?></td>
            <td><?= htmlspecialchars($row["description"]) ?></td>
            <td><?= htmlspecialchars($row["status"] ?? "Pending") ?></td>
            <td>
                <form method="POST" action="update_status.php">
                    <input type="hidden" name="id"
                           value="<?= (int)$row["id"] ?>">

                    <select name="status" required>
                        <option value="Pending">Pending</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Resolved">Resolved</option>
                    </select>

                    <button type="submit">Update</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <p><a href="logout.php">Logout</a></p>
</div>
</body>
</html>