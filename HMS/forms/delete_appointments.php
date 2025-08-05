<?php
// connect to DB
$conn = new mysqli("localhost", "root", "", "enquiry");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$appointment_id = $_GET['id'] ?? null;

if (!$appointment_id) {
    die("Invalid ID.");
}

$sql = "DELETE FROM appointments WHERE appointment_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $appointment_id);

if ($stmt->execute()) {
    header("Location: appointments.php"); // change this to your actual list page
    exit;
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>