<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $fullName = $_POST['full_name'];
    $cnic = $_POST['CNIC'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $certification = $_POST['certification'];
    $experience = $_POST['experience'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $bio = $_POST['bio'];
    $serviceArea = $_POST['service_area'];
    $availability = $_POST['availability'];

    // Validate form data (you can enhance validation as per your requirements)
    if (empty($fullName) || empty($cnic) || empty($dob) || empty($email) || empty($phone) || empty($certification) || empty($experience) || empty($username) || empty($password)) {
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
    $sql = "INSERT INTO mechanics (full_name, cnic, dob, email, phone, certification, experience, username, password, bio, service_area, availability) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Check if prepare() succeeded
    if ($stmt === false) {
        echo "Error preparing query: " . $conn->error;
        exit;
    }

    // Bind parameters to the SQL statement
    $stmt->bind_param("ssssssisssss", $fullName, $cnic, $dob, $email, $phone, $certification, $experience, $username, $password, $bio, $serviceArea, $availability);

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
