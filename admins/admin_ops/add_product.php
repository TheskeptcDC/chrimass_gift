<?php
// require('C:\xampp\htdocs\johms\cloths-store\equipo-edited\config\constants.php');
//  require('C:\xampp\htdocs\johms\cloths-store\equipo-edited\models\product.php');
include '../../models/product.php';
include '../../config/constants.php';
if (isset($_POST['add_prod'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = [];

        // Check if prod_name is set
        if (empty($_POST['prod_name'])) {
            $errors[] = "Please enter the product name";
        } else {
            $prod_name = $_POST['prod_name'];
            echo "$prod_name";
        }

        // Check if prod_desc is set
        if (empty($_POST['prod_desc'])) {
            $errors[] = "Please enter the product description";
        } else {
            $prod_desc = $_POST['prod_desc'];
            echo "$prod_desc";
        }

        // Check if old_price is set
        if (empty($_POST['old_price'])) {
            $errors[] = "Please enter the old price";
        } else {
            $old_price = $_POST['old_price'];
            echo "$old_price";
        }

        // Check if new_price is set
        if (empty($_POST['new_price'])) {
            $errors[] = "Please enter the new price";
        } else {
            $new_price = $_POST['new_price'];
            echo "$new_price";
        }

        // Check if cat_id is set
        if (empty($_POST['cat_id'])) {
            $errors[] = "Please select a product category";
        } else {
            $cat_id = $_POST['cat_id'];
            echo $cat_id;
        }

        // Check if active and featured are set
        if (empty($_POST['active'])) {
            $errors[] = "Please choose if the product is active";
        } else {
            $active = $_POST['active'];
        }

        if (empty($_POST['featured'])) {
            $errors[] = "Please choose if the product is featured";
        } else {
            $featured = $_POST['featured'];
        }

        // Process the uploaded images
        $images = [];
        if (isset($_FILES['images'])) {
            var_dump($_FILES['images']);
            $totalFiles = count($_FILES['images']['name']);
            for ($i = 0; $i < $totalFiles; $i++) {
                $imageName = $_FILES['images']['name'][$i];
                $imageTmpName = $_FILES['images']['tmp_name'][$i];
                $destinationPath = UPLOAD_DIR . $imageName;

                // Upload the image
                if (move_uploaded_file($imageTmpName, $destinationPath)) {
                    $images[] = $imageName;
                    echo $imageName;
                } else {
                    $errors[] = "Failed to upload image: $imageName";
                    print_r($errors);
                }
            }
        }

        // If there are no errors, update the product
        if (empty($errors)) {
            $data = array(
                'images' => $images,
                'name' => $prod_name,
                'description' => $prod_desc,
                'old_price' => $old_price,
                'new_price' => $new_price,
                'cat_id' => $cat_id,
                'active' => $active,
                'featured' => $featured
            );

            // Assuming you have a Product class with an addProduct method
            $new_product = new Product();
            $isAdded = $new_product->add($conn,$data);
            if ($isAdded) {
                // Redirect to a success page
                header('Location: ' . SITEURL . 'admins/');
                exit();
            } else {
                $errors[] = "Update failed. Please contact tech support for assistance.";
            }
        }

        // Output any errors
        if (!empty($errors)) {
            print_r($errors);
        }
    }
}

?>