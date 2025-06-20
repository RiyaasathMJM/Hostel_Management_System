<?php
session_start();
include("db_connect.php");

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $room_no = $_POST['room_no'];
    $date = date('Y-m-d');

    // Handle image upload
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir);
    }
    $target_file = $target_dir . basename($_FILES["receipt"]["name"]);
    move_uploaded_file($_FILES["receipt"]["tmp_name"], $target_file);

    // Insert request into table (for admin approval)
    $stmt = $conn->prepare("INSERT INTO payment_request (username, pay_date, amount, description, room_no, receipt_image, status)
                            VALUES (?, ?, ?, ?, ?, ?, 'Pending')");
    $stmt->bind_param("ssdsss", $username, $date, $amount, $description, $room_no, $target_file);
    
    if ($stmt->execute()) {
        echo "Payment submitted successfully! Awaiting admin approval.<br>";
    } else {
        echo "Submission failed.";
    }

    echo '<a href="student_dashboard.php">Back to Dashboard</a>';
    exit;
}
?>

<!DOCTYPE html>
<html>
<head><title>Submit Payment</title></head>
<body>
<h2>Submit Payment</h2>
<form method="post" enctype="multipart/form-data">
    Amount (Rs.): <input type="number" name="amount" required><br><br>
    Description: <input type="text" name="description" required><br><br>
    Room No: <input type="number" name="room_no" required><br><br>
    Upload Receipt: <input type="file" name="receipt" accept="image/*,.pdf" required><br><br>
    <input type="submit" value="Submit">
</form>
<br>
<a href="view_payment_info.php">Back</a>
</body>
</html>
