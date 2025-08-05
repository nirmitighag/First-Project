<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "enquiry";

// Connect to MySQL
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form values safely using null coalescing operator
    $doctorID = $_POST['doctorID'] ?? null;
    $name = $_POST['name'] ?? null;
    $specialization = $_POST['specialization'] ?? null;
    $contactNumber = $_POST['contactNumber'] ?? null;
    $availability = $_POST['availability'] ?? null;

    // Validate all fields are filled
    if ($doctorID && $name && $specialization && $contactNumber && $availability) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO doctors (doctor_id, name, specialization, contact_number, availability) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $doctorID, $name, $specialization, $contactNumber, $availability);

        // Execute and check
        if ($stmt->execute()) {
            echo "✅ Doctor inserted successfully.";
        } else {
            echo "❌ Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "❗ All fields are required.";
    }
} else {
    echo "Form not submitted.";
}

$conn->close();
?>
