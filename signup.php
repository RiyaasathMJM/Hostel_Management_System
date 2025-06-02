<?php
include("db_connect.php");

function registerStudent($conn) {
    $name = $_POST['s_name'];
    $department = $_POST['s_department'];
    $gender = $_POST['s_gender'];
    $address = $_POST['s_address'];
    $contact_no = $_POST['s_contact_no'];
    $year = $_POST['s_year'];
    $email = $_POST['s_email'];
    $username = $_POST['s_username'];
    $password = password_hash($_POST['s_password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO student (name, department, gender, address, contact_no, year_of_study, email, username, password)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $name, $department, $gender, $address, $contact_no, $year, $email, $username, $password);
    return $stmt->execute() ? "Student registered successfully!" : "Student registration failed.";
}

function registerStaff($conn) {
    $name = $_POST['st_name'];
    $department = $_POST['st_department'];
    $gender = $_POST['st_gender'];
    $role = $_POST['st_role'];
    $email = $_POST['st_email'];
    $contact_no = $_POST['st_contact_no'];
    $username = $_POST['st_username'];
    $password = password_hash($_POST['st_password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO staff (name, role, department, gender, email, contact_no, username, password)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $name, $role, $department, $gender, $email, $contact_no, $username, $password);
    return $stmt->execute() ? "Staff registered successfully!" : "Staff registration failed.";
}

function registerAdmin($conn) {
    $name = $_POST['a_name'];
    $email = $_POST['a_email'];
    $contact_no = $_POST['a_contact_no'];
    $username = $_POST['a_username'];
    $password = password_hash($_POST['a_password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO admin (name, email, contact_no, username, password)
                            VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $contact_no, $username, $password);
    return $stmt->execute() ? "Admin registered successfully!" : "Admin registration failed.";
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['user_type'])) {
        switch ($_POST['user_type']) {
            case "student":
                $message = registerStudent($conn);
                break;
            case "staff":
                $message = registerStaff($conn);
                break;
            case "admin":
                $message = registerAdmin($conn);
                break;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Multi Signup</title>
    <style>
        .form-section { display: none; margin-top: 20px; }
    </style>
</head>
<body>

<h2>Signup</h2>

<p style="color: green;">
    <?php echo $message; ?>
</p>

<label><input type="radio" name="user_type" value="student" onclick="showForm('student')"> Student</label>
<label><input type="radio" name="user_type" value="staff" onclick="showForm('staff')"> Staff</label>
<label><input type="radio" name="user_type" value="admin" onclick="showForm('admin')"> Admin</label>

<!-- Student Form -->
<form method="post" class="form-section" id="studentForm">
    <input type="hidden" name="user_type" value="student">
    <h3>Student Signup</h3>
    Name: <input type="text" name="s_name" required><br>
    Department:
    <select name="s_department" required>
        <option value="Computer Department">Computer Department</option>
        <option value="Civil Department">Civil Department</option>
        <option value="EEE Department">EEE Department</option>
        <option value="Mechanical Department">Mechanical Department</option>
        <option value="Interdisciplinary Department">Interdisciplinary Department</option>
    </select><br>
    Gender: <select name="s_gender"><option>M</option><option>F</option></select><br>
    Address: <input type="text" name="s_address" required><br>
    Contact No: <input type="text" name="s_contact_no" required><br>
    Year of Study: <input type="number" name="s_year" required><br>
    Email: <input type="email" name="s_email" required><br>
    Username: <input type="text" name="s_username" required><br>
    Password: <input type="password" name="s_password" required><br>
    <button type="submit">Register Student</button>
</form>

<!-- Staff Form -->
<form method="post" class="form-section" id="staffForm">
    <input type="hidden" name="user_type" value="staff">
    <h3>Staff Signup</h3>
    Name: <input type="text" name="st_name" required><br>
    Role: <input type="text" name="st_role" required><br>
    Department:
    <select name="st_department" required>
        <option value="Computer Department">Computer Department</option>
        <option value="Civil Department">Civil Department</option>
        <option value="EEE Department">EEE Department</option>
        <option value="Mechanical Department">Mechanical Department</option>
        <option value="Interdisciplinary Department">Interdisciplinary Department</option>
    </select><br>
    Gender: <select name="st_gender"><option>M</option><option>F</option></select><br>
    Email: <input type="email" name="st_email" required><br>
    Contact No: <input type="text" name="st_contact_no" required><br>
    Username: <input type="text" name="st_username" required><br>
    Password: <input type="password" name="st_password" required><br>
    <button type="submit">Register Staff</button>
</form>

<!-- Admin Form -->
<form method="post" class="form-section" id="adminForm">
    <input type="hidden" name="user_type" value="admin">
    <h3>Admin Signup</h3>
    Name: <input type="text" name="a_name" required><br>
    Email: <input type="email" name="a_email" required><br>
    Contact No: <input type="text" name="a_contact_no" required><br>
    Username: <input type="text" name="a_username" required><br>
    Password: <input type="password" name="a_password" required><br>
    <button type="submit">Register Admin</button>
</form>

<script>
function showForm(type) {
    document.getElementById("studentForm").style.display = "none";
    document.getElementById("staffForm").style.display = "none";
    document.getElementById("adminForm").style.display = "none";

    if (type === "student") {
        document.getElementById("studentForm").style.display = "block";
    } else if (type === "staff") {
        document.getElementById("staffForm").style.display = "block";
    } else if (type === "admin") {
        document.getElementById("adminForm").style.display = "block";
    }
}
</script>

</body>
</html>

