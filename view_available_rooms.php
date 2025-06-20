<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}

$query = "SELECT room_no, hostel_no, availability, current_members FROM room ORDER BY hostel_no, room_no";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Available Rooms</title>
</head>
<body>
    <h2>All Room Details</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>Room No</th>
            <th>Hostel No</th>
            <th>Availability</th>
            <th>Current Members</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['room_no']); ?></td>
                <td><?php echo htmlspecialchars($row['hostel_no']); ?></td>
                <td><?php echo htmlspecialchars($row['availability']); ?></td>
                <td><?php echo htmlspecialchars($row['current_members']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <br>
    <a href="submit_request.php">Back to Room Request</a>
</body>
</html>
