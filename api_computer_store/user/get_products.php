<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');

// Include database connection
require_once '../connection.php';

if (!$connectNow) {
    die(json_encode(["error" => "Database connection failed"]));
}

$query = mysqli_query($connectNow, "SELECT * FROM products");

if (!$query) {
    die(json_encode(["error" => mysqli_error($connectNow)]));
}

$rows = [];

while ($row = mysqli_fetch_assoc($query)) {
    $rows[] = [
        "id" => (int)$row["id"],
        "name" => $row["name"],
        "description" => $row["description"],
        "image_url" => $row["image_url"],
        "price" => (float)$row["price"]
    ];
}

echo json_encode($rows);

mysqli_close($connectNow);
?>
