<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

   
    $fname = !empty($_POST['fname']) ? $_POST['fname'] : "First Name is required";
    $lname = !empty($_POST['lname']) ? $_POST['lname'] : "Last Name is required";
    $address = $_POST['address'];
    $country = $_POST['country'];
    $gender = isset($_POST['gender']) ? $_POST['gender'] : null;
    $username = $_POST['username'];
    $department = $_POST['department'];
    $verify_code = $_POST['verify_code'];

   
    if ($verify_code !== "Sh68Sa") {
        die("Error: Verification code is incorrect! Please go back and try again.");
    }

 
    if ($gender == "Male") {
        $title = "Mr.";
    } elseif ($gender == "Female") {
        $title = "Miss";
    } else {
        die("Error: Please select your gender.");
    }

   
    $skills = "";
    if (!empty($_POST['skills'])) {
        $skills = implode(",", $_POST['skills']);
    }

    
    $file = "data.txt";

    $data = $fname . "|" .
            $lname . "|" .
            $address . "|" .
            $country . "|" .
            $gender . "|" .
            $skills . "|" .
            $username . "|" .
            $department . "\n";

    file_put_contents($file, $data, FILE_APPEND);

    
    echo "<html><body style='font-family: Arial; margin: 50px;'>";
    echo "<h1>Thanks ($title) $fname $lname</h1>";

    echo "<h3>Please Review Your Information:</h3>";
    echo "<p><strong>Name:</strong> $fname $lname</p>";
    echo "<p><strong>Address:</strong> $address</p>";
    echo "<p><strong>Country:</strong> $country</p>";
    echo "<p><strong>Gender:</strong> $gender</p>";

    echo "<p><strong>Your Skills:</strong><br>";
    if (!empty($skills)) {
        foreach (explode(",", $skills) as $skill) {
            echo "- $skill <br>";
        }
    } else {
        echo "No skills selected.";
    }
    echo "</p>";

    echo "<p><strong>Username:</strong> $username</p>";
    echo "<p><strong>Department:</strong> $department</p>";

    echo "<br><a href='list.php'>View All Users</a>";

    echo "</body></html>";

} else {
    echo "Direct access is not allowed.";
}
?>