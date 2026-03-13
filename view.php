<?php
session_start();
require_once 'Database.php';
require_once 'User.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$db = Database::getInstance()->getConnection();
$userObj = new User($db);

$id = $_GET['id'] ?? 0;
$user = $userObj->getUserById($id); // استخدام الكلاس

if(!$user) {
    die("<div class='alert alert-danger'>User not found!</div>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View User Details - OOP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="<?= $userObj->getProfilePic() ?>" alt="Profile" class="rounded-circle border shadow-sm" style="width:120px; height:120px; object-fit: cover;">
                        <h3 class="mt-3"><?= htmlspecialchars($user['fname'] . " " . $user['lname']) ?></h3>
                    </div>

                    <table class="table">
                        <tr><th>Username:</th><td><span class="badge bg-info text-dark"><?= htmlspecialchars($user['username']) ?></span></td></tr>
                        <tr><th>Address:</th><td><?= htmlspecialchars($user['address']) ?></td></tr>
                        <tr><th>Country:</th><td><?= htmlspecialchars($user['country']) ?></td></tr>
                        <tr><th>Skills:</th><td>
                            <?php 
                            $skills = explode(", ", $user['skills']);
                            foreach($skills as $skill) echo "<span class='badge bg-secondary me-1'>$skill</span>";
                            ?>
                        </td></tr>
                    </table>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="list.php" class="btn btn-outline-secondary">Back to List</a>
                        <a href="edit.php?id=<?= $user['id'] ?>" class="btn btn-primary">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>