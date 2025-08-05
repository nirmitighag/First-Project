<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "enquiry";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Safely get POST values
    $billID        = trim($_POST['billID'] ?? '');
    $patientID     = trim($_POST['patientID'] ?? '');
    $amount        = $_POST['amount'] ?? '';
    $billingDate   = $_POST['billingDate'] ?? '';
    $paymentStatus = $_POST['paymentStatus'] ?? '';

    // Validate required fields (basic)
    if ($billID && $patientID && is_numeric($amount) && $billingDate && $paymentStatus) {
        // Prepare SQL insert
        $stmt = $conn->prepare("INSERT INTO billing (bill_id, patient_id, amount, billing_date, payment_status) VALUES (?, ?, ?, ?, ?)");

        if ($stmt) {
            $stmt->bind_param("ssdss", $billID, $patientID, $amount, $billingDate, $paymentStatus);

            if ($stmt->execute()) {
                echo "✅ Billing record inserted successfully.";
            } else {
                echo "❌ Insert error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "❌ Statement preparation failed: " . $conn->error;
        }
    } else {
        echo "⚠️ Please fill in all required fields correctly.";
    }
} else {
    echo "❌ Invalid request method.";
}

$conn->close();
?>
