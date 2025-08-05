<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "enquiry";

// Connect to database
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect form data using null coalescing operator
    $appointmentID    = $_POST['appointmentID'] ?? null;
    $patientID        = $_POST['patientID'] ?? null;
    $doctorID         = $_POST['doctorID'] ?? null;
    $appointmentDate  = $_POST['appointmentDate'] ?? null;
    $appointmentTime  = $_POST['appointmentTime'] ?? null;
    $purpose          = $_POST['purpose'] ?? null;

    // Validate required fields
    if ($appointmentID && $patientID && $doctorID && $appointmentDate && $appointmentTime && $purpose) {
        // Prepare insert statement
        $stmt = $conn->prepare("INSERT INTO appointments (appointment_id, patient_id, doctor_id, appointment_date, appointment_time, purpose) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $appointmentID, $patientID, $doctorID, $appointmentDate, $appointmentTime, $purpose);

        if ($stmt->execute()) {
            echo "✅ Appointment inserted successfully.";
        } else {
            echo "❌ Error inserting appointment: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "❗ Please fill in all fields.";
    }
} else {
    echo "❌ Invalid request method.";
}

$conn->close();
?>
