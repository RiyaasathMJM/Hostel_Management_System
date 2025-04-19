<?php
include 'db.php';

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];

    if ($action == "accept") {
        $sql = "UPDATE room_requests SET status = 'accepted' WHERE id = $id";
    } elseif ($action == "decline") {
        $sql = "UPDATE room_requests SET status = 'declined' WHERE id = $id";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Request has been $action" . "ed.<br>";
    } else {
        echo "Error updating request.";
    }

    echo "<a href='dashboard_admin.php'>Go Back</a>";
}
