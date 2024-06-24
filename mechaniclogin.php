<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gaddi_buddy_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$cnic = $_POST["cnic"];
$password = $_POST["password"];

$sql = "SELECT * FROM mechanics WHERE cnic='$cnic' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Login successful
  session_start();
  $_SESSION["mechanic_cnic"] = $cnic;
  // Redirect with link to dashboard-mechanic.html
  header("Location: mechanicdashboard.html");
} else {
  // Login failed
  echo "Invalid CNIC or password";
}

$conn->close();
?>
