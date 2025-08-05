<?php
$conn = new mysqli("localhost", "root", "", "enquiry");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);

  $sql = "DELETE FROM doctors WHERE doctor_id = $id";

  if ($conn->query($sql) === TRUE) {
    header("Location: docotor.php?msg=deleted"); // adjust redirect file name
    exit();
  } else {
    echo "Error deleting record: " . $conn->error;
  }
} else {
  echo "Invalid request.";
}

$conn->close();
?>