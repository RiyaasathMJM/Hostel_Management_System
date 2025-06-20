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
        
        <li><a href="approve_requests.php">Room Approve Requests and View</a></li>
        <li><a href="payment_management.php">Payment Management</li>
        <li><a href="maintenance_management.php">Maintenance and Suggesion Requests</a></li>
         

        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>
