<?php
session_start();
include("db_connect.php");

$result = $conn->query("SELECT * FROM staff");
?>

<h2>Staff Details</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>ID</th><th>Name</th><th>Department</th><th>Gender</th><th>Email</th><th>Contact</th><th>Username</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['staff_id']; ?></td>
        <td><?= $row['name']; ?></td>
        <td><?= $row['department']; ?></td>
        <td><?= $row['gender']; ?></td>
        <td><?= $row['email']; ?></td>
        <td><?= $row['contact_no']; ?></td>
        <td><?= $row['username']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>
<a href="admin_dashboard.php">Back</a>
