<?php
session_start();
require 'connect.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? 0;
$stmt = $connection->prepare("SELECT profile_pic FROM users WHERE id=?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($user){
    if(!empty($user['profile_pic']) && file_exists($user['profile_pic'])) unlink($user['profile_pic']);
    $stmt = $connection->prepare("DELETE FROM users WHERE id=?");
    $stmt->execute([$id]);
}

header("Location: list.php");
exit();
?>