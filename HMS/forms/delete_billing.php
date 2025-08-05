<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "enquiry";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$bill_id = $_GET['bill_id'] ?? null;

if ($bill_id) {
    $stmt = $conn->prepare("DELETE FROM billing WHERE bill_id = ?");
    $stmt->bind_param("i", $bill_id);

    if ($stmt->execute()) {
        header("Location: billings.php"); // Change this to your billing listing page
        exit;
    } else {
        echo "Error deleting billing record.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>