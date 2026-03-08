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

if(!$user) die("User not found!");

$errors = [];

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $address = trim($_POST['address']);
    $country = $_POST['country'];
    $gender = $_POST['gender'];
    $skills_array = $_POST['skills'] ?? [];
    $skills = implode(", ", $skills_array);

    if(empty($fname) || !preg_match("/^[a-zA-Z\s]+$/",$fname)) $errors['fname']="Valid first name required";
    if(empty($lname) || !preg_match("/^[a-zA-Z\s]+$/",$lname)) $errors['lname']="Valid last name required";
    if(empty($address)) $errors['address']="Address required";
    if(empty($country)) $errors['country']="Select country";
    if(empty($gender)) $errors['gender']="Select gender";

    $profile_pic_path = $user['profile_pic'];
    if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error']==0){
        $allowed = ['jpg','jpeg','png'];
        $ext = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));
        if(in_array($ext,$allowed) && $_FILES['profile_pic']['size']<=2*1024*1024){
            if(!is_dir('uploads')) mkdir('uploads',0777,true);
            $profile_pic_path = "uploads/".time()."_".uniqid().".".$ext;
            move_uploaded_file($_FILES['profile_pic']['tmp_name'],$profile_pic_path);
        } else {
            $errors['profile_pic']="Invalid file";
        }
    }

    if(empty($errors)){
        $stmt = $connection->prepare("UPDATE users SET fname=?, lname=?, address=?, country=?, gender=?, skills=?, profile_pic=? WHERE id=?");
        $stmt->execute([$fname,$lname,$address,$country,$gender,$skills,$profile_pic_path,$id]);
        header("Location: list.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Edit User</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
<h2 class="mb-4">Edit User</h2>
<a href="list.php" class="btn btn-secondary mb-3">Back to List</a>
<div class="card p-4 shadow-sm">
<form method="POST" enctype="multipart/form-data">
<div class="mb-3">
<label>First Name</label>
<input type="text" name="fname" class="form-control" value="<?= htmlspecialchars($user['fname']) ?>" required>
<span class="text-danger"><?= $errors['fname'] ?? '' ?></span>
</div>

<div class="mb-3">
<label>Last Name</label>
<input type="text" name="lname" class="form-control" value="<?= htmlspecialchars($user['lname']) ?>" required>
<span class="text-danger"><?= $errors['lname'] ?? '' ?></span>
</div>

<div class="mb-3">
<label>Address</label>
<input type="text" name="address" class="form-control" value="<?= htmlspecialchars($user['address']) ?>" required>
<span class="text-danger"><?= $errors['address'] ?? '' ?></span>
</div>

<div class="mb-3">
<label>Country</label>
<select name="country" class="form-select" required>
<option value="">Select</option>
<option value="Egypt" <?= $user['country']=="Egypt"?"selected":"" ?>>Egypt</option>
<option value="KSA" <?= $user['country']=="KSA"?"selected":"" ?>>KSA</option>
</select>
<span class="text-danger"><?= $errors['country'] ?? '' ?></span>
</div>

<div class="mb-3">
<label>Gender</label><br>
<input type="radio" name="gender" value="Male" <?= $user['gender']=="Male"?"checked":"" ?>> Male
<input type="radio" name="gender" value="Female" <?= $user['gender']=="Female"?"checked":"" ?>> Female
<span class="text-danger"><?= $errors['gender'] ?? '' ?></span>
</div>

<div class="mb-3">
<label>Skills</label><br>
<input type="checkbox" name="skills[]" value="PHP" <?= strpos($user['skills'],"PHP")!==false?"checked":"" ?>> PHP
<input type="checkbox" name="skills[]" value="MySQL" <?= strpos($user['skills'],"MySQL")!==false?"checked":"" ?>> MySQL
</div>

<div class="mb-3">
<label>Profile Picture</label>
<input type="file" name="profile_pic" class="form-control">
<?php if(!empty($user['profile_pic']) && file_exists($user['profile_pic'])): ?>
<img src="<?= $user['profile_pic'] ?>" style="width:50px;height:50px;border-radius:50%;margin-top:5px;">
<?php endif; ?>
<span class="text-danger"><?= $errors['profile_pic'] ?? '' ?></span>
</div>

<button class="btn btn-primary w-100">Update</button>
</form>
</div>
</div>
</body>
</html>