<?php
include "connect.php";

$id = $_GET['id'];

$stm = $connection->prepare("select * from users where id=?");
$stm->execute([$id]);
$user = $stm->fetch(PDO::FETCH_ASSOC);
?>

<form method="POST">
First Name: <input type="text" name="fname" value="<?= $user['fname'] ?>"><br>
Last Name: <input type="text" name="lname" value="<?= $user['lname'] ?>"><br>
<input type="submit" name="update" value="Update">
</form>

<?php
if(isset($_POST['update'])){

    $stm = $connection->prepare("update users set fname=?, lname=? where id=?");
    $stm->execute([$_POST['fname'], $_POST['lname'], $id]);

    header("Location: list.php");
}
?>