<?php
session_start();
require 'connect.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? 0;
$stmt = $connection->prepare("SELECT * FROM users WHERE id=?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$user) {
    die("User not found!");
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>View User</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">User Details</h2>
    <a href="list.php" class="btn btn-secondary mb-3">Back to List</a>
    <div class="card p-4 shadow-sm">
        <div class="text-center mb-3">
            <?php if(!empty($user['profile_pic']) && file_exists($user['profile_pic'])): ?>
                <img src="<?= $user['profile_pic'] ?>" style="width:100px;height:100px;border-radius:50%;">
            <?php else: ?>
                <img src="default-avatar.png" style="width:100px;height:100px;border-radius:50%;">
            <?php endif; ?>
        </div>
        <p><strong>First Name:</strong> <?= htmlspecialchars($user['fname']) ?></p>
        <p><strong>Last Name:</strong> <?= htmlspecialchars($user['lname']) ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($user['address']) ?></p>
        <p><strong>Country:</strong> <?= htmlspecialchars($user['country']) ?></p>
        <p><strong>Gender:</strong> <?= htmlspecialchars($user['gender']) ?></p>
        <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
        <p><strong>Skills:</strong> <?= htmlspecialchars($user['skills']) ?></p>
    </div>
</div>
</body>
</html>