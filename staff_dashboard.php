<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'staff') {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff Dashboard</title>
</head>
<body>
    <h2>Welcome Staff, <?php echo $_SESSION['username']; ?>!</h2>

    <ul>
        <li><a href="#">View Room Details</a></li>
        <li><a href="#">Submit Maintenance Request</a></li>
        <li><a href="#">View Hostel Rules</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>
