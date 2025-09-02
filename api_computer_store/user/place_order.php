<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Include your DB connection
require_once __DIR__ . '/../connection.php'; // make sure this sets $pdo

// Read raw POST data
$input = json_decode(file_get_contents("php://input"), true);

if (!$input || !isset($input['user_id'], $input['total_amount'], $input['items'])) {
    echo json_encode(["success" => false, "message" => "Invalid input"]);
    exit;
}

$user_id = $input['user_id'];
$total_amount = $input['total_amount'];
$items = $input['items'];

try {
    // Start transaction
    $pdo->beginTransaction();

    // Insert into orders
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount, order_date) VALUES (?, ?, NOW())");
    $stmt->execute([$user_id, $total_amount]);

    $order_id = $pdo->lastInsertId();

    // Insert order items
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");

    foreach ($items as $item) {
        $stmt->execute([
            $order_id,
            $item['product_id'],
            $item['quantity'],
            $item['price'],
        ]);
    }

    // Commit transaction
    $pdo->commit();

    echo json_encode(["success" => true, "message" => "Order placed successfully"]);
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}
