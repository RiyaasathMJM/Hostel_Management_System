<?php
session_start();
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_type = $_POST['user_type'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    switch ($user_type) {
        case "student":
            $query = "SELECT * FROM student WHERE username=?";
            break;
        case "staff":
            $query = "SELECT * FROM staff WHERE username=?";
            break;
        case "admin":
            $query = "SELECT * FROM admin WHERE username=?";
            break;
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_type'] = $user_type;
            $_SESSION['username'] = $username;

            // Redirect to respective dashboards
            switch ($user_type) {
                case "student":
                    header("Location: student_dashboard.php");
                    break;
                case "staff":
                    header("Location: staff_dashboard.php");
                    break;
                case "admin":
                    header("Location: admin_dashboard.php");
                    break;
            }
            exit;
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }
}
?>

