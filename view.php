<?php
$file = "data.txt";
$id = $_GET['id'];

$rows = file($file);

if (!isset($rows[$id])) {
    die("User Not Found");
}

$data = explode("|", trim($rows[$id]));

echo "<h2>User Details</h2>";
echo "Name: $data[0] $data[1] <br>";
echo "Address: $data[2] <br>";
echo "Country: $data[3] <br>";
echo "Gender: $data[4] <br>";
echo "Skills: $data[5] <br>";
echo "Username: $data[6] <br>";
echo "Department: $data[7] <br>";