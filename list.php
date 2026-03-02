<?php
$file = "data.txt";

if (!file_exists($file)) {
    echo "No Data Found";
    exit;
}

$rows = file($file);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #ffffff;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 80%;
            max-width: 1000px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 18px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        th {
            background: #444;
            color: white;
            padding: 12px;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        a {
            text-decoration: none;
            padding: 6px 10px;
            border-radius: 5px;
            font-size: 14px;
            color: white;
            margin: 0 3px;
        }

        .view {
            background: #4CAF50;
        }

        .delete {
            background: #f44336;
        }

        .edit {
            background: #2196F3;
        }

        a:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body>

<div class="container">
    <h2>All Users</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Country</th>
            <th>Actions</th>
        </tr>

        <?php
        foreach ($rows as $index => $row) {
            $data = explode("|", trim($row));
            echo "<tr>";
            echo "<td>$index</td>";
            echo "<td>$data[0] $data[1]</td>";
            echo "<td>$data[3]</td>";
            echo "<td>
                    <a class='view' href='view.php?id=$index'>View</a>
                    <a class='delete' href='delete.php?id=$index'>Delete</a>
                    <a class='edit' href='edit.php?id=$index'>Edit</a>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>

</body>
</html>