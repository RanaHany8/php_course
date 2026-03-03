<?php
include "connect.php";

$id = $_GET['id'];

$stm = $connection->prepare("delete from users where id=?");
$stm->execute([$id]);

header("Location: list.php");
?>