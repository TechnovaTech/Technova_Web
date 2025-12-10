<?php
include_once("includes/connect_db.php");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$full_name = $_POST['full_name'];
$email = $_POST['email'];
$budget = $_POST['budget'];
$message = $_POST['message'];

// Convert selected checkboxes to JSON
$interests = isset($_POST['interests']) ? json_encode($_POST['interests']) : json_encode([]);

// Insert data into database
$sql = "INSERT INTO contacts (full_name, email, interests, budget, message) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $full_name, $email, $interests, $budget, $message);

if ($stmt->execute()) {
    echo "<script>alert(''); window.location.href='index.php';</script>";
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
