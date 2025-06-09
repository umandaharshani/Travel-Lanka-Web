<?php
$hostname = "localhost";
$username = "root";
$password = "";
$db = "traveller";

$con = new mysqli($hostname, $username, $password, $db);
if ($con->connect_error) {
    die("Database connection failed: " . $con->connect_error);
}

if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $uname = $_POST["username"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $pwd = $_POST["password"];
    $gender = $_POST["gender"];
    $experience = $_POST["experience"];
    $languages = $_POST["languages"];

    // Encrypt password
    $hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);

    $sql = "INSERT INTO guides (name, username, email, phone, password, gender, experience_years, languages_spoken)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssssssis", $name, $uname, $email, $phone, $hashed_pwd, $gender, $experience, $languages);

    if ($stmt->execute()) {
        echo "<script>alert('Guide Registered Successfully');</script>";
    } else {
        echo "<script>alert('Registration Failed');</script>";
    }

    $stmt->close();
    $con->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Guide Registration</title>
    <style>
        body {
            font-family: Arial;
            background: #f2f2f2;
            margin: 0;
            padding: 40px;
        }

        .container {
            background: #fff;
            padding: 30px;
            width: 500px;
            margin: auto;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type=submit] {
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Guide Registration</h2>
    <form method="POST">
        <label>Full Name</label>
        <input type="text" name="name" required>

        <label>Username</label>
        <input type="text" name="username" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Phone</label>
        <input type="text" name="phone" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Gender</label>
        <select name="gender" required>
            <option value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="unknown">Prefer not to say</option>
        </select>

        <label>Years of Experience</label>
        <input type="number" name="experience" min="0" required>

        <label>Languages Spoken</label>
        <input type="text" name="languages" placeholder="E.g., English, Sinhala, Tamil" required>

        <input type="submit" name="submit" value="Register">
    </form>
</div>

</body>
</html>
