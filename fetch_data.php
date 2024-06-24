<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname1 = "gaddi_buddy_db";
$dbname2 = "appointments_db";

// Create connection for gaddi_buddy_db
$conn1 = new mysqli($servername, $username, $password, $dbname1);
if ($conn1->connect_error) {
    die("Connection failed: " . $conn1->connect_error);
}

// Create connection for appointments_db
$conn2 = new mysqli($servername, $username, $password, $dbname2);
if ($conn2->connect_error) {
    die("Connection failed: " . $conn2->connect_error);
}

// Fetch mechanics data
$mechanics_sql = "SELECT * FROM mechanics";
$mechanics_result = $conn1->query($mechanics_sql);
$mechanics = [];
if ($mechanics_result->num_rows > 0) {
    while ($row = $mechanics_result->fetch_assoc()) {
        $mechanics[] = $row;
    }
}

// Fetch owners data
$owners_sql = "SELECT * FROM userregister";
$owners_result = $conn1->query($owners_sql);
$owners = [];
if ($owners_result->num_rows > 0) {
    while ($row = $owners_result->fetch_assoc()) {
        $owners[] = $row;
    }
}

// Fetch appointments data
$appointments_sql = "SELECT * FROM appointments";
$appointments_result = $conn2->query($appointments_sql);
$appointments = [];
if ($appointments_result->num_rows > 0) {
    while ($row = $appointments_result->fetch_assoc()) {
        $appointments[] = $row;
    }
}

// Prepare data to be sent as JSON
$response = [
    "mechanics" => $mechanics,
    "userregister" => $owners,
    "appointments" => $appointments
];

header('Content-Type: application/json');
echo json_encode($response);

$conn1->close();
$conn2->close();
?>
