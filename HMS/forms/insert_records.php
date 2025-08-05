<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "enquiry";

// Connect to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect POST data safely
    $recordID   = $_POST['recordID'] ?? null;
    $patientID  = $_POST['patientID'] ?? null;
    $doctorID   = $_POST['doctorID'] ?? null;
    $diagnosis  = $_POST['diagnosis'] ?? null;
    $treatment  = $_POST['treatment'] ?? null;
    $recordDate = $_POST['recordDate'] ?? null;

    // Check that all fields are filled
    if ($recordID && $patientID && $doctorID && $diagnosis && $treatment && $recordDate) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO medical_records (record_id, patient_id, doctor_id, diagnosis, treatment, record_date) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $recordID, $patientID, $doctorID, $diagnosis, $treatment, $recordDate);

        if ($stmt->execute()) {
            echo "✅ Medical record inserted successfully.";
        } else {
            echo "❌ Error inserting record: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "❗ Please fill in all required fields.";
    }
} else {
    echo "❌ Invalid request.";
}

$conn->close();
?>
