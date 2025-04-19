<?php
include 'db.php';
session_start();

// Handle Signup
if (isset($_POST['signup'])) {
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user_type = $_POST['user_type']; // student or admin

    $sql = "INSERT INTO users (name, student_id, email, password, user_type)
            VALUES ('$name', '$student_id', '$email', '$password', '$user_type')";

    if ($conn->query($sql) === TRUE) {
        echo "Signup successful! You can now log in.";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Handle Login
if (isset($_POST['login'])) {
    $student_id = $_POST['login_student_id'];
    $password = $_POST['login_password'];

    $sql = "SELECT * FROM users WHERE student_id = '$student_id'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['student_id'] = $student_id;
            $_SESSION['user_type'] = $user['user_type'];

            if ($user['user_type'] == 'admin') {
                header("Location: dashboard_admin.php");
            } else {
                header("Location: dashboard_student.php");
            }
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }
}
?>

<!-- Signup Form -->
<h2>Signup</h2>
<form method="post">
    <input type="text" name="name" placeholder="Name" required><br>
    <input type="text" name="student_id" placeholder="Student ID" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <select name="user_type">
        <option value="student">Student</option>
        <option value="admin">Admin</option>
    </select><br>
    <button type="submit" name="signup">Sign Up</button>
</form>

<hr>

<!-- Login Form -->
<h2>Login</h2>
<form method="post">
    <input type="text" name="login_student_id" placeholder="Student ID" required><br>
    <input type="password" name="login_password" placeholder="Password" required><br>
    <button type="submit" name="login">Login</button>
</form>