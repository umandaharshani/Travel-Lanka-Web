<?php
// payment.php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "traveller";

// Create DB connection
$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success = false;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $tour_package = $_POST['tour_package'];
    $price = $_POST['price'];
    $cardholder_name = $_POST['cardholder_name'];
    $card_number = $_POST['card_number'];

    $stmt = $conn->prepare("INSERT INTO payments (name, email, tour_package, price, cardholder_name, card_number) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiss", $name, $email, $tour_package, $price, $cardholder_name, $card_number);
    $success = $stmt->execute();
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Payment Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f2f2f2;
      padding: 40px;
    }
    .form-container {
      max-width: 500px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
    }
    input, select {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    .btn {
      background: #27ae60;
      color: white;
      padding: 12px;
      border: none;
      width: 100%;
      border-radius: 6px;
      cursor: pointer;
    }
    .btn:hover {
      background: #219150;
    }
    .success {
      display: <?php echo $success ? 'block' : 'none'; ?>;
      background: #d4edda;
      color: #155724;
      padding: 15px;
      margin-top: 20px;
      text-align: center;
      border-radius: 6px;
      border: 1px solid #c3e6cb;
    }
  </style>
</head>
<body>

<div class="form-container">
  <h2>Tour Payment Form</h2>
  <form method="POST" action="">
    <label>Full Name</label>
    <input type="text" name="name" required>

    <label>Email Address</label>
    <input type="email" name="email" required>

    <label>Select Tour Package</label>
    <select name="tour_package" id="tour_package" onchange="updatePrice()" required>
      <option value="">-- Select Package --</option>
      <option value="Horton Plains Tour" data-price="140">Horton Plains Tour - $140</option>
      <option value="Sigiriya Day Tour" data-price="135">Sigiriya Day Tour - $135</option>
      <option value="Ella Adventure Tour" data-price="150">Ella Adventure Tour - $150</option>
      <option value="Galle City Tour" data-price="130">Galle City Tour - $130</option>
      <option value="Kandy City Tour" data-price="230">Kandy City Tour - $230</option>
    </select>

    <label>Tour Price (USD)</label>
    <input type="number" name="price" id="price" readonly required>

    <label>Cardholder Name</label>
    <input type="text" name="cardholder_name" required>

    <label>Card Number</label>
    <input type="text" name="card_number" maxlength="25" required>

    <button type="submit" class="btn">Submit Payment</button>
  </form>

  <div class="success">
    ✅ Payment submitted successfully!
  </div>
</div>

<script>
function updatePrice() {
  const select = document.getElementById("tour_package");
  const price = select.options[select.selectedIndex].getAttribute("data-price");
  document.getElementById("price").value = price ? price : '';
}
</script>

</body>
</html>
