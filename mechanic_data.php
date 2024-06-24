<?php
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

$sql = "SELECT * FROM appointments WHERE status='0'";  // Fetch new appointments (status 0)
$result = $conn->query($sql);

// Check if query was successful
if ($result->num_rows > 0) {
  $new_appointments = $result->fetch_all(MYSQLI_ASSOC);
} else {
  $new_appointments = [];
}

$sql = "SELECT * FROM appointments WHERE status!='0'";  // Fetch previous appointments (non-zero status)
$result = $conn->query($sql);

// Check if query was successful
if ($result->num_rows > 0) {
  $previous_appointments = $result->fetch_all(MYSQLI_ASSOC);
} else {
  $previous_appointments = [];
}

$data = ['appointments' => array_merge($new_appointments, $previous_appointments)];  // Combine appointments

echo json_encode($data);

$conn->close();
?>
