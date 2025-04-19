<?php
session_start();
include 'db.php';

if (!isset($_SESSION['student_id']) || $_SESSION['user_type'] !== 'student') {
    header("Location: index.php");
    exit();
}

$student_id = $_SESSION['student_id'];
?>

<h2>Welcome, <?php echo $student_id; ?>!</h2>

<!-- Room Request Status -->
<h3>Room Request Status</h3>
<?php
$sql = "SELECT * FROM room_requests WHERE student_id = '$student_id' ORDER BY request_date DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $request = $result->fetch_assoc();
    echo "Requested Room No: " . $request['room_no'] . "<br>";
    echo "Status: " . ucfirst($request['status']) . "<br>";
} else {
    echo "No room request found.<br>";
}
?>

<!-- Assigned Room Details -->
<h3>Assigned Room</h3>
<?php
$sql = "SELECT room_no FROM rooms WHERE assigned_to = '$student_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $room = $result->fetch_assoc();
    echo "Assigned Room No: " . $room['room_no'] . "<br>";
} else {
    echo "No room assigned yet.<br>";
}
?>

<!-- Payment Details -->
<h3>Payment Details</h3>
<?php
$sql = "SELECT * FROM payments WHERE student_id = '$student_id' ORDER BY payment_date DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($payment = $result->fetch_assoc()) {
        echo "Room No: " . $payment['room_no'] . "<br>";
        echo "Amount: $" . $payment['amount'] . "<br>";
        echo "Date: " . $payment['payment_date'] . "<br><hr>";
    }
} else {
    echo "No payments found.<br>";
}
?>
<!-- Apply for Room -->
<h3>Apply for Room</h3>
<form method="post" action="apply_room.php">
    Desired Room No: <input type="text" name="room_no" required><br>
    <button type="submit">Apply</button>
</form>


<!-- Optional: Logout Button -->
<br>
<a href="logout.php">Logout</a>