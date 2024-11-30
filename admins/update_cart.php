<?php
session_start();
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Update the cart in the session
    foreach ($_SESSION['cart'] as &$item) {
        if ($item->product_id == $product_id) {
            $item->quantity = $quantity;
            $item->total_price = $item->price * $quantity;
            break;
        }
    }

    // Calculate the new total price
    $total_price = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total_price += $item->total_price;
    }

    echo json_encode(['total_price' => $total_price]);
}
?>
