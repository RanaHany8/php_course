<?php
session_start();
require 'connect.php';


header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$stmt = $connection->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header("Location: logout.php");
    exit();
}

$img_path = (!empty($user['profile_pic']) && file_exists($user['profile_pic'])) 
            ? $user['profile_pic'] . "?v=" . time() 
            : 'default-avatar.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Home - ITI Platform</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">ITI Platform</a>
        <div class="d-flex align-items-center ms-auto">
            <img src="<?= $img_path ?>" class="rounded-circle me-2" style="width:45px;height:45px;object-fit:cover;border:2px solid #0d6efd;" alt="Profile">
            <div class="text-white me-3 text-end">
                <small class="d-block text-muted" style="font-size:10px;">Logged in as</small>
                <strong><?= htmlspecialchars($user['username']) ?></strong>
            </div>
            <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-3">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <h1 class="display-6">Welcome Back!</h1>
                    <p class="lead">Hello, <span class="text-primary fw-bold"><?= htmlspecialchars($user['fname']) ?></span>. Nice to see you again!</p>
                    <hr class="my-4 w-50 mx-auto">
                    <p class="text-muted">You can manage your profile settings from your dashboard.</p>
                    <a href="profile.php" class="btn btn-primary mt-3">Go to Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>