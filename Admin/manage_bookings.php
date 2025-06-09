<?php
$hostname = "localhost";
$username = "root";
$password = "";
$db = "traveller";

$con = new mysqli($hostname, $username, $password, $db);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Handle accept/reject actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookingId = $_POST['booking_id'];
    
    if (isset($_POST['accept'])) {
        $guide = $_POST['guide_name'];
        $sql = "UPDATE booking SET status='Accepted', guide_name='$guide' WHERE id=$bookingId";
        $con->query($sql);
    } elseif (isset($_POST['reject'])) {
        $sql = "UPDATE booking SET status='Rejected', guide_name=NULL WHERE id=$bookingId";
        $con->query($sql);
    }
}

// Get all bookings
$result = $con->query("SELECT * FROM booking ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Bookings</title>
    <style>
        body {
            font-family: Arial;
            background: #f5f5f5;
            padding: 40px;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        th {
            background: #2980b9;
            color: white;
        }
        form {
            display: inline;
        }
        select, button {
            padding: 6px;
        }
        .status {
            font-weight: bold;
            text-transform: uppercase;
        }
        .Accepted {
            color: green;
        }
        .Rejected {
            color: red;
        }
        .Pending {
            color: orange;
        }
    </style>
</head>
<body>

<h2>Admin Booking Management</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Destination</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Duration</th>
        <th>Persons</th>
        <th>Status</th>
        <th>Guide</th>
        <th>Action</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['date'] ?></td>
            <td><?= $row['destination'] ?></td>
            <td><?= htmlspecialchars($row['fname']) ?></td>
            <td><?= $row['tp'] ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= $row['days'] ?></td>
            <td><?= $row['persons'] ?></td>
            <td class="status <?= $row['status'] ?>"><?= $row['status'] ?></td>
            <td><?= $row['guide_name'] ?? '—' ?></td>
            <td>
                <?php if ($row['status'] == 'Pending'): ?>
                    <form method="POST">
                        <input type="hidden" name="booking_id" value="<?= $row['id'] ?>">
                        <select name="guide_name" required>
                            <option value="">Select Guide</option>
                            <option value="John Silva">John Silva</option>
                            <option value="Kamal Perera">Kamal Perera</option>
                            <option value="Samantha Wijesinghe">Samantha Wijesinghe</option>
                            <option value="Nuwan Bandara">Nuwan Bandara</option>
                        </select>
                        <button type="submit" name="accept">Accept</button>
                        <button type="submit" name="reject">Reject</button>
                    </form>
                <?php else: ?>
                    —
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>

<?php $con->close(); ?>
