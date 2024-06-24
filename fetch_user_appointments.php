<?php
session_start();
include('db_connect.php'); // Include the database connection

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $cnic = $_POST['cnic'];
  $password = $_POST['password'];
  
  // Validate user login
  $userQuery = "SELECT * FROM userregister WHERE cnic='$cnic' AND password='$password'";
  $userResult = mysqli_query($conn, $userQuery);
  
  if (mysqli_num_rows($userResult) > 0) {
    $_SESSION['user_cnic'] = $cnic;
    
    // Fetch user's pending appointments
    $pendingAppointmentsQuery = "SELECT * FROM appointments WHERE status='0'";
    $pendingAppointmentsResult = mysqli_query($conn, $pendingAppointmentsQuery);
    $pendingAppointments = mysqli_fetch_all($pendingAppointmentsResult, MYSQLI_ASSOC);
    
    // Fetch user's accepted appointments
    $acceptedAppointmentsQuery = "
      SELECT 
        a.*, 
        m.full_name AS mechanic_name, 
        m.phone AS mechanic_phone,
        m.email AS mechanic_email 
      FROM 
        appointments a 
      JOIN 
        mechanics m 
      ON 
        a.mechanic_id = m.cnic 
      WHERE 
        a.cnic='$cnic' AND a.status='1'";
    $acceptedAppointmentsResult = mysqli_query($conn, $acceptedAppointmentsQuery);
    $acceptedAppointments = mysqli_fetch_all($acceptedAppointmentsResult, MYSQLI_ASSOC);

    $response['status'] = 'success';
    $response['pending_appointments'] = $pendingAppointments;
    $response['accepted_appointments'] = $acceptedAppointments;
  } else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid login credentials.';
  }
} else {
  if (isset($_SESSION['user_cnic'])) {
    $cnic = $_SESSION['user_cnic'];
    
    // Fetch user's pending appointments
    $pendingAppointmentsQuery = "SELECT * FROM appointments WHERE sssstatus='0'";
    $pendingAppointmentsResult = mysqli_query($conn, $pendingAppointmentsQuery);
    $pendingAppointments = mysqli_fetch_all($pendingAppointmentsResult, MYSQLI_ASSOC);
    
    // Fetch user's accepted appointments
    $acceptedAppointmentsQuery = "
      SELECT 
        a.*, 
        m.full_name AS mechanic_name, 
        m.phone AS mechanic_phone,
        m.email AS mechanic_email 
      FROM 
        appointments a 
      JOIN 
        mechanics m 
      ON 
        a.mechanic_id = m.cnic 
      WHERE 
        a.cnic='$cnic' AND a.status='1'";
    $acceptedAppointmentsResult = mysqli_query($conn, $acceptedAppointmentsQuery);
    $acceptedAppointments = mysqli_fetch_all($acceptedAppointmentsResult, MYSQLI_ASSOC);

    $response['status'] = 'success';
    $response['pending_appointments'] = $pendingAppointments;
    $response['accepted_appointments'] = $acceptedAppointments;
  } else {
    $response['status'] = 'error';
    $response['message'] = 'Not logged in.';
  }
}

echo json_encode($response);
?>
