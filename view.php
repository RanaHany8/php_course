<?php
include "connect.php";

$id = $_GET['id'];

$stm = $connection->prepare("select * from users where id=?");
$stm->execute([$id]);
$user = $stm->fetch(PDO::FETCH_ASSOC);

echo "<h2>User Details</h2>";
echo "Name: {$user['fname']} {$user['lname']} <br>";
echo "Address: {$user['address']} <br>";
echo "Country: {$user['country']} <br>";
echo "Gender: {$user['gender']} <br>";
echo "Skills: {$user['skills']} <br>";
echo "Username: {$user['username']} <br>";
echo "Department: {$user['department']} <br>";
?>