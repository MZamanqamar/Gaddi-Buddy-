<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $fullName = $_POST['full_name'];
    $cnic = $_POST['CNIC'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    

    // Validate form data (you can enhance validation as per your requirements)
    if (empty($fullName) || empty($cnic) || empty($email) || empty($phone) || empty($username) || empty($password)) {
        echo 'All required fields must be filled out.';
        exit;
    }

    // Database connection parameters
    $servername = "localhost";
    $username_db = "root"; // Change this to your database username
    $password_db = ""; // Change this to your database password
    $dbname = "gaddi_buddy_db"; // Change this to your database name

    // Create connection
    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $sql = "INSERT INTO userregister (full_name, cnic, email, phone, username, password) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Check if prepare() succeeded
    if ($stmt === false) {
        echo "Error preparing query: " . $conn->error;
        exit;
    }

    // Bind parameters to the SQL statement
    $stmt->bind_param("ssssss", $fullName, $cnic, $email, $phone,  $username, $password);

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "Mechanic registered successfully.";
    } else {
        echo "Error executing query: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo 'Invalid request method.';
}
?>
