<?php
include 'config/constants.php';
include 'models/product.php';

$data = array();
$id = 38;
$data['spec_size'] = "M";
$data['size'] = 43;
$data['spec_color'] = "sunset yellow";
$data['dressFor?'] = "men";
$data['spec_comment'] = "this is just a further description of the item ";
$product = new product();
$specs = $product->addSpecs($data,$id,$conn);
var_dump($specs);


    // function($images){
    //     $images_list = [];
    //     if (isset($images['images'])) {
    
    //         $totalFiles = count($_FILES['images']['name']);
    //         for ($i = 0; $i < $totalFiles; $i++) {
    //             $imageName = $_FILES['images']['name'][$i];
    //             $imageTmpName = $_FILES['images']['tmp_name'][$i];
    //             $destinationPath = UPLOAD_DIR . $imageName;

    //             // Upload the image
    //             if (move_uploaded_file($imageTmpName, $destinationPath)) {
    //                 $images[] = $imageName;
    //                 echo $imageName;
    //             } else {
    //                 $errors[] = "Failed to upload image: $imageName";
    //                 print_r($errors);
    //             }
    //         }
    //     }
    // }
?>