<?php
session_start();
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $room_no = $_POST['room_no'];
    $request_date = date('Y-m-d');
    $decision = 'Pending';

    $stmt = $conn->prepare("INSERT INTO room_request (username, room_no, request_date, decision)
                            VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $username, $room_no, $request_date, $decision);

    if ($stmt->execute()) {
        echo "Room request submitted successfully!";
    } else {
        echo "Failed to submit request.";
    }

    echo '<br><a href="' . ($_SESSION['user_type'] === 'student' ? 'student_dashboard.php' : 'staff_dashboard.php') . '">Back to Dashboard</a>';
    exit;
}
?>

<h2>Request a Room</h2>
<form method="post" action="">
    Room Number: <input type="number" name="room_no" required><br><br>
    <button type="submit">Submit Request</button>
</form>

<a href="<?php echo ($_SESSION['user_type'] === 'student') ? 'student_dashboard.php' : 'staff_dashboard.php'; ?>">Cancel</a>

