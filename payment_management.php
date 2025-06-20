<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.html");
    exit;
}

// Handle approval
if (isset($_POST['approve'])) {
    $request_id = $_POST['request_id'];

    // Fetch the payment request
    $query = "SELECT * FROM payment_request WHERE request_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $username = $row['username'];
        $pay_date = $row['pay_date'];
        $amount = $row['amount'];
        $description = $row['description'];
        $room_no = $row['room_no'];

        // Get stu_id
        $stuStmt = $conn->prepare("SELECT stu_id FROM student WHERE username = ?");
        $stuStmt->bind_param("s", $username);
        $stuStmt->execute();
        $stuResult = $stuStmt->get_result();

        if ($stuRow = $stuResult->fetch_assoc()) {
            $stu_id = $stuRow['stu_id'];

            // Insert into payment table
            $insert = $conn->prepare("INSERT INTO payment (pay_date, amount, description, room_no, stu_id) VALUES (?, ?, ?, ?, ?)");
            $insert->bind_param("sdssi", $pay_date, $amount, $description, $room_no, $stu_id);
            $insert->execute();

            // Update request status to Accepted
            $update = $conn->prepare("UPDATE payment_request SET status = 'Accepted' WHERE request_id = ?");
            $update->bind_param("i", $request_id);
            $update->execute();
        }
    }
}

// Handle rejection
if (isset($_POST['reject'])) {
    $request_id = $_POST['request_id'];
    $update = $conn->prepare("UPDATE payment_request SET status = 'Rejected' WHERE request_id = ?");
    $update->bind_param("i", $request_id);
    $update->execute();
}

// Fetch pending and rejected requests
$query = "SELECT * FROM payment_request WHERE status IN ('Pending', 'Rejected') ORDER BY pay_date DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Management</title>
</head>
<body>
<h2>Payment Requests</h2>
<table border="1">
    <tr>
        <th>Username</th>
        <th>Pay Date</th>
        <th>Amount</th>
        <th>Description</th>
        <th>Room No</th>
        <th>Receipt</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['pay_date']; ?></td>
            <td><?php echo $row['amount']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['room_no']; ?></td>
            <td><a href="<?php echo $row['receipt_image']; ?>" target="_blank">View</a></td>
            <td><?php echo $row['status']; ?></td>
            <td>
                <?php if ($row['status'] === 'Pending'): ?>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="request_id" value="<?php echo $row['request_id']; ?>">
                        <button type="submit" name="approve">Approve</button>
                        <button type="submit" name="reject">Reject</button>
                    </form>
                <?php else: ?>
                    <?php echo $row['status']; ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
<br>
<a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>

