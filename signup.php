<?php include 'db.php'; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user_type = $_POST['user_type'];
    $admin_verification = $_POST['admin_verification'] ?? '';

    if ($user_type === 'admin' && $admin_verification !== '1234') {
        echo "Invalid admin verification password.";
    } else {
        $sql = "INSERT INTO users (name, student_id, email, password, user_type)
                VALUES ('$name', '$student_id', '$email', '$password', '$user_type')";

        if ($conn->query($sql) === TRUE) {
            echo "Signup successful! <a href='index.php'>Login Now</a>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<form method="post">
    <h2>Signup Form</h2>
    <input type="text" name="name" placeholder="Name" required><br>
    <input type="text" name="student_id" placeholder="Student ID" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>

    <select name="user_type" id="user_type" required>
        <option value="student">Student</option>
        <option value="admin">Admin</option>
    </select><br>

    <div id="admin_field" style="display:none;">
        <input type="password" name="admin_verification" placeholder="Admin Verification Password"><br>
    </div>

    <button type="submit">Signup</button>
</form>

<!-- Back to Login Link -->
<p>Already have an account? <a href="index.php">Back to Login</a></p>

<script>
document.getElementById('user_type').addEventListener('change', function () {
    const adminField = document.getElementById('admin_field');
    adminField.style.display = this.value === 'admin' ? 'block' : 'none';
});
</script>
