<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student') {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
</head>
<body>
    <h2>Welcome Student, <?php echo $_SESSION['username']; ?>!</h2>

    <ul>
        <li><a href="view_room_details.php">View Room Details</a></li>
        <li><a href="view_payment_info.php">View Payment Info</a></li>
        <li><a href="submit_request.php">Submit Request</a></li>
        <li><a href="view_hostel_rules.php">View Hostel Rules</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>
