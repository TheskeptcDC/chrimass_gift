<?php
    $product = new product();
    $product_details = $product->getProductsById($conn,$id);
    $specifications = $product->getProductSpecifications($conn,$id);
  if ($product_details != null) {
    # code...
      // DISPLAY THE RETURNED DETAILS
      $name = $product_details['product_name'];
      $description = $product_details['product_description'];
      $new_price = $product_details['new_price'];
      $old_price = $product_details['old_price'];
      // display the specifications    
          $colour = $specifications['colour'];
          $dressFor = $specifications['dressFor?'];
          $fit = $specifications['fit'];
          $details = $specifications['details'];
          $size = $specifications['size'];    
      include 'views/detailed_product_view.html';
  } else {
    # code...
    $name = " ";
  }
  
    
?>