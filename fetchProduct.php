<?php
include "conn.php";

// SQL query to fetch all data
$sql = "SELECT * FROM produk"; // Replace with your table name
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    // Fetch data into an array
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($data);

// Close the connection
$conn->close();
?>