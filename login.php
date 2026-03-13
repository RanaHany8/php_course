<?php
session_start();
require_once 'Database.php';
$connection = Database::getInstance()->getConnection();
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $connection->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: list.php");
        exit();
    } else { $error = "Invalid data!"; }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center" style="height:100vh;">
    <div class="card p-4 shadow mx-auto" style="width:350px;">
        <h2 class="text-center mb-4">Login</h2>
        <?php if($error): ?><div class="alert alert-danger small"><?= $error ?></div><?php endif; ?>
        <form method="POST">
            <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
            <button class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>
</html>