<?php
// payment_analysis.php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "traveller";

// Create connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- PIE CHART: Total by Tour Package ---
$pieLabels = [];
$pieTotals = [];
$pieQuery = "SELECT tour_package, SUM(price) AS total FROM payments GROUP BY tour_package";
$pieResult = $conn->query($pieQuery);

if ($pieResult && $pieResult->num_rows > 0) {
    while ($row = $pieResult->fetch_assoc()) {
        $pieLabels[] = $row['tour_package'];
        $pieTotals[] = $row['total'];
    }
}

// --- BAR CHART: Total by Date ---
$barLabels = [];
$barTotals = [];
$barQuery = "SELECT DATE(payment_date) as date, SUM(price) as total FROM payments GROUP BY DATE(payment_date) ORDER BY DATE(payment_date)";
$barResult = $conn->query($barQuery);

if ($barResult && $barResult->num_rows > 0) {
    while ($row = $barResult->fetch_assoc()) {
        $barLabels[] = $row['date'];
        $barTotals[] = $row['total'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Analysis Charts</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 40px;
            text-align: center;
        }
        h2 {
            margin-top: 50px;
        }
        .chart-container {
            width: 90%;
            max-width: 800px;
            margin: 30px auto;
        }
    </style>
</head>
<body>

<h1>Payment Analysis Dashboard</h1>

<!-- Pie Chart -->
<div class="chart-container">
    <h2>Tour Package Breakdown (Pie Chart)</h2>
    <canvas id="pieChart"></canvas>
</div>

<!-- Horizontal Bar Chart -->
<div class="chart-container">
    <h2>Total Payments by Date (Horizontal Bar Chart)</h2>
    <canvas id="barChart"></canvas>
</div>

<script>
    // PIE CHART
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: <?= json_encode($pieLabels) ?>,
            datasets: [{
                data: <?= json_encode($pieTotals) ?>,
                backgroundColor: [
                    '#3498db', '#2ecc71', '#e74c3c', '#9b59b6', '#f1c40f', '#1abc9c'
                ],
                borderColor: '#fff',
                borderWidth: 2
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

    // HORIZONTAL BAR CHART
    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($barLabels) ?>,
            datasets: [{
                label: 'Total Payment (USD)',
                data: <?= json_encode($barTotals) ?>,
                backgroundColor: '#2ecc71',
                borderRadius: 6
            }]
        },
        options: {
            indexAxis: 'y', // horizontal bar chart
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Total (USD)'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Date'
                    }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>

</body>
</html>

<?php $conn->close(); ?>
