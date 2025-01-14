<?php
include "conn.php";
// Get the raw POST data
$input = file_get_contents('php://input');

// Decode JSON input
$data = json_decode($input, true);

// Validate input
if (isset($data['username']) && isset($data['password'])) {
    $username = $conn->real_escape_string($data['username']);
    $password = $conn->real_escape_string($data['password']);
    
    // SQL query to insert data
    $sql = "INSERT INTO user (username, password, status) VALUES ('$username', '$password', 0)";

    if ($conn->query($sql) === TRUE) {
        http_response_code(201); // Created
        echo json_encode(["message" => "User added successfully"]);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(["error" => "Error: " . $conn->error]);
    }
} else {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Invalid input"]);
}

// Close connection
$conn->close();
?>