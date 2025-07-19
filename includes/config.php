<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "09012005Om@";
$database = "online_bookstore"; // Make sure this is your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully"; // Uncomment to test
?>
