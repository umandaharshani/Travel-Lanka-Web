<?php
// admin.php
$hostname = "localhost";
$username = "root";
$password = "";
$db = "traveller";

// Create connection
$con = new mysqli($hostname, $username, $password, $db);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Fetch bookings
$bookingResult = $con->query("SELECT * FROM booking");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - Travel Your Way</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f4f4;
    }

    header {
      background: #2c3e50;
      color: white;
      padding: 20px;
      text-align: center;
    }

    .sidebar {
      width: 200px;
      height: 100vh;
      background-color: #34495e;
      position: fixed;
      top: 70px;
      left: 0;
      padding-top: 20px;
    }

    .sidebar a {
      display: block;
      color: white;
      padding: 15px;
      text-decoration: none;
      transition: 0.3s;
    }

    .sidebar a:hover {
      background-color: #3d5a73;
    }

    .main {
      margin-left: 220px;
      padding: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color: #2c3e50;
      color: white;
    }

    footer {
      text-align: center;
      padding: 15px;
      margin-top: 30px;
      background-color: #2c3e50;
      color: white;
    }
  </style>
</head>
<body>

<header>
  <h1>Travel Your Way - Admin Panel</h1>
</header>

<div class="sidebar">
  <a href="#">Dashboard</a>
 
</div>

<div class="main">
  <h2>Welcome, Admin 👋</h2>
  <p>Manage your tourism system from here.</p>

  <h3>📅 Booking Records</h3>
  <table>
    <thead>
      <tr>
        <th>Date</th>
        <th>Destination</th>
        <th>Full Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Days</th>
        <th>Persons</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($bookingResult->num_rows > 0) {
          while ($row = $bookingResult->fetch_assoc()) {
              echo "<tr>
                      <td>{$row['date']}</td>
                      <td>{$row['destination']}</td>
                      <td>{$row['fname']}</td>
                      <td>{$row['tp']}</td>
                      <td>{$row['email']}</td>
                      <td>{$row['days']}</td>
                      <td>{$row['persons']}</td>
                    </tr>";
          }
      } else {
          echo "<tr><td colspan='7'>No bookings found.</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

<footer>
  &copy; 2025 Travel Your Way. Admin Panel.
</footer>

</body>
</html>
