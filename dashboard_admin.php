<?php
session_start();
include 'db.php';

if (!isset($_SESSION['student_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>

<h2>Welcome, Admin!</h2>

<!-- Room Requests Section -->
<h3>Pending Room Requests</h3>
<?php
$sql = "SELECT * FROM room_requests WHERE status = 'pending'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($req = $result->fetch_assoc()) {
        echo "Student ID: " . $req['student_id'] . "<br>";
        echo "Requested Room No: " . $req['room_no'] . "<br>";
        echo "<a href='process_request.php?action=accept&id={$req['id']}'>Accept</a> | ";
        echo "<a href='process_request.php?action=decline&id={$req['id']}'>Decline</a><hr>";
    }
} else {
    echo "No pending requests.";
}
?>
<!-- Room Assignment Form -->
<h3>Assign Room to Student</h3>
<form method="post" action="assign_room.php">
    Student ID: <input type="text" name="student_id" required><br>
    Room No: <input type="text" name="room_no" required><br>
    <button type="submit">Assign Room</button>
</form>


<!-- Room Availability -->
<h3>Room Management</h3>
<?php
$sql = "SELECT * FROM rooms";
$result = $conn->query($sql);

while ($room = $result->fetch_assoc()) {
    echo "Room No: " . $room['room_no'] . " | ";
    echo $room['is_available'] ? "Available" : "Assigned to " . $room['assigned_to'];
    echo "<br>";
}
?>

<!-- Payment Overview -->
<h3>All Payment Records</h3>
<?php
$sql = "SELECT * FROM payments ORDER BY payment_date DESC";
$result = $conn->query($sql);

while ($payment = $result->fetch_assoc()) {
    echo "Student: " . $payment['student_id'] . " | ";
    echo "Room: " . $payment['room_no'] . " | ";
    echo "Amount: $" . $payment['amount'] . " | ";
    echo "Date: " . $payment['payment_date'] . "<br>";
}
?>
<!-- Payment Entry Form -->
<h3>Add Payment</h3>
<form method="post" action="add_payment.php">
    Student ID: <input type="text" name="student_id" required><br>
    Room No: <input type="text" name="room_no" required><br>
    Amount: <input type="number" step="0.01" name="amount" required><br>
    <button type="submit">Add Payment</button>
</form>

<!-- Add New Room -->
<h3>Add New Room</h3>
<form method="post" action="add_room.php">
    Room No: <input type="text" name="room_no" required><br>
    <button type="submit">Add Room</button>
</form>


<!-- Optional: Logout -->
<br>
<a href="logout.php">Logout</a>