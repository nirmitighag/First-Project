<?php
include 'connect.php';

$sql = "SELECT * FROM patients";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Patient Records</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"/>
</head>
<body>
  <div class="container mt-5">
    <h2 class="text-center mb-4">Patient Records</h2>
    <table id="patientsTable" class="table table-bordered table-striped">
      <thead class="table-primary text-center">
        <tr>
          <th>Name</th>
          <th>Age</th>
          <th>Gender</th>
          <th>Contact</th>
          <th>Address</th>
          <th>Medical_history</th>
        </tr>
      </thead>
      <tbody class="text-center">
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
          <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['age']; ?></td>
            <td><?php echo $row['gender']; ?></td>
            <td><?php echo $row['contact']; ?></td>
            <td><?php echo $row['address']; ?></td>
            <td><?php echo $row['medical_history']; ?></td>

           
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#patientsTable').DataTable();
    });
  </script>
</body>
</html>