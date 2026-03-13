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
$user = $userObj->getUserById($id);

if(!$user) {
    die("<div class='alert alert-danger'>User not found!</div>");
}

$errors = [];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $address = trim($_POST['address']);
    $country = $_POST['country'];
    $gender = $_POST['gender'] ?? '';
    $skills_array = $_POST['skills'] ?? [];
    $skills = implode(", ", $skills_array);

  
    if(empty($fname)) $errors['fname'] = "First name is required";
    if(empty($address)) $errors['address'] = "Address is required";

  
    $profile_pic_path = $user['profile_pic']; 
    if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $ext = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));
        if(in_array($ext, ['jpg', 'jpeg', 'png'])) {
          
            if(!empty($user['profile_pic']) && file_exists($user['profile_pic'])) {
                unlink($user['profile_pic']);
            }
            $profile_pic_path = "uploads/" . time() . "_" . uniqid() . "." . $ext;
            move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profile_pic_path);
        }
    }

   
    if(empty($errors)) {
        $data = [
            'fname' => $fname, 
            'lname' => $lname, 
            'address' => $address,
            'country' => $country, 
            'gender' => $gender, 
            'skills' => $skills,
            'profile_pic' => $profile_pic_path
        ];
        
        if($userObj->update($id, $data)) {
            header("Location: list.php?message=UpdatedSuccessfully");
            exit();
        } else {
            $errors['db'] = "Update failed in database.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile - ITI System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-sm p-4">
                <h2 class="text-center mb-4">Edit User Profile</h2>
                
                <form method="POST" enctype="multipart/form-data">
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label fw-bold">First Name</label>
                            <input type="text" name="fname" class="form-control" value="<?= htmlspecialchars($user['fname']) ?>">
                            <small class="text-danger"><?= $errors['fname'] ?? '' ?></small>
                        </div>
                        <div class="col">
                            <label class="form-label fw-bold">Last Name</label>
                            <input type="text" name="lname" class="form-control" value="<?= htmlspecialchars($user['lname']) ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Address</label>
                        <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($user['address']) ?>">
                        <small class="text-danger"><?= $errors['address'] ?? '' ?></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Country</label>
                        <select name="country" class="form-select">
                            <option value="Egypt" <?= $user['country'] == 'Egypt' ? 'selected' : '' ?>>Egypt</option>
                            <option value="KSA" <?= $user['country'] == 'KSA' ? 'selected' : '' ?>>KSA</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block fw-bold">Gender</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" value="Male" <?= $user['gender'] == 'Male' ? 'checked' : '' ?>>
                            <label class="form-check-label">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" value="Female" <?= $user['gender'] == 'Female' ? 'checked' : '' ?>>
                            <label class="form-check-label">Female</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block fw-bold">Skills</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="skills[]" value="PHP" <?= strpos($user['skills'], "PHP") !== false ? "checked" : "" ?>>
                            <label class="form-check-label">PHP</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="skills[]" value="MySQL" <?= strpos($user['skills'], "MySQL") !== false ? "checked" : "" ?>>
                            <label class="form-check-label">MySQL</label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Update Photo</label>
                        <input type="file" name="profile_pic" class="form-control mb-2">
                        <img src="<?= $userObj->getProfilePic() ?>" width="80" height="80" class="rounded border">
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill">Update Profile</button>
                        <a href="list.php" class="btn btn-light rounded-pill">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>