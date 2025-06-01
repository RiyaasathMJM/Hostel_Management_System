<?php

include("header.html");
include("db_connect.php");

// Sample student data
$name = "Usman";
$department = "com";
$gender = "M";
$address = "nintavur_Ampara";
$contact_no = "938"; 
$year_of_study = 3;
$username = "2022e096";
$password = "dd";

// Hash the password
$hash = password_hash($password, PASSWORD_DEFAULT);

// SQL to insert a student (exclude stu_id since it's AUTO_INCREMENT)
$sql = "INSERT INTO student (name, department, gender, address, contact_no, year_of_study, username, password)
        VALUES ('$name', '$department', '$gender', '$address', '$contact_no', $year_of_study, '$username', '$hash')";

// Execute and check
if (mysqli_query($conn, $sql)) {
    echo "Inserted successfully";
} else {
    echo "Insert failed: " . mysqli_error($conn);
}

?>

