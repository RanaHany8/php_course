<?php
session_start();
require 'connect.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_input = trim($_POST['username'] ?? '');
    $pass_input = $_POST['password'] ?? '';

    if (!empty($user_input) && !empty($pass_input)) {
        $stmt = $connection->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$user_input]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($pass_input, $row['password'])) {
            session_unset();
            session_destroy();
            session_start();
            session_regenerate_id(true);
            $_SESSION['user_id'] = $row['id'];
            header("Location: list.php");
            exit();
        } else {
            $error = "Invalid Username or Password!";
        }
    } else $error = "Please fill all fields.";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{background:#f8f9fa;height:100vh;display:flex;align-items:center;}
.card{border-radius:15px;box-shadow:0 4px 20px rgba(0,0,0,0.1);width:100%;max-width:400px;margin:auto;}
</style>
</head>
<body>
<div class="card p-4">
<h2 class="text-center text-primary mb-4 fw-bold">Login</h2>
<?php if($error): ?><div class="alert alert-danger text-center small"><?= $error ?></div><?php endif; ?>
<form method="POST">
<div class="mb-3">
<label>Username</label>
<input type="text" name="username" class="form-control" required>
</div>
<div class="mb-4">
<label>Password</label>
<input type="password" name="password" class="form-control" required>
</div>
<button class="btn btn-primary w-100 fw-bold">Login</button>
<div class="text-center mt-3">
<small>Don't have an account? <a href="register.php">Register</a></small>
</div>
</form>
</div>
</body>
</html>