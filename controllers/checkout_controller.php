<?php
header('Content-Type: application/json'); // Ensure the response is JSON
include '../config/constants.php';

// Airtel Money API credentials
$airtel_api_key = '4c724e92-5d0c-4e40-acd8-ef534c584509';
$airtel_api_secret = '4c724e92-5d0c-4e40-acd8-ef534c584509';
$airtel_api_endpoint = 'https://openapi.airtel.africa/merchant/v1/payments/';

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

            // Proceed with Airtel Money payment
            $payment_data = [
                'reference' => $order_id,
                'subscriber' => [
                    'country' => 'UG',
                    'currency' => 'UGX',
                    'msisdn' => $mobile_money_number
                ],
                'transaction' => [
                    'amount' => $total,
                    'country' => 'UG',
                    'currency' => 'UGX',
                    'id' => $order_id
                ]
            ];

            $ch = curl_init($airtel_api_endpoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'X-API-Key: ' . $airtel_api_key,
                'Authorization: Bearer ' . $airtel_api_secret
            ]);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payment_data));

            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($http_code == 200) {
                echo json_encode(['status' => 'success', 'message' => 'Payment successful']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Payment failed', 'response' => $response]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to insert order']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    }
}
?>
