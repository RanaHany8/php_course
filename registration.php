<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; line-height: 1.6; }
        form { background: #f9f9f9; padding: 20px; border: 1px solid #ccc; width: 400px; border-radius: 10px; }
        h2 { color: #333; }
        .label-title { font-weight: bold; display: inline-block; width: 100px; }
        input[type="text"], input[type="password"], textarea, select { width: 250px; margin-bottom: 10px; }
        .btn { padding: 10px 20px; cursor: pointer; }
    </style>
</head>
<body>
    <h2>Registration</h2>
    <form action="done.php" method="POST">
        <span class="label-title">First Name:</span> <input type="text" name="fname" required><br>
        
        <span class="label-title">Last Name:</span> <input type="text" name="lname" required><br>
        
        <span class="label-title">Address:</span> <textarea name="address" rows="3"></textarea><br>
        
        <span class="label-title">Country:</span> 
        <select name="country">
            <option value="Egypt">Egypt</option>
            <option value="KSA">KSA</option>
            <option value="Other">Other</option>
        </select><br>
        
        <span class="label-title">Gender:</span> 
        <input type="radio" name="gender" value="Male" required> Male
        <input type="radio" name="gender" value="Female"> Female<br>
        
        <span class="label-title">Skills:</span> 
        <input type="checkbox" name="skills[]" value="PHP"> PHP
        <input type="checkbox" name="skills[]" value="JS"> JS
        <input type="checkbox" name="skills[]" value="MySQL"> MySQL<br>
        
        <span class="label-title">Username:</span> <input type="text" name="username" required><br>
        
        <span class="label-title">Password:</span> <input type="password" name="password" required><br>
        
        <span class="label-title">Department:</span> <input type="text" name="department" value="OpenSource" readonly><br>
        
        <div style="background: #eee; padding: 10px; margin: 10px 0; display: inline-block;">
            <strong>Sh68Sa</strong>
        </div><br>
        Please Insert the code: <input type="text" name="verify_code" required><br><br>
        
        <input type="submit" value="Submit" class="btn">
        <input type="reset" value="Reset" class="btn">
    </form>
</body>
</html>