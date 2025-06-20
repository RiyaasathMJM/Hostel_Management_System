<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.html");
    exit;
}

$admin_username = $_SESSION['username'];

// Get admin_id
$adminQuery = "SELECT admin_id FROM admin WHERE username = ?";
$adminStmt = $conn->prepare($adminQuery);
$adminStmt->bind_param("s", $admin_username);
$adminStmt->execute();
$adminResult = $adminStmt->get_result();
$adminRow = $adminResult->fetch_assoc();
$admin_id = $adminRow['admin_id'];

// Handle approval
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $room_no = $_POST['room_no'];
    $username = $_POST['username'];

    if (isset($_POST['approve'])) {
        $date = date("Y-m-d");

        // Check current members
        $checkQuery = "SELECT current_members FROM room WHERE room_no = ?";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bind_param("s", $room_no);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        $roomData = $checkResult->fetch_assoc();
        $current_members = $roomData['current_members'];

        if ($current_members >= 4) {
            echo "<p>Room $room_no is full!</p>";
        } else {
            // Insert into room_allocation
            $insert = $conn->prepare("INSERT INTO room_allocation (room_no, username, date, admin_id) VALUES (?, ?, ?, ?)");
            $insert->bind_param("sssi", $room_no, $username, $date, $admin_id);
            $insert->execute();

            // Update room table
            $new_members = $current_members + 1;
            $availability = ($new_members >= 4) ? 'No' : 'Yes';

            $updateRoom = $conn->prepare("UPDATE room SET current_members = ?, availability = ? WHERE room_no = ?");
            $updateRoom->bind_param("iss", $new_members, $availability, $room_no);
            $updateRoom->execute();

            // Update request decision
            $updateRequest = $conn->prepare("UPDATE room_request SET decision = 'Accepted' WHERE username = ? AND room_no = ?");
            $updateRequest->bind_param("ss", $username, $room_no);
            $updateRequest->execute();

            echo "<p>Request approved and allocation completed.</p>";
        }
    } elseif (isset($_POST['reject'])) {
        // Reject logic
        $rejectStmt = $conn->prepare("UPDATE room_request SET decision = 'Rejected' WHERE username = ? AND room_no = ?");
        $rejectStmt->bind_param("ss", $username, $room_no);
        $rejectStmt->execute();

        echo "<p>Request rejected.</p>";
    }
}

// Fetch pending requests
$requestQuery = "SELECT * FROM room_request WHERE decision = 'Pending'";
$requests = $conn->query($requestQuery);
?>

<h2>Room Approval Requests</h2>
<table border="1">
    <tr>
        <th>Username</th>
        <th>Room No</th>
        <th>Request Date</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $requests->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['username']); ?></td>
            <td><?php echo htmlspecialchars($row['room_no']); ?></td>
            <td><?php echo $row['request_date']; ?></td>
            <td>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="username" value="<?php echo $row['username']; ?>">
                    <input type="hidden" name="room_no" value="<?php echo $row['room_no']; ?>">
                    <input type="submit" name="approve" value="Accept">
                    <input type="submit" name="reject" value="Reject">
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<br>
<a href="admin_dashboard.php">Back to Dashboard</a>
