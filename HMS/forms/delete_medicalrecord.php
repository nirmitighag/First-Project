<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "enquiry";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$record_id = $_GET['record_id'] ?? null;

if ($record_id) {
    $sql = "DELETE FROM medical_records WHERE record_id=$record_id";
    if ($conn->query($sql)) {
        header("Location: medicalrecords.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid record ID.";
}

$conn->close();
?>