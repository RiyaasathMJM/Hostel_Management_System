<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $room_no = $_POST['room_no'];

    // Check if room is available
    $check = $conn->query("SELECT * FROM rooms WHERE room_no = '$room_no' AND is_available = 1");

    if ($check->num_rows > 0) {
        // Assign room
        $assign = $conn->query("UPDATE rooms SET is_available = 0, assigned_to = '$student_id' WHERE room_no = '$room_no'");
        if ($assign) {
            echo "Room $room_no assigned to $student_id successfully.<br>";
        } else {
            echo "Error assigning room.<br>";
        }
    } else {
        echo "Room is not available or does not exist.<br>";
    }

    echo "<a href='dashboard_admin.php'>Go Back</a>";
}
