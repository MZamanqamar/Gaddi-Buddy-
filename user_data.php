<?php
session_start();
if (!isset($_SESSION['cnic'])) {
    // Redirect to login or display a message
    header("Location: userlogin.html");
    exit;
  }

$cnic = $_SESSION['cnic'];

$servername = "localhost";
$username = "root";
$password = "";
$appointments_db = "appointments_db";
$gaddi_buddy_db = "gaddi_buddy_db";

// Create connection to appointments_db
$conn_appointments = new mysqli($servername, $username, $password, $appointments_db);
if ($conn_appointments->connect_error) {
  die("Connection failed: " . $conn_appointments->connect_error);
}

// Create connection to gaddi_buddy_db
$conn_gaddi_buddy = new mysqli($servername, $username, $password, $gaddi_buddy_db);
if ($conn_gaddi_buddy->connect_error) {
  die("Connection failed: " . $conn_gaddi_buddy->connect_error);
}

$sql = "SELECT * FROM appointments WHERE cnic = '$cnic'";
$result = $conn_appointments->query($sql);

$pending_appointments = [];
$accepted_appointments = [];

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    if ($row['status'] == 0) {
      $pending_appointments[] = $row;
    } else {
      // Fetch mechanic details
      $mechanic_id = $row['mechanic_id'];
      $sql_mechanic = "SELECT full_name, phone FROM mechanics WHERE cnic = '$mechanic_id'";
      $result_mechanic = $conn_gaddi_buddy->query($sql_mechanic);
      if ($result_mechanic->num_rows > 0) {
        $mechanic = $result_mechanic->fetch_assoc();
        $row['mechanic_name'] = $mechanic['full_name'];
        $row['mechanic_phone'] = $mechanic['phone'];
      } else {
        $row['mechanic_name'] = 'Unknown';
        $row['mechanic_phone'] = 'Unknown';
      }
      $accepted_appointments[] = $row;
    }
  }
}

echo json_encode([
  'pending_appointments' => $pending_appointments,
  'accepted_appointments' => $accepted_appointments
]);

$conn_appointments->close();
$conn_gaddi_buddy->close();
?>
