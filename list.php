<?php
session_start();
require 'connect.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$result = $connection->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>All Users</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">All Users</h2>
    <a href="register.php" class="btn btn-success mb-3">Add User</a>
    <table class="table table-striped table-hover table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Picture</th>
                <th>Name</th>
                <th>Country</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td>
                    <?php if(!empty($row['profile_pic']) && file_exists($row['profile_pic'])): ?>
                        <img src="<?= $row['profile_pic'] ?>" style="width:50px;height:50px;border-radius:50%;">
                    <?php else: ?>
                        <img src="default-avatar.png" style="width:50px;height:50px;border-radius:50%;">
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($row['fname']." ".$row['lname']) ?></td>
                <td><?= htmlspecialchars($row['country']) ?></td>
                <td>
                    <a class='btn btn-success btn-sm me-1' href='view.php?id=<?= $row['id'] ?>'>View</a>
                    <a class='btn btn-primary btn-sm me-1' href='edit.php?id=<?= $row['id'] ?>'>Edit</a>
                    <a class='btn btn-danger btn-sm' href='delete.php?id=<?= $row['id'] ?>'>Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>