<?php
$servername = "localhost";
$username = "root";
$password = ""; // Default XAMPP password is empty
$dbname = "quickfit_db"; // Make sure this matches your name in phpMyAdmin

// 1. Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// 2. Check connection
if ($conn->connect_error) {
    // If it fails, stop the script and show the error
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Echo this only during testing to confirm it works
// echo "Connected successfully to QuickFit Database!";
?>