<?php
if (isset($name)) {
    # code...
    $product = new product();
    $res = $product->getRelatedProductsByCategoryName($conn,$name);


// load the products on the page 
if ($res != "no products available") {
    echo '<div class=""><h3>you may also like this</h3></div>';
    while ($rows = mysqli_fetch_assoc($res)) {
        $name = $rows['product_name'];
        $old_price = $rows['old_price'];
        $new_price = $rows['new_price'];
        $comment = $rows['comment'];
        $image = $rows['single_image'];

        // display the product 
        include 'views/product-view-1.html';
    }
} else {
    echo "  SEARCH BY POPULAR PRODUCT NAME TO FIND WHAT YOU FANCY QUICKER ";
}
}
?>