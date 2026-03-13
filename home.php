<?php
session_start();
require_once 'Database.php';

/** * Defining the User class directly for simplicity. 
 * In a real project, you should move this to a separate file named User.php
 */
class User {
    private $db;
    private $userData;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    // Fetch user details by ID
    public function getUserById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$id]);
            $this->userData = $stmt->fetch(PDO::FETCH_ASSOC);
            return $this->userData;
        } catch (PDOException $e) {
            return null;
        }
    }

    // Determine the profile picture path
    public function getProfilePic() {
        if (!empty($this->userData['profile_pic']) && file_exists($this->userData['profile_pic'])) {
            return $this->userData['profile_pic'];
        }
        return 'uploads/default.png'; // Make sure this file exists
    }
}

// 1. Prevent Browser Caching (Security)
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// 2. Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 3. Get Database Connection (Singleton)
$db = Database::getInstance()->getConnection();

// 4. Create User Object and Fetch Data
$userObj = new User($db);
$user = $userObj->getUserById($_SESSION['user_id']);

// If user session exists but ID is not in DB (e.g., deleted)
if (!$user) {
    header("Location: logout.php");
    exit();
}

// 5. Get Image Path
$img_path = $userObj->getProfilePic();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - ITI Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: bold; letter-spacing: 1px; }
        .profile-nav-img { width: 40px; height: 40px; object-fit: cover; border: 2px solid #fff; }
        .welcome-card { border-radius: 20px; border: none; overflow: hidden; }
        .profile-main-img { width: 130px; height: 130px; object-fit: cover; border: 5px solid #fff; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#">ITI PLATFORM</a>
        <div class="ms-auto d-flex align-items-center">
            <span class="text-light me-3 d-none d-md-inline">
                Welcome, <strong><?= htmlspecialchars($user['username']) ?></strong>
            </span>
            <img src="<?= $img_path ?>" class="rounded-circle profile-nav-img me-2" alt="Avatar">
            <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-3">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card shadow welcome-card">
                <div class="card-body py-5">
                    <div class="mb-4">
                        <img src="<?= $img_path ?>" class="rounded-circle shadow profile-main-img" alt="Profile Picture">
                    </div>
                    
                    <h1 class="display-5 fw-bold text-dark">Welcome Back, <?= htmlspecialchars($user['fname']) ?>!</h1>
                    <p class="lead text-muted">You have successfully logged into the OOP-managed system.</p>
                    
                    <hr class="my-4 mx-auto" style="width: 30%;">

                    <div class="row g-3 px-md-5">
                        <div class="col-sm-6">
                            <a href="list.php" class="btn btn-primary w-100 py-2 shadow-sm">
                                <i class="bi bi-people"></i> View Users List
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="edit.php?id=<?= $user['id'] ?>" class="btn btn-outline-dark w-100 py-2 shadow-sm">
                                Edit My Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <p class="mt-4 text-muted small">&copy; 2026 ITI Training Lab - Developed by Rana Hany</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>