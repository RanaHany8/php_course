<?php
require_once 'Database.php';
$connection = Database::getInstance()->getConnection();

if(isset($_POST['verify_code']) && $_POST['verify_code'] == "Sh68Sa"){

    $skills = "";
    if(!empty($_POST['skills'])){
        $skills = implode(",", $_POST['skills']);
    }

    $stm = $connection->prepare("insert into users 
    (fname,lname,address,country,gender,skills,username,password,department)
    values(?,?,?,?,?,?,?,?,?)");

    $stm->execute([
        $_POST['fname'],
        $_POST['lname'],
        $_POST['address'],
        $_POST['country'],
        $_POST['gender'],
        $skills,
        $_POST['username'],
        $_POST['password'],
        $_POST['department']
    ]);

    header("Location: list.php");
}
else{
    echo "Wrong Code!";
}
?>