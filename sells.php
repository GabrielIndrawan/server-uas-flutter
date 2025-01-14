<?php
include "conn.php";

// SQL query to fetch all data
$sql = "SELECT * FROM penjualan"; // Replace with your table name
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
            'bukti' =>  $row['bukti'],
        ];
        $data[] = $rowData;
    }
}

header('Content-Type: application/json');
echo json_encode($data);

// Close the connection
$conn->close();
?>