<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "enquiry";
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$bill_id = $_GET['bill_id'] ?? null;

if (!$bill_id) {
    die("Invalid bill ID.");
}

// Fetch current billing record
$sql = "SELECT * FROM billing WHERE bill_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $bill_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Billing record not found.");
}

$billing = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $amount = $_POST['amount'];
    $billing_date = $_POST['billing_date'];
    $payment_status = $_POST['payment_status'];

    $update = "UPDATE billing SET amount = ?, billing_date = ?, payment_status = ? WHERE bill_id = ?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param("dssi", $amount, $billing_date, $payment_status, $bill_id);

    if ($stmt->execute()) {
        header("Location: billings-.php"); // Change this to your billing list page
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Billing Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
    <h2>Edit Billing Record</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Amount (₹)</label>
            <input type="number" step="0.01" name="amount" class="form-control" value="<?= $billing['amount'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Billing Date</label>
            <input type="date" name="billing_date" class="form-control" value="<?= $billing['billing_date'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Payment Status</label>
            <select name="payment_status" class="form-control" required>
                <option value="Paid" <?= $billing['payment_status'] === 'Paid' ? 'selected' : '' ?>>Paid</option>
                <option value="Unpaid" <?= $billing['payment_status'] === 'Unpaid' ? 'selected' : '' ?>>Unpaid</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="billing_list.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>