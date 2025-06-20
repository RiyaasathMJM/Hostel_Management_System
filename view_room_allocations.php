<?php
session_start();
include("db_connect.php");

$result = $conn->query("SELECT * FROM room_allocation");
?>

<h2>Room Allocations</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>Allocation ID</th><th>Room No</th><th>Username</th><th>Date</th><th>Admin ID</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['allocation_id']; ?></td>
        <td><?= $row['room_no']; ?></td>
        <td><?= $row['username']; ?></td>
        <td><?= $row['date']; ?></td>
        <td><?= $row['admin_id']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>
<a href="admin_dashboard.php">Back</a>
