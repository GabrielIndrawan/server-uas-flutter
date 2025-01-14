<?php
include "conn.php";

// Directory to store uploaded images
$imageUploadDir = "uploads/";

// Create the directory if it doesn't exist
if (!is_dir($imageUploadDir)) {
    mkdir($imageUploadDir, 0777, true);
}

// Check if the request is multipart (for file upload)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    // Validate and sanitize input data
    $barang = isset($_POST['barang']) ? $conn->real_escape_string($_POST['barang']) : null;
    $biaya = isset($_POST['biaya']) ? $conn->real_escape_string($_POST['biaya']) : null;
    $pembeli = isset($_POST['pembeli']) ? $conn->real_escape_string($_POST['pembeli']) : null;

    if ($barang && $biaya && $pembeli) {
        // Handle image upload
        $image = $_FILES['image'];
        $imageName = basename($image['name']);
        $targetFilePath = $imageUploadDir . uniqid() . "-" . $imageName;

        // Validate image file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($image['type'], $allowedTypes)) {
            if (move_uploaded_file($image['tmp_name'], $targetFilePath)) {
                // Save record to the database
                $imagePath = $conn->real_escape_string($targetFilePath);
                $sql = "INSERT INTO penjualan (pembeli, barang, biaya, bukti) VALUES ('$pembeli', '$barang', $biaya, '$imagePath')";

                if ($conn->query($sql) === TRUE) {
                    http_response_code(201); // Created
                    echo json_encode(["message" => "Record added successfully", "image_path" => $imagePath]);
                } else {
                    http_response_code(500); // Internal Server Error
                    echo json_encode(["error" => "Database error: " . $conn->error]);
                }
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(["error" => "Failed to upload image"]);
            }
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "Invalid image type. Allowed types: JPEG, PNG, GIF"]);
        }
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(["error" => "Missing required fields (barang, biaya, pembeli)"]);
    }
} else {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Invalid request or no image uploaded"]);
}

// Close connection
$conn->close();
?>
