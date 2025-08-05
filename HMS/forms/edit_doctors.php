<?php
$conn = new mysqli("localhost", "root", "", "enquiry");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if (isset($_POST['update'])) {
  $id = intval($_POST['doctor_id']);
  $name = $_POST['name'];
  $specialization = $_POST['specialization'];
  $contact_number = $_POST['contact_number'];
  $availability = $_POST['availability'];

  $stmt = $conn->prepare("UPDATE doctors SET name=?, specialization=?, contact_number=?, availability=? WHERE doctor_id=?");
  $stmt->bind_param("ssssi", $name, $specialization, $contact_number, $availability, $id);

  if ($stmt->execute()) {
    header("Location:doctor.php?msg=updated");
    exit();
  } else {
    echo "Update failed: " . $stmt->error;
  }

  $stmt->close();
}

// Fetch current data
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $result = $conn->query("SELECT * FROM doctors WHERE doctor_id = $id");

  if ($result->num_rows > 0) {
    $doctor = $result->fetch_assoc();
  } else {
    echo "Doctor not found.";
    exit;
  }
} else {
  echo "No doctor ID provided.";
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Doctor</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h2 class="mb-4">Edit Doctor</h2>
  <form method="post" action="edit_doctor.php">
    <input type="hidden" name="doctor_id" value="<?php echo $doctor['doctor_id']; ?>">

    <div class="mb-3">
      <label class="form-label">Name</label>
      <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($doctor['name']); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Specialization</label>
      <input type="text" name="specialization" class="form-control" value="<?php echo htmlspecialchars($doctor['specialization']); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Contact Number</label>
      <input type="text" name="contact_number" class="form-control" value="<?php echo htmlspecialchars($doctor['contact_number']); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Availability</label>
      <input type="text" name="availability" class="form-control" value="<?php echo htmlspecialchars($doctor['availability']); ?>" required>
    </div>

    <button type="submit" name="update" class="btn btn-success">Update</button>
    <a href="layout-custom-area.php" class="btn btn-secondary">Cancel</a>
  </form>
</body>
</html>