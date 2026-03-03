<?php
try {
    $connection = new PDO("mysql:host=localhost;dbname=registration_db","root","");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>