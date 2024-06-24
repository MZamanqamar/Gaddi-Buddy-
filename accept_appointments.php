<?php
session_start();

$appointmentData = json_decode(file_get_contents('php://input'), true);
$appointmentId = $appointmentData['appointmentId'];
$mechanicCnic = $_SESSION['mechanic_cnic'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "appointments_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE appointments SET status = 1, mechanic_id = '$mechanicCnic' WHERE id = '$appointmentId'";

if ($conn->query($sql) === TRUE) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false, 'message' => "Error updating appointment: " . $conn->error]);
}

$conn->close();
?>
