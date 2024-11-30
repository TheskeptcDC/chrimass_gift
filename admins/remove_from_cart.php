<?php
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Remove the item from the cart in the session
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item->product_id == $product_id) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }

    // Re-index the array
    $_SESSION['cart'] = array_values($_SESSION['cart']);

    // Calculate the new total price
    $total_price = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total_price += $item->total_price;
    }

    echo json_encode(['total_price' => $total_price]);
}
?>
