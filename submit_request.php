<?php
session_start();
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['username'])) {
        header("Location: login.html");
        exit;
    }

    $username = $_SESSION['username'];
    $room_no = $_POST['room_no'];
    $request_date = date('Y-m-d');  // Matches 'request_date' column
    $decision = "Pending";

    // Correct column names: username, room_no, request_date, decision
    $stmt = $conn->prepare("INSERT INTO room_request (username, room_no, request_date, decision) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $room_no, $request_date, $decision);

    if ($stmt->execute()) {
        echo "<p>Request submitted successfully!</p>";
    } else {
        echo "<p>Failed to submit request. Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<h2>Submit Room Request</h2>
<form method="post">
    Room No: <input type="text" name="room_no" required><br>
    <input type="submit" value="Submit Request">
</form>

<a href="view_available_rooms.php">View Available Rooms</a><br>
<a href="<?php echo ($_SESSION['user_type'] === 'student') ? 'student_dashboard.php' : 'staff_dashboard.php'; ?>">Back</a>


