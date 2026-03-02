<?php
$file = "data.txt";
$id = $_GET['id'];
$rows = file($file);

$data = explode("|", trim($rows[$id]));
?>

<form method="POST">
    First Name: <input type="text" name="fname" value="<?= $data[0] ?>"><br>
    Last Name: <input type="text" name="lname" value="<?= $data[1] ?>"><br>
    <input type="submit" name="update" value="Update">
</form>

<?php
if (isset($_POST['update'])) {
    $rows[$id] = $_POST['fname']."|".$_POST['lname']."|".$data[2]."|".$data[3]."|".$data[4]."|".$data[5]."|".$data[6]."|".$data[7]."\n";
    file_put_contents($file, implode("", $rows));
    header("Location: list.php");
}
?>