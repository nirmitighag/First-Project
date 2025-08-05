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



// Handle form submission

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $patient_id = $_POST['patient_id'];

    $doctor_id = $_POST['doctor_id'];

    $diagnosis = $_POST['diagnosis'];

    $treatment = $_POST['treatment'];

    $record_date = $_POST['record_date'];



    $update = "UPDATE medical_records SET 

        patient_id='$patient_id', 

        doctor_id='$doctor_id', 

        diagnosis='$diagnosis', 

        treatment='$treatment', 

        record_date='$record_date' 

        WHERE record_id=$record_id";



    if ($conn->query($update)) {

        header("Location: medicalrecords.php");

        exit;

    } else {

        echo "Error updating record: " . $conn->error;

    }

}



// Fetch existing record

$sql = "SELECT * FROM medical_records WHERE record_id=$record_id";

$result = $conn->query($sql);

$data = $result->fetch_assoc();

?>



<!DOCTYPE html>

<html>

<head>

  <title>Edit Medical Record</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

</head>

<body>

<div class="container mt-5">

  <h2>Edit Medical Record</h2>

  <form method="POST">

    <div class="mb-3">

      <label class="form-label">Patient ID</label>

      <input type="text" name="patient_id" class="form-control" value="<?= $data['patient_id'] ?>" required>

    </div>

    <div class="mb-3">

      <label class="form-label">Doctor ID</label>

      <input type="text" name="doctor_id" class="form-control" value="<?= $data['doctor_id'] ?>" required>

    </div>

    <div class="mb-3">

      <label class="form-label">Diagnosis</label>

      <textarea name="diagnosis" class="form-control" required><?= $data['diagnosis'] ?></textarea>

    </div>

    <div class="mb-3">

      <label class="form-label">Treatment</label>

      <textarea name="treatment" class="form-control" required><?= $data['treatment'] ?></textarea>

    </div>

    <div class="mb-3">

      <label class="form-label">Record Date</label>

      <input type="date" name="record_date" class="form-control" value="<?= $data['record_date'] ?>" required>

    </div>

    <button type="submit" class="btn btn-primary">Update</button>

    <a href="medical_records.php" class="btn btn-secondary">Cancel</a>

  </form>

</div>

</body>

</html>