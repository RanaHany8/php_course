<?php
session_start();
require_once 'Database.php';
require_once 'User.php';

if(!isset($_SESSION['user_id'])) exit();

$db = Database::getInstance()->getConnection();
$userObj = new User($db);

$id = $_GET['id'] ?? 0;

if($userObj->delete($id)) {
    header("Location: list.php?msg=Deleted");
} else {
    echo "Error deleting user.";
}