<?php
include 'connect.php';

$name = $_POST['name'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$contact = $_POST['contact'];
$address = $_POST['address'];
$medical_history = $_POST['medical_history'];


// Insert into DB
$sql = "INSERT INTO patients (name, age, gender, contact, address, medical_history)
        VALUES ('$name', '$age', '$gender','$contact','$address', '$medical_history')";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<script>alert('Patient Submitted Successfully'); window.location.href='patient.php';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>