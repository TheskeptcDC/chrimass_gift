<?php
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  # code...
  $id = $_GET['id'];
  // process
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
    $images = $product_details['product_images']; // Array of images
    $image_paths = [];
    
    foreach ($images as $image) {
        $image_paths[] = 'images/' . $image;
    }
    
    // display the specifications    
        $colour = $specifications['colour'];
        $dressFor = $specifications['dressFor?'];
        $fit = $specifications['fit'];
        $details = $specifications['details'];
        $size = $specifications['size'];
        // var_dump($specifications);
    include 'views/detailed_product_view.html';
} else {
  # code...
  $name = " ";
}

}else {
  # code...
  $action = 'home';
}
    
?>