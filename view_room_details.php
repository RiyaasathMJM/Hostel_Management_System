<?php
session_start();
include("db_connect.php");

$username = $_SESSION['username'];
echo "<p>Logged in as: $username</p>"; // Debug

$query = "SELECT r.room_no, r.hostel_no, r.availability
          FROM room_allocation ra
          JOIN room r ON ra.room_no = r.room_no
          WHERE ra.username = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
?>

<h2>Your Room Details</h2>
<?php if ($row = $result->fetch_assoc()): ?>
    <p>Room Number: <?php echo $row['room_no']; ?></p>
    <p>Hostel Number: <?php echo $row['hostel_no']; ?></p>
    <p>Availability: <?php echo $row['availability']; ?></p>
<?php else: ?>
    <p>No room allocated yet. Please check with admin.</p>
<?php endif; ?>

<a href="<?php echo ($_SESSION['user_type'] === 'student') ? 'student_dashboard.php' : 'staff_dashboard.php'; ?>">Back</a>




