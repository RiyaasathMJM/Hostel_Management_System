<?php
session_start();
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $room_no = $_POST['room_no'];
    $date = date('Y-m-d');
    $decision = "Pending";

    $stmt = $conn->prepare("INSERT INTO room_request (username, room_no, request_date, decision) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $room_no, $date, $decision);
    if ($stmt->execute()) {
        echo "<p>Request submitted successfully!</p>";
    } else {
        echo "<p>Failed to submit request.</p>";
    }
}
?>

<h2>Submit Room Request</h2>
<form method="post">
    Room No: <input type="text" name="room_no" required><br>
    <input type="submit" value="Submit Request">
</form>
<a href="<?php echo ($_SESSION['user_type'] === 'student') ? 'student_dashboard.php' : 'staff_dashboard.php'; ?>">Back</a>
