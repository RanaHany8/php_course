<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'Database.php';

$connection = Database::getInstance()->getConnection();
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = trim($_POST['fname'] ?? '');
    $lname = trim($_POST['lname'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $country = $_POST['country'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $skills = isset($_POST['skills']) ? implode(", ", $_POST['skills']) : "";

    // Validation
    if (empty($fname)) $errors[] = "First name is required.";
    if (strlen($password) < 8) $errors[] = "Password must be at least 8 characters.";

    // معالجة الصورة
    $profile_pic_path = "";
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        if (!is_dir('uploads')) mkdir('uploads', 0777, true);
        $ext = pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
        $profile_pic_path = "uploads/" . time() . "_" . uniqid() . "." . $ext;
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profile_pic_path);
    }

    if (empty($errors)) {
        try {
            // تشفير الباسورد عشان الـ Login يشتغل
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // ملاحظة: لو مفيش عمود department في الداتابيز، شيليه من السطر اللي جاي
            $sql = "INSERT INTO users (fname, lname, address, country, gender, username, password, skills, profile_pic) VALUES (?,?,?,?,?,?,?,?,?)";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$fname, $lname, $address, $country, $gender, $username, $hashed_password, $skills, $profile_pic_path]);
            
            header("Location: login.php?success=1");
            exit();
        } catch(PDOException $e) {
            $errors[] = "Database Error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - OOP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card p-4 shadow-sm mx-auto" style="max-width: 600px;">
        <h3 class="text-center text-primary mb-4">Create Account</h3>
        <?php if($errors): ?>
            <div class="alert alert-danger"><?= implode("<br>", $errors) ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="row mb-2">
                <div class="col"><input type="text" name="fname" class="form-control" placeholder="First Name" required></div>
                <div class="col"><input type="text" name="lname" class="form-control" placeholder="Last Name" required></div>
            </div>
            <input type="text" name="address" class="form-control mb-2" placeholder="Address" required>
            <select name="country" class="form-select mb-2">
                <option value="Egypt">Egypt</option>
                <option value="KSA">KSA</option>
            </select>
            <div class="mb-2 p-2 border rounded bg-white">
                <label class="me-3">Gender:</label>
                <input type="radio" name="gender" value="Male" checked> Male
                <input type="radio" name="gender" value="Female" class="ms-2"> Female
            </div>
            <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
            <input type="password" name="password" class="form-control mb-2" placeholder="Password (min 8 chars)" required>
            <div class="mb-2 p-2 border rounded bg-white">
                <label class="me-3">Skills:</label>
                <input type="checkbox" name="skills[]" value="PHP"> PHP
                <input type="checkbox" name="skills[]" value="MySQL" class="ms-2"> MySQL
            </div>
            <input type="file" name="profile_pic" class="form-control mb-3">
            <button class="btn btn-primary w-100">Register Now</button>
        </form>
    </div>
</div>
</body>
</html>