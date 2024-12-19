<?php

// Fetch orders from the database
$query = "SELECT * FROM orders ORDER BY order_date DESC";
$result = mysqli_query($conn, $query);

$orders = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Initialize order items array for each order
    $order_items = [];
    
    // Fetch the order items for each order
    $order_id = $row['order_id'];
    $item_query = "SELECT * FROM order_items WHERE order_id = '$order_id'";
    $item_result = mysqli_query($conn, $item_query);
    while ($item_row = mysqli_fetch_assoc($item_result)) {
        // Store the details of each item
        $order_items[] = [
            'name' => $item_row['product_name'],
            'quantity' => $item_row['quantity'],
            'price' => $item_row['price']
        ];
    }
    
    // Prepare the order data for each order
    $orders[] = [
        'id' => $row['order_id'],
        'total' => $row['total_price'],
        'status' => $row['status'],
        'mobile' => $row['mobile_money_number'],
        'date' => $row['order_date'],
        'details' => $order_items
    ];
}

// Loop through orders and display them in the accordion
foreach ($orders as $index => $order) {
    $collapseId = "orderCollapse" . $order['id'];
    $headingId = "orderHeading" . $order['id'];
    $isExpanded = $index === 0 ? 'true' : 'false';
    $isShow = $index === 0 ? 'show' : '';
    
    // Determine the badge color based on the order status
    $statusClass = '';
    switch ($order['status']) {
        case 'completed':
            $statusClass = 'success';
            break;
        case 'pending':
            $statusClass = 'warning';
            break;
        case 'denied':
            $statusClass = 'danger';
            break;
        case 'new':
            $statusClass = 'secondary';
            break;
        default:
            $statusClass = 'secondary';
    }

    // Output the order accordion item with details
    echo "
    <div class='accordion-item'>
        <h2 class='accordion-header' id='$headingId'>
            <button class='accordion-button collapsed p-3 rounded-3 border-0 shadow' 
                    type='button' 
                    data-bs-toggle='collapse' 
                    data-bs-target='#$collapseId' 
                    aria-expanded='$isExpanded' 
                    aria-controls='$collapseId'>
                <div class='d-flex justify-content-between w-100'>
                    <span><strong> #{$order['id']}</strong></span>
                    <span><strong>Total: K{$order['total']}</strong></span>
                    <span class='badge bg-$statusClass'>
                        {$order['status']}
                    </span>
                </div>
            </button>
        </h2>
        <div id='$collapseId' class='accordion-collapse collapse $isShow' aria-labelledby='$headingId' data-bs-parent='#ordersAccordion'>
            <div class='accordion-body'>
                <h5>Order Details</h5>
                <table class='table table-striped'>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price (K)</th>
                        </tr>
                    </thead>
                    <tbody>";
                    // Loop through order items and display them in a table
                    foreach ($order['details'] as $detail) {
                        echo "<tr>
                                <td>{$detail['name']}</td>
                                <td>{$detail['quantity']}</td>
                                <td>K{$detail['price']}</td>
                              </tr>";
                    }
    echo "</tbody>
                </table>
                <strong>Mobile Money Number:</strong> {$order['mobile']} <br>
                <strong>Date:</strong> {$order['date']} <br>
                <div class='mt-3'>
                    <button class='btn btn-success btn-sm'>process order</button>
                    <button class='btn btn-danger btn-sm'>Cancel Order</button>
                </div>
            </div>
        </div>
    </div>";
}
?>
