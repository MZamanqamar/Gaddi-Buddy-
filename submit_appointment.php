<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $cnic = $_POST['cnic'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $brand = $_POST['brand'];
    $year = $_POST['year'];
    $package = $_POST['package'];
    $serviceRequired = $_POST['service_required'];

    // Validate form data (you can enhance validation as per your requirements)
    if (empty($firstName) || empty($lastName) || empty($phone) || empty($city) || empty($cnic) || empty($email) || empty($date) || empty($time) || empty($brand) || empty($year) || empty($package) || empty($serviceRequired)) {
        echo 'All fields are required.';
        exit;
    }

    // Database connection parameters
    $servername = "localhost";
    $username = "root"; // Change this to your database username
    $password = ""; // Change this to your database password
    $dbname = "appointments_db"; // Change this to your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert data into the database using prepared statements
    $sql = "INSERT INTO appointments (first_name, last_name, phone, city, cnic, email, date, time, brand, year, package, service_required) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind the parameters
    $bind = $stmt->bind_param("ssssssssssss", $firstName, $lastName, $phone, $city, $cnic, $email, $date, $time, $brand, $year, $package, $serviceRequired);

    // Check if the parameters were bound successfully
    if ($bind === false) {
        die("Error binding parameters: " . $stmt->error);
    }

    // Execute the statement
    if ($stmt->execute()) {
        echo "Appointment booked successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo 'Invalid request method.';
}
?>
