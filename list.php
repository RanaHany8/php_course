<?php
session_start();
require_once 'Database.php';
require_once 'User.php';

if(!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$db = Database::getInstance()->getConnection();
$userObj = new User($db);
$users = $userObj->getAllUsers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body">
            <table class="table align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th><th>Picture</th><th>Name</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $counter = 1;
                    foreach($users as $row): 
                        // جلب مسار الصورة باستخدام الكلاس
                        $tempUser = new User($db);
                        $tempUser->getUserById($row['id']);
                        $imgPath = $tempUser->getProfilePic();
                    ?>
                    <tr>
                        <td><?= $counter++ ?></td>
                        <td>
                            <img src="<?= $imgPath ?>?v=<?= time() ?>" width="50" height="50" class="rounded-circle border shadow-sm" style="object-fit: cover;" onerror="this.src='uploads/default.png'">
                        </td>
                        <td class="fw-bold"><?= htmlspecialchars($row['fname'] . " " . $row['lname']) ?></td>
                        <td>
                            <a href="view.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info">View</a>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>