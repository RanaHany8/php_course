<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>All Users</title>

  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
     <a href="registration.php" class="btn btn-success">Add</a>
</head>
<body>

<?php
include "connect.php";

$result = $connection->query("SELECT * FROM users");
?>

<div class="container mt-5">
    <h2 class="mb-4">All Users</h2>

    <table class="table table-striped table-hover table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Country</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['fname']} {$row['lname']}</td>";
            echo "<td>{$row['country']}</td>";
            echo "<td>
                <a class='btn btn-success btn-sm me-1' href='view.php?id={$row['id']}'>View</a>
                <a class='btn btn-primary btn-sm me-1' href='edit.php?id={$row['id']}'>Edit</a>
                <a class='btn btn-danger btn-sm' href='delete.php?id={$row['id']}'>Delete</a>
            </td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>

</body>
</html>