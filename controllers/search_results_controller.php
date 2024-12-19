<?php
    $product = new product();
    $accurate_results = $product->getProductsByCategoryName($conn,$query);
    $related_results = $product->getRelatedProductsByCategoryName($conn,$query);
    
    // load the products on the page 
    if ($accurate_results!= "no products available") {
        while ($rows = mysqli_fetch_assoc($accurate_results)) {
            $name = $rows['product_name'];
            $old_price = $rows['old_price'];
            $new_price = $rows['new_price'];
            $comment = $rows['comment'];
            $image = $rows['single_image'];
            $id = $rows['product_id'];
    
            // display the product 
            include 'views/product-view-1.html';

        // get the less accurate results here 
           if ($related_results != "no products available") {
            # code...
            while ($rows = mysqli_fetch_assoc($related_results)) {
                # code...
            $name = $rows['product_name'];
            $old_price = $rows['old_price'];
            $new_price = $rows['new_price'];
            $comment = $rows['comment'];
            $image = $rows['single_image'];
            $id = $rows['product_id'];
             // display the product 
             include 'views/product-view-1.html';
            }
        }
    } else {
        echo "CURRENTLY NO PRODUCTS ARE AVAILABLE IN THIS CATEGORY";
    }
    
    
?>