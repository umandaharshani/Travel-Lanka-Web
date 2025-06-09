<?php
// Database connection
$hostname = "localhost";
$username = "root";
$password = "";
$db = "traveller";

$con = new mysqli($hostname, $username, $password, $db);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Fetch all guides
$result = $con->query("SELECT * FROM guides");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Guides - Travel Your Way</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      padding: 20px;
    }

    h1 {
      text-align: center;
      color: #2c3e50;
    }

    table {
      width: 95%;
      margin: 20px auto;
      border-collapse: collapse;
      background-color: white;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    th, td {
      padding: 10px 12px;
      text-align: center;
      border: 1px solid #ccc;
    }

    th {
      background-color: #2c3e50;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .back-btn {
      text-align: center;
      margin-top: 20px;
    }

    .back-btn a {
      text-decoration: none;
      background-color: #2c3e50;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
    }

    .back-btn a:hover {
      background-color: #1a252f;
    }
  </style>
</head>
<body>

<h1>Registered Tour Guides</h1>

<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Username</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Gender</th>
      <th>Experience (Years)</th>
      <th>Languages Spoken</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['username']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['gender']}</td>
                    <td>{$row['experience_years']}</td>
                    <td>{$row['languages_spoken']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No guides found</td></tr>";
    }

    $con->close();
    ?>
  </tbody>
</table>

<div class="back-btn">
  <a href="index.php">← Back to Dashboard</a>
</div>

</body>
</html>
