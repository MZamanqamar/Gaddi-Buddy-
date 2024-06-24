<?php
session_start();
if (!isset($_SESSION['mechanic_id'])) {
    header('Location: index.html');
    exit;
}

// Mechanic dashboard content goes here
echo '<h1>Welcome to the Mechanic Dashboard</h1>';
echo '<p>You are logged in as mechanic with ID: ' . $_SESSION['mechanic_id'] . '</p>';
?>
