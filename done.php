<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    $fname = !empty($_POST['fname']) ? $_POST['fname'] : "First Name is required";
    $lname = !empty($_POST['lname']) ? $_POST['lname'] : "Last Name is required";
    $gender = isset($_POST['gender']) ? $_POST['gender'] : null;
    $verify_code = $_POST['verify_code'];

   
    if ($verify_code !== "Sh68Sa") {
        die("Error: Verification code is incorrect! Please go back and try again.");
    }

   
    $title = "";
    if ($gender == "Male") {
        $title = "Mr.";
    } elseif ($gender == "Female") {
        $title = "Miss";
    } else {
        die("Error: Please select your gender.");
    }

  
    echo "<html><body style='font-family: Arial; margin: 50px;'>";
    echo "<h1>Thanks ($title) $fname $lname</h1>";
    echo "<h3>Please Review Your Information:</h3>";
    echo "<p><strong>Name:</strong> $fname $lname</p>";
    echo "<p><strong>Address:</strong> " . $_POST['address'] . "</p>";
    
    echo "<p><strong>Your Skills:</strong><br>";
    if (!empty($_POST['skills'])) {
        foreach ($_POST['skills'] as $skill) {
            echo "- " . $skill . "<br>";
        }
    } else {
        echo "No skills selected.";
    }
    echo "</p>";

    echo "<p><strong>Department:</strong> " . $_POST['department'] . "1</p>";
    echo "</body></html>";

} else {
    
    echo "Direct access is not allowed.";
}
?>