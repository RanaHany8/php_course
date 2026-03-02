<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #ffffff; /* خلفية بيضاء */
        }

        .container {
            background: #fff;
            padding: 25px 30px;
            width: 420px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            border: 1px solid #eee;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .row {
            margin-bottom: 12px;
        }

        .label-title {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            border-radius: 8px;
            border: 1px solid #ccc;
            outline: none;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: #555;
        }

        .inline {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .code-box {
            background: #f1f1f1;
            padding: 8px 15px;
            display: inline-block;
            border-radius: 6px;
            font-weight: bold;
            letter-spacing: 2px;
            margin: 5px 0;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .btn {
            width: 48%;
            padding: 10px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            color: #fff;
        }

        .submit {
            background: #444;
        }

        .reset {
            background: #888;
        }

        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>

<body>

<div class="container">
    <h2>Registration</h2>

    <form action="done.php" method="POST">

        <div class="row">
            <label class="label-title">First Name</label>
            <input type="text" name="fname" required>
        </div>

        <div class="row">
            <label class="label-title">Last Name</label>
            <input type="text" name="lname" required>
        </div>

        <div class="row">
            <label class="label-title">Address</label>
            <textarea name="address" rows="3"></textarea>
        </div>

        <div class="row">
            <label class="label-title">Country</label>
            <select name="country">
                <option value="Egypt">Egypt</option>
                <option value="KSA">KSA</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="row">
            <label class="label-title">Gender</label>
            <div class="inline">
                <label><input type="radio" name="gender" value="Male" required> Male</label>
                <label><input type="radio" name="gender" value="Female"> Female</label>
            </div>
        </div>

        <div class="row">
            <label class="label-title">Skills</label>
            <div class="inline">
                <label><input type="checkbox" name="skills[]" value="PHP"> PHP</label>
                <label><input type="checkbox" name="skills[]" value="JS"> JS</label>
                <label><input type="checkbox" name="skills[]" value="MySQL"> MySQL</label>
            </div>
        </div>

        <div class="row">
            <label class="label-title">Username</label>
            <input type="text" name="username" required>
        </div>

        <div class="row">
            <label class="label-title">Password</label>
            <input type="password" name="password" required>
        </div>

        <div class="row">
            <label class="label-title">Department</label>
            <input type="text" name="department" value="OpenSource" readonly>
        </div>

        <div class="row">
            <div class="code-box">Sh68Sa</div>
        </div>

        <div class="row">
            <label class="label-title">Insert the code</label>
            <input type="text" name="verify_code" required>
        </div>

        <div class="buttons">
            <input type="submit" value="Submit" class="btn submit">
            <input type="reset" value="Reset" class="btn reset">
        </div>

    </form>
</div>

</body>
</html>