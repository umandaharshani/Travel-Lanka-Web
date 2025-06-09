<?php
// admin.php
$hostname = "localhost";
$username = "root";
$password = "";
$db = "traveller";

$con = new mysqli($hostname, $username, $password, $db);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Count bookings
$bookingResult = $con->query("SELECT COUNT(*) AS total_bookings FROM booking");
$bookingCount = ($bookingResult->num_rows > 0) ? $bookingResult->fetch_assoc()['total_bookings'] : 0;

// Count registrations
$registrationResult = $con->query("SELECT COUNT(*) AS total_registrations FROM registration");
$registrationCount = ($registrationResult->num_rows > 0) ? $registrationResult->fetch_assoc()['total_registrations'] : 0;

// Count guides
$guideResult = $con->query("SELECT COUNT(*) AS total_guides FROM guides");
$guideCount = ($guideResult->num_rows > 0) ? $guideResult->fetch_assoc()['total_guides'] : 0;
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

    .stats-box {
      display: flex;
      gap: 30px;
      margin-top: 30px;
      flex-wrap: wrap;
    }

    .card {
      background-color: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      flex: 1;
      text-align: center;
      min-width: 250px;
    }

    .card h2 {
      font-size: 48px;
      color: #2c3e50;
    }

    .card p {
      font-size: 18px;
      color: #555;
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
  <a href="booking.php">Bookings</a>
  <a href="manage_bookings.php">Manage Bookings</a>
  <a href="user.php">Users</a>
  <a href="guide.php">Guide</a>
  <a href="payment.php">Payment</a>
  <a href="sales.php">Sales</a>

  <a href="#">Logout</a>
</div>

<div class="main">
  <h2>Welcome, Admin 👋</h2>
  <p>Here is a quick overview of system activity.</p>

  <div class="stats-box">
    <div class="card">
      <h2><?php echo $bookingCount; ?></h2>
      <p>Total Bookings</p>
    </div>
    <div class="card">
      <h2><?php echo $registrationCount; ?></h2>
      <p>Total Registrations</p>
    </div>
    <div class="card">
      <h2><?php echo $guideCount; ?></h2>
      <p>Total Guides</p>
    </div>
  </div>
</div>

<footer>
  &copy; 2025 Travel Your Way. Admin Panel.
</footer>

</body>
</html>
