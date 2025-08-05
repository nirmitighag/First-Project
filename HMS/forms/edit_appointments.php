<?php
// connect to DB
$conn = new mysqli("localhost", "root", "", "enquiry");

// check for DB connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// get appointment ID
$appointment_id = $_GET['id'] ?? null;

if (!$appointment_id) {
    die("Invalid ID.");
}

// fetch appointment details
$sql = "SELECT * FROM appointments WHERE appointment_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $appointment_id);
$stmt->execute();
$result = $stmt->get_result();
$appointment = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $purpose = $_POST['purpose'];

    $update_sql = "UPDATE appointments SET patient_id=?, doctor_id=?, appointment_date=?, appointment_time=?, purpose=? WHERE appointment_id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("iisssi", $patient_id, $doctor_id, $appointment_date, $appointment_time, $purpose, $appointment_id);

    if ($stmt->execute()) {
        header("Location: appointments.php"); // redirect back to list page
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Edit Appointment</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Patient ID</label>
            <input type="number" name="patient_id" class="form-control" value="<?= $appointment['patient_id'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Doctor ID</label>
            <input type="number" name="doctor_id" class="form-control" value="<?= $appointment['doctor_id'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="appointment_date" class="form-control" value="<?= $appointment['appointment_date'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Time</label>
            <input type="time" name="appointment_time" class="form-control" value="<?= $appointment['appointment_time'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Purpose</label>
            <input type="text" name="purpose" class="form-control" value="<?= $appointment['purpose'] ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Update Appointment</button>
        <a href="appointments_list.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>