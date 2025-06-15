<?php
session_start();
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $room_no = $_POST['room_no'];
    $issue = $_POST['issue'];
    $date = date('Y-m-d');

    $stmt = $conn->prepare("INSERT INTO maintenance_requests (username, room_no, issue, request_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $room_no, $issue, $date);
    if ($stmt->execute()) {
        echo "<p>Maintenance request submitted!</p>";
    } else {
        echo "<p>Submission failed.</p>";
    }
}
?>

<h2>Submit Maintenance Request</h2>
<form method="post">
    Room No: <input type="text" name="room_no" required><br>
    Issue Description: <textarea name="issue" required></textarea><br>
    <input type="submit" value="Submit Request">
</form>
<a href="<?php echo ($_SESSION['user_type'] === 'student') ? 'student_dashboard.php' : 'staff_dashboard.php'; ?>">Back</a>
