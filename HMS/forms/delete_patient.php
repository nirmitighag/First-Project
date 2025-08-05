<?php
include 'connect.php';

$id = $_GET['id'];

$sql = "DELETE FROM patients WHERE id = $id";

if (mysqli_query($conn, $sql)) {
  header("Location: patients.php"); // Redirect after deletion
  exit;
} else {
  echo "Error deleting record: " . mysqli_error($conn);
}
?>