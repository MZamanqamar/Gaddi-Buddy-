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

$username = $_POST["username"];
$password = $_POST["password"];

$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Login successful
  session_start();
  
  // Redirect with link to dashboard-mechanic.html
  header("Location: admindashboard.html");
} else {
  // Login failed
  echo "Invalid CNIC or password";
}

$conn->close();
?>
