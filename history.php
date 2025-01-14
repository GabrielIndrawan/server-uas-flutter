<?php
include "conn.php";

$input = file_get_contents('php://input');
// Decode JSON input
$data = json_decode($input, true);

if (isset($data['pelanggan'])) {
    $pelanggan = $conn->real_escape_string($data['pelanggan']);
}
// SQL query to fetch all data
$sql = "SELECT * FROM penjualan WHERE pembeli='$pelanggan'"; // Replace with your table name
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    // Fetch data into an array
    while ($row = $result->fetch_assoc()) {
        $rowData = [
            'id' => $row['id'],
            'pembeli' => $row['pembeli'],
            'biaya' => $row['biaya'],
            'barang' => $row['barang'],
        ];
        $data[] = $rowData;
    }
}

header('Content-Type: application/json');
echo json_encode($data);

// Close the connection
$conn->close();
?>