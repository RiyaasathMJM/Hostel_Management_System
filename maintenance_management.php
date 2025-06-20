<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.html");
    exit;
}

// Handle status update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $request_id = $_POST['request_id'];
    $new_status = $_POST['status'];

    $updateStmt = $conn->prepare("UPDATE maintenance_requests SET status = ? WHERE request_id = ?");
    $updateStmt->bind_param("si", $new_status, $request_id);
    $updateStmt->execute();
}

// Fetch all maintenance requests
$query = "SELECT * FROM maintenance_requests ORDER BY request_date DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Maintenance Requests</title>
</head>
<body>
    <h2>Maintenance Requests</h2>

    <?php if ($result->num_rows > 0): ?>
        <table border="1" cellpadding="10">
            <tr>
                <th>Request ID</th>
                <th>Username</th>
                <th>Room No</th>
                <th>Issue</th>
                <th>Request Date</th>
                <th>Status</th>
                <th>Update</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <form method="post">
                        <td><?php echo htmlspecialchars($row['request_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['room_no']); ?></td>
                        <td><?php echo htmlspecialchars($row['issue']); ?></td>
                        <td><?php echo htmlspecialchars($row['request_date']); ?></td>
                        <td>
                            <select name="status">
                                <option value="Pending" <?php if ($row['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                <option value="In Progress" <?php if ($row['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
                                <option value="Resolved" <?php if ($row['status'] == 'Resolved') echo 'selected'; ?>>Resolved</option>
                            </select>
                        </td>
                        <td>
                            <input type="hidden" name="request_id" value="<?php echo $row['request_id']; ?>">
                            <input type="submit" name="update_status" value="Update">
                        </td>
                    </form>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No maintenance requests found.</p>
    <?php endif; ?>

    <br>
    <a href="admin_dashboard.php">Back</a>
</body>
</html>
