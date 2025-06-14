<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}

$username = $_SESSION['username'];

// Fetch stu_id using username
$stuQuery = "SELECT stu_id FROM student WHERE username = ?";
$stuStmt = $conn->prepare($stuQuery);
$stuStmt->bind_param("s", $username);
$stuStmt->execute();
$stuResult = $stuStmt->get_result();
$stuRow = $stuResult->fetch_assoc();

if (!$stuRow) {
    echo "Student not found.";
    exit;
}

$stu_id = $stuRow['stu_id'];

// Now fetch payment details
$query = "SELECT pay_date, amount, description, room_no FROM payment WHERE stu_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $stu_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head><title>Payment Information</title></head>
<body>
<h2>Your Payment Info</h2>
<table border="1">
    <tr>
        <th>Date</th>
        <th>Amount (Rs.)</th>
        <th>Description</th>
        <th>Room No</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['pay_date']; ?></td>
        <td><?php echo $row['amount']; ?></td>
        <td><?php echo $row['description']; ?></td>
        <td><?php echo $row['room_no']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<br>
<a href="student_dashboard.php">Back to Dashboard</a>
</body>
</html>

