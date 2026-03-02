<?php
$file = "data.txt";
$id = $_GET['id'];

$rows = file($file);

unset($rows[$id]);

file_put_contents($file, implode("", $rows));

header("Location: list.php");
exit;