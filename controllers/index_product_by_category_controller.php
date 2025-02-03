<?php
$product = new product();

$res = $product->getProductsByCategoryName($conn, $name);

// Load the products on the page
if ($res != "no products available") {
    while ($rows = mysqli_fetch_assoc($res)) {
        $name = $rows['product_name'];
        $old_price = $rows['old_price'];
        $new_price = $rows['new_price'];
        $comment = $rows['comment'];
        $image = $rows['single_image'];
        $id = $rows['product_id'];
        
        // Decode the JSON string to an array
        $images = json_decode($rows['product_images'], true);

        // Check if the decoding was successful and process images
        $image_paths = [];
        if (is_array($images)) {
            foreach ($images as $image) {
                $image_paths[] = 'images/' . $image;
            }

            // Get the first image path to display
            $path = $image_paths[0];
        } else {
            // Default path if decoding fails
            $path = 'images/default.png';
        }

        // Display the product
        include 'views/product-view-1.html';
    }
} else {
    echo "CURRENTLY NO PRODUCTS ARE AVAILABLE IN THIS CATEGORY";
}

?>
