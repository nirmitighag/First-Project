<?php
include 'connect.php';

$id = $_GET['id'];
$sql = "SELECT * FROM patients WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
  $name = $_POST['name'];
  $age = $_POST['age'];
  $gender = $_POST['gender'];
  $contact = $_POST['contact'];
  $address = $_POST['address'];
  $medical_history = $_POST['medical_history'];

  $updateSql = "UPDATE patients SET 
    name='$name', 
    age='$age', 
    gender='$gender', 
    contact='$contact', 
    address='$address', 
    medical_history='$medical_history' 
    WHERE id=$id";

  if (mysqli_query($conn, $updateSql)) {
    header("Location: patients.php"); // redirect to listing page
    exit;
  } else {
    echo "Update failed: " . mysqli_error($conn);
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Patient</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
</head>
<body>
  <div class="container mt-5">
    <h2>Edit Patient</h2>
    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="<?php echo $row['name']; ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Age</label>
        <input type="number" name="age" class="form-control" value="<?php echo $row['age']; ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-select" required>
          <option value="Male" <?php if ($row['gender'] == 'Male') echo 'selected'; ?>>Male</option>
          <option value="Female" <?php if ($row['gender'] == 'Female') echo 'selected'; ?>>Female</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Contact</label>
        <input type="text" name="contact" class="form-control" value="<?php echo $row['contact']; ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Address</label>
        <textarea name="address" class="form-control" required><?php echo $row['address']; ?></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Medical History</label>
        <textarea name="medical_history" class="form-control" required><?php echo $row['medical_history']; ?></textarea>
      </div>
      <button type="submit" name="update" class="btn btn-success">Update</button>
      <a href="patients.php" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</body>
</html>