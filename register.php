<?php
session_start();
require 'connect.php';

$errors = [];
$fname = $lname = $address = $country = $gender = $username = "";
$skills_array = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = trim($_POST['fname'] ?? '');
    $lname = trim($_POST['lname'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $country = $_POST['country'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $skills_array = $_POST['skills'] ?? [];
    $skills = implode(", ", $skills_array);

    //server_validation
    if (empty($fname) || !preg_match("/^[a-zA-Z\s]+$/", $fname)) $errors['fname'] = "Valid first name required.";
    if (empty($lname) || !preg_match("/^[a-zA-Z\s]+$/", $lname)) $errors['lname'] = "Valid last name required.";
    if (empty($address)) $errors['address'] = "Address is required.";
    if (empty($country)) $errors['country'] = "Country is required.";
    if (empty($gender)) $errors['gender'] = "Gender is required.";
    if (empty($username)) $errors['username'] = "Username is required.";
    if (empty($skills_array)) $errors['skills'] = "Select at least one skill.";

    if (strlen($password) !== 8) $errors['password'] = "Password must be exactly 8 characters.";
    elseif (preg_match("/[A-Z]/", $password)) $errors['password'] = "No capital letters allowed.";
    elseif (!preg_match("/^[a-z0-9_]+$/", $password)) $errors['password'] = "Only small letters, numbers and underscore allowed.";

   
    $profile_pic_path = "";
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) $errors['profile_pic'] = "Only JPG and PNG allowed.";
        elseif ($_FILES['profile_pic']['size'] > 2*1024*1024) $errors['profile_pic'] = "Max size 2MB.";
        else {
            if (!is_dir('uploads')) mkdir('uploads', 0777, true);
            $profile_pic_path = "uploads/".time()."_".uniqid().".".$ext;
            move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profile_pic_path);
        }
    } else {
        $errors['profile_pic'] = "Profile picture is required.";
    }

    if (empty($errors)) {
        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (fname,lname,address,country,gender,username,password,skills,profile_pic)
                    VALUES (?,?,?,?,?,?,?,?,?)";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$fname,$lname,$address,$country,$gender,$username,$hashed_password,$skills,$profile_pic_path]);
            header("Location: login.php");
            exit();
        } catch(PDOException $e) {
            $errors['username'] = "Username already exists.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Register</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.error { color:red; font-size:0.85rem; }
</style>
</head>
<body>
<div class="container py-5">
<div class="row justify-content-center">
<div class="col-md-7">
<div class="card p-4 shadow-sm">

<h3 class="text-center text-primary mb-4">Registration Form</h3>

<form method="POST" enctype="multipart/form-data" id="registerForm">

<div class="row">
<div class="col-md-6 mb-3">
<label>First Name</label>
<input type="text" name="fname" class="form-control" value="<?= htmlspecialchars($fname) ?>" required>
<span class="error"><?= $errors['fname'] ?? '' ?></span>
</div>
<div class="col-md-6 mb-3">
<label>Last Name</label>
<input type="text" name="lname" class="form-control" value="<?= htmlspecialchars($lname) ?>" required>
<span class="error"><?= $errors['lname'] ?? '' ?></span>
</div>
</div>

<div class="mb-3">
<label>Address</label>
<input type="text" name="address" class="form-control" value="<?= htmlspecialchars($address) ?>" required>
<span class="error"><?= $errors['address'] ?? '' ?></span>
</div>

<div class="row">
<div class="col-md-6 mb-3">
<label>Country</label>
<select name="country" class="form-select" required>
<option value="">Select</option>
<option value="Egypt" <?= $country=="Egypt"?"selected":"" ?>>Egypt</option>
<option value="KSA" <?= $country=="KSA"?"selected":"" ?>>KSA</option>
</select>
<span class="error"><?= $errors['country'] ?? '' ?></span>
</div>
<div class="col-md-6 mb-3">
<label>Gender</label><br>
<input type="radio" name="gender" value="Male" <?= $gender=="Male"?"checked":"" ?>> Male
<input type="radio" name="gender" value="Female" <?= $gender=="Female"?"checked":"" ?>> Female
<span class="error"><?= $errors['gender'] ?? '' ?></span>
</div>
</div>

<div class="mb-3">
<label>Username</label>
<input type="text" name="username" class="form-control" value="<?= htmlspecialchars($username) ?>" required>
<span class="error"><?= $errors['username'] ?? '' ?></span>
</div>

<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control" required>
<span class="error"><?= $errors['password'] ?? '' ?></span>
</div>

<div class="mb-3">
<label>Skills</label><br>
<input type="checkbox" name="skills[]" value="PHP" <?= in_array("PHP",$skills_array)?"checked":"" ?>> PHP
<input type="checkbox" name="skills[]" value="MySQL" <?= in_array("MySQL",$skills_array)?"checked":"" ?>> MySQL
<span class="error"><?= $errors['skills'] ?? '' ?></span>
</div>

<div class="mb-3">
<label>Profile Picture</label>
<input type="file" name="profile_pic" class="form-control" required>
<span class="error"><?= $errors['profile_pic'] ?? '' ?></span>
</div>

<button class="btn btn-primary w-100">Register</button>

<div class="text-center mt-3">
<small>Already have an account? <a href="login.php">Login here</a></small>
</div>
</form>
</div>
</div>
</div>
</div>

<script>
document.getElementById('registerForm').addEventListener('input', function(e){
    // client_validation
    const pwd = this.password.value;
    const errorElem = this.password.nextElementSibling;
    if(pwd.length !== 8) errorElem.textContent = "Password must be 8 chars";
    else if(/[A-Z]/.test(pwd)) errorElem.textContent = "No capital letters allowed";
    else if(/[^a-z0-9_]/.test(pwd)) errorElem.textContent = "Only small letters, numbers, underscore allowed";
    else errorElem.textContent = "";
});
</script>

</body>
</html>