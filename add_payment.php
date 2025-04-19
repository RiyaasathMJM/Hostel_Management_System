<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $room_no = $_POST['room_no'];
    $amount = $_POST['amount'];

    $sql = "INSERT INTO payments (student_id, room_no, amount)
            VALUES ('$student_id', '$room_no', '$amount')";

    if ($conn->query($sql) === TRUE) {
        echo "Payment added successfully.<br>";
    } else {
        echo "Error: " . $conn->error;
    }

    echo "<a href='dashboard_admin.php'>Go Back</a>";
}
