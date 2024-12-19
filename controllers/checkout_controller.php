<?php
header('Content-Type: application/json'); // Ensure the response is JSON
include '../config/constants.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    

    if (isset($input['cart'], $input['total'], $input['mobileMoneyNumber'])) {
        $cart = $input['cart'];
        $total = $input['total'];
        $mobile_money_number = mysqli_real_escape_string($conn, $input['mobileMoneyNumber']); // Sanitize input

        // Insert order into the database
        $order_id = uniqid('order_'); // Generate a unique order ID
        $query = "INSERT INTO orders (order_id, total_price, mobile_money_number, order_date) 
                  VALUES ('$order_id', '$total', '$mobile_money_number', NOW())";
        
        if (mysqli_query($conn, $query)) {
            // Insert order items
            foreach ($cart as $item) {
                $product_id = $item['id'];
                $product_name = mysqli_real_escape_string($conn, $item['name']); // Sanitize input
                $quantity = $item['quantity'];
                $price = $item['price'];
                
                $item_query = "INSERT INTO order_items (order_id, product_id, product_name, quantity, price) 
                               VALUES ('$order_id', '$product_id', '$product_name', '$quantity', '$price')";
                mysqli_query($conn, $item_query);
            }

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save order.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid data.']);
    }
} else {
    http_response_code(405); // Method not allowed
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
