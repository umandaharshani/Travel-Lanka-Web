<?php
// DB connection
$hostname = "localhost";
$username = "root";
$password = "";
$db = "traveller";

$con = new mysqli($hostname, $username, $password, $db);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Fetch all customers
$sql = "SELECT * FROM registration";
$result = $con->query($sql);

// Gender count for Chart
$genderCounts = [
    'male' => 0,
    'female' => 0,
    'unknown' => 0
];

$genderQuery = "SELECT gender, COUNT(*) as count FROM registration GROUP BY gender";
$genderResult = $con->query($genderQuery);
while ($row = $genderResult->fetch_assoc()) {
    $gender = strtolower($row['gender']);
    if (array_key_exists($gender, $genderCounts)) {
        $genderCounts[$gender] = $row['count'];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registered Customers</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        header {
            background: #2c3e50;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .container {
            margin: 40px auto;
            width: 90%;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #34495e;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .chart-container {
            margin: 50px auto;
            width: 60%;
        }
    </style>
</head>
<body>

<header>
    <h1>Registered Customer Details</h1>
</header>

<div class="container">
    <h2>Customer List</h2>
    <table>
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone No</th>
                <th>Gender</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['fname']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phoneno']); ?></td>
                        <td><?php echo htmlspecialchars(ucfirst($row['gender'])); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5">No registrations found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="chart-container">
        <h2 style="text-align:center;">Gender Distribution of Registered Users</h2>
        <canvas id="genderChart"></canvas>
    </div>
</div>

<script>
    const ctx = document.getElementById('genderChart').getContext('2d');
    const genderChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Male', 'Female', 'Prefer not to say'],
            datasets: [{
                data: [<?php echo $genderCounts['male']; ?>, <?php echo $genderCounts['female']; ?>, <?php echo $genderCounts['unknown']; ?>],
                backgroundColor: ['#3498db', '#e74c3c', '#95a5a6'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>

</body>
</html>
