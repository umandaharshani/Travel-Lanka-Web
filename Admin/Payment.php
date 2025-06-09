<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "traveller";

$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$fromDate = $_GET['from_date'] ?? '';
$toDate = $_GET['to_date'] ?? '';

$whereClause = "";
if ($fromDate && $toDate) {
    $whereClause = "WHERE DATE(payment_date) BETWEEN '$fromDate' AND '$toDate'";
}

$sql = "SELECT * FROM payments $whereClause ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Payment Records</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      padding: 40px;
    }

    h2 {
      text-align: center;
    }

    .container {
      max-width: 1100px;
      margin: auto;
    }

    form {
      margin-bottom: 20px;
      text-align: center;
    }

    input[type="date"] {
      padding: 8px;
      margin: 0 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button {
      padding: 8px 16px;
      background-color: #27ae60;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    table {
      border-collapse: collapse;
      width: 100%;
      background-color: #fff;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #27ae60;
      color: white;
    }

    tr:hover {
      background-color: #f1f1f1;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Payment Details</h2>

  <form method="GET" action="">
    <label>From: <input type="date" name="from_date" value="<?= htmlspecialchars($fromDate) ?>"></label>
    <label>To: <input type="date" name="to_date" value="<?= htmlspecialchars($toDate) ?>"></label>
    <button type="submit">Search</button>
  </form>

  <?php if ($result && $result->num_rows > 0): ?>
    <table>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Tour Package</th>
        <th>Price (USD)</th>
        <th>Cardholder Name</th>
        <th>Card Number</th>
        <th>Payment Date</th>
      </tr>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['tour_package']) ?></td>
          <td><?= number_format($row['price'], 2) ?></td>
          <td><?= htmlspecialchars($row['cardholder_name']) ?></td>
          <td><?= htmlspecialchars($row['card_number']) ?></td>
          <td><?= $row['payment_date'] ?></td>
        </tr>
      <?php endwhile; ?>
    </table>
  <?php else: ?>
    <p style="text-align:center;">No payment records found for selected date range.</p>
  <?php endif; ?>

</div>

</body>
</html>

<?php $conn->close(); ?>
