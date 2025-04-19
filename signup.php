<?php include 'db.php'; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user_type = $_POST['user_type']; // student or admin

    $sql = "INSERT INTO users (name, student_id, email, password, user_type)
            VALUES ('$name', '$student_id', '$email', '$password', '$user_type')";

    if ($conn->query($sql) === TRUE) {
        echo "Signup successful! <a href='index.php'>Login Now</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<form method="post">
    <h2>Signup Form</h2>
    <input type="text" name="name" placeholder="Name" required><br>
    <input type="text" name="student_id" placeholder="Student ID" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <select name="user_type">
        <option value="student">Student</option>
        <option value="admin">Admin</option>
    </select><br>
    <button type="submit">Signup</button>
</form>