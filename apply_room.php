<?php
session_start();
include 'db.php';

if (!isset($_SESSION['student_id']) || $_SESSION['user_type'] !== 'student') {
    header("Location: index.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$room_no = $_POST['room_no'];

// Check if there's already a pending request
$check = $conn->query("SELECT * FROM room_requests WHERE student_id = '$student_id' AND status = 'pending'");
if ($check->num_rows > 0) {
    echo "You already have a pending room request.<br><a href='dashboard_student.php'>Back</a>";
    exit();
}

// Insert the request
$sql = "INSERT INTO room_requests (student_id, room_no) VALUES ('$student_id', '$room_no')";
if ($conn->query($sql) === TRUE) {
    echo "Room request submitted successfully.<br><a href='dashboard_student.php'>Back to Dashboard</a>";
} else {
    echo "Error: " . $conn->error;
}
