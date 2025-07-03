<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.html");
    exit;
}

include("db_connect.php");

// Join payment with student to get username
$query = "SELECT p.pay_id, p.pay_date, p.amount, p.description, s.username 
          FROM payment p
          INNER JOIN student s ON p.stu_id = s.stu_id";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Details</title>
    <link rel="stylesheet" href="Assets/style1.css">
</head>
<body>
    <h2>All Payment Details</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>Payment ID</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Description</th>
            <th>Username</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['pay_id']); ?></td>
            <td><?= htmlspecialchars($row['pay_date']); ?></td>
            <td><?= htmlspecialchars($row['amount']); ?></td>
            <td><?= htmlspecialchars($row['description']); ?></td>
            <td><?= htmlspecialchars($row['username']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <br>
    <a href="admin_dashboard.php">Back </a>
</body>
</html>

