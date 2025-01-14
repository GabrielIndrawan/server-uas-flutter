<?php

// Database configuration
$host = "localhost";     // Change to your host
$username = "root";      // Your MySQL username
$password = "";          // Your MySQL password
$database = "blangkon2"; // Your database name

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>