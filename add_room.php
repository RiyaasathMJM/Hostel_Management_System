<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_no = $_POST['room_no'];

    $check = $conn->query("SELECT * FROM rooms WHERE room_no = '$room_no'");
    if ($check->num_rows > 0) {
        echo "Room already exists.<br>";
    } else {
        $sql = "INSERT INTO rooms (room_no) VALUES ('$room_no')";
        if ($conn->query($sql) === TRUE) {
            echo "Room $room_no added successfully.<br>";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    echo "<a href='dashboard_admin.php'>Go Back</a>";
}
?>
