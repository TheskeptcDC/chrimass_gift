<?php
$product = new product();
$res = $product->getProductsByCategoryName($conn,$name);

// load the products on the page 
if ($res != "no products available") {
    while ($rows = mysqli_fetch_assoc($res)) {
        $name = $rows['product_name'];
        $old_price = $rows['old_price'];
        $new_price = $rows['new_price'];
        $comment = $rows['comment'];
        $image = $rows['single_image'];
        $id = $rows['product_id'];

        // display the product 
        include 'views/product-view-1.html';
    }
} else {
    echo "CURRENTLY NO PRODUCTS ARE AVAILABLE IN THIS CATEGORY";
}

?>