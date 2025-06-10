<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Welcome Admin, <?php echo $_SESSION['username']; ?>!</h2>

    <ul>
        <li><a href="#">Manage Room Allocations</a></li>
        <li><a href="#">Approve Requests</a></li>
        <li><a href="#">Contact Students</a></li>
        <li><a href="#">View All Students</a></li>
        <li><a href="#">View Staff</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>
