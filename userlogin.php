<?php
session_start();

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $cnic = $_POST['cnic'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM userregister WHERE cnic = '$cnic' AND password = '$password'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // User authenticated
    $user = $result->fetch_assoc();
    $_SESSION['cnic'] = $user['cnic'];
    header("Location: userdashboard.html");
  } else {
    echo "Invalid CNIC or password";
  }
}

$conn->close();
?>
