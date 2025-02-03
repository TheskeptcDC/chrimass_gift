<?php
    class product
    {


        function getProducts($conn){
            $sql = "SELECT `product_name`, `product_id`, `single_image`, `comment`, `product_images`, `new_price`, `old_price` FROM `product` WHERE `active` = 'yes'";
            $run = mysqli_query($conn,$sql);
            if ($run) {
                $row = mysqli_num_rows($run);
                    if ($row > 0) {
                        return $run;
                    } else {
                        return "no products available";
                    }
                    
            } else {
                return "failed";
            }
            
        }
    
    
    // TO GET PRODUCTS FROM A PARTICULAR CATEGORY
    function getProductsByCategoryId($conn, $cat_id){
        $get_prod = "SELECT * FROM product WHERE category_id = $cat_id AND active = 'yes'";
        $get_prod_res = mysqli_query($conn, $get_prod);
        return $get_prod_res;
    }

// TO GET PRODUCTS FROM A NAMED CATEGORY
function getProductsByCategoryName($conn,$name){
    $get_prod = "SELECT * FROM `product` WHERE category_id = 
        (
            SELECT `category_id` 
            FROM `product_category` 
            WHERE `category_name` = '$name'
        )
    ";
    
    $get_prod_res = mysqli_query($conn, $get_prod);
        if ($get_prod_res) {
            $count = mysqli_num_rows($get_prod_res);
        if ($count > 0) {
            $products = array();
            return $get_prod_res;
        } else {
            return "no products available";
        }
        }else {
            return "no products available";
        }
}

// GET PRODUCTS FROM A CATEGORY LIKE THE NAMED CATEGORY 
function getRelatedProductsByCategoryName($conn,$name){
    $get_prod = "SELECT * FROM `product` WHERE category_id = 
    (
        SELECT `category_id` 
        FROM `product_category` 
        WHERE `category_name` %like% '$name' OR `category_description` %LIKE%
    )
";

$get_prod_res = mysqli_query($conn, $get_prod);
    if ($get_prod_res) {
        $count = mysqli_num_rows($get_prod_res);
    if ($count > 0) {
        $products = array();
        return $get_prod_res;
    } else {
        return "no products available";
    }
    }else {
        return "no products available";
    }
}

// GET A PRODUCT BY ITS PRODUCT ID
function getProductsById($conn, $id) {
    $sql = "SELECT * FROM `product` WHERE `product_id` = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $product_details = mysqli_fetch_assoc($result);

        // Decode product_images if stored as JSON
        $product_details['product_images'] = json_decode($product_details['product_images'], true);

        return $product_details;
    }

    return null;
}

// get products for the index view --to resolve this redunduncy later 
function getProductsForIndex($conn) {
    $sql = "SELECT * FROM `product`";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $product_details = mysqli_fetch_assoc($result);

        // Decode product_images if stored as JSON
        $product_details['product_images'] = json_decode($product_details['product_images'], true);

        return $product_details;
    }

    return null;
}

// GET ALL PRODUCT DETAILS AND THE SPECIFICATIONS 
function getProductSpecifications($conn,$id){
    $sql = "SELECT * FROM `product_specifications` WHERE `product_id` = '$id'";
    $run = mysqli_query($conn,$sql);
    if ($run) {
        $row = mysqli_num_rows($run);
            if ($row > 0) {
                return mysqli_fetch_assoc($run);
            } else {
                return "no products available";
            }
            
    } else {
        return "failed";
    }
    
}

// ADD A NEW PRODUCT TO THE DB
function add($conn, $unsanitized_data, $images) {
    $data = $this->sanitizeProductData($unsanitized_data);
    $uploaded_images = $this->uploadImages($images);

    if ($data !== false && $uploaded_images !== false) {
        $images_json = json_encode($uploaded_images); 
        

        $gen_id = rand(0, 9000); // Generate random ID
        $sql = "INSERT INTO `product` (`product_id`, `category_id`, `product_name`, `product_description`, `old_price`, `new_price`, `featured`, `active`, `product_images`) 
                VALUES ('$gen_id', '{$data['cat_id']}', '{$data['name']}', '{$data['description']}', '{$data['old_price']}', '{$data['new_price']}', '{$data['featured']}', '{$data['active']}', '$images_json')";
    $spec = $this->addSpecs($unsanitized_data,$gen_id,$conn);
        return mysqli_query($conn, $sql) ? true : false;
    }

    return false;
}


// method for deletion 
function delete($id,$conn){
    $delete_product = "DELETE FROM product WHERE `product`.`product_id` = '$id'";
    $delete_specs = "DELETE FROM product WHERE `product`.`product_id` = '$id'";
        $exc_del_spec = mysqli_query($conn,$delete_specs);
        $exc_del_prod = mysqli_query($conn,$delete_product);
        if ($exc_del_prod) {
            # code...
            return true;
        }
    }

// add product specifications
function addSpecs($data,$id,$conn){
    $fit = $data['spec_size'];
    $size = $data['size'];    
    $colour = $data['spec_color'];
    $for = $data['dressFor?'];
    $details = $data['spec_comment'];
    $add_specs = "INSERT INTO `product_specifications` (`size`, `colour`, `dressFor?`, `fit`, `product_id`, `details`) 
    VALUES ('$size', '$colour', '$for', '$fit', '$id', '$details')";
    $exc_add_spec = mysqli_query($conn,$add_specs);
    if (!$exc_add_spec) {
        # code...
        // return mysqli_error($conn);
        return $exc_add_spec;    
    }
}
// SANITIZE USER INPUT WHEN ADDING A NEW PRODUCT 
    function sanitizeProductData($product_input){
                $errors = array();
        
                // Check if prod_name is set
                if (empty($product_input['prod_name'])) {
                    $errors[] = "Please enter the product name";
                } else {
                    $prod_name = $product_input['prod_name'];

                }
        
                // Check if prod_desc is set
                if (empty($product_input['prod_desc'])) {
                    $errors[] = "Please enter the product description";
                } else {
                    $prod_desc = $_POST['prod_desc'];
                    
                }
        
                // Check if old_price is set
                if (empty($product_input['old_price'])) {
                    $errors[] = "Please enter the old price";
                } else {
                    $old_price = $product_input['old_price'];
                    
                }
        
                // Check if new_price is set
                if (empty($product_input['new_price'])) {
                    $errors[] = "Please enter the new price";
                } else {
                    $new_price = $product_input['new_price'];
                    
                }
        
                // Check if cat_id is set
                if (empty($_POST['cat_id'])) {
                    $errors[] = "Please select a product category";
                } else {
                    $cat_id = $product_input['cat_id'];
                    
                }
        
                // Check if active and featured are set
                if (empty($product_input['active'])) {
                    $errors[] = "Please choose if the product is active";
                } else {
                    $active = $product_input['active'];
                }
        
                if (empty($product_input['featured'])) {
                    $errors[] = "Please choose if the product is featured";
                } else {
                    $featured = $product_input['featured'];
                }
        
                // If there are no errors, update the product
                if (empty($errors)) {
                    $data = array(
                        // 'images' => $images,
                        'name' => $prod_name,
                        'description' => $prod_desc,
                        'old_price' => $old_price,
                        'new_price' => $new_price,
                        'cat_id' => $cat_id,
                        'active' => $active,
                        'featured' => $featured
                    );
                        return $data;

                }
        
                // Output any errors
                if (!empty($errors)) {
                    // return $errors;
                    return false;
                }
            }

           
// UPLOAD IMAGES 
function uploadImages($images) {
    $uploaded_images = [];
    $errors = [];

    // Check if the directory exists; if not, create it.
    if (!file_exists(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0777, true);
    }

    // Count the total number of files
    $totalFiles = count($images['name']);

    // Process each file
    for ($i = 0; $i < $totalFiles; $i++) {
        $imageName = basename($images['name'][$i]);
        $imageTmpName = $images['tmp_name'][$i];
        $imageError = $images['error'][$i];

        // Sanitize file name
        $imageName = preg_replace('/[^\w.-]/', '_', $imageName); // Replace invalid characters with underscores
        $destinationPath = UPLOAD_DIR . '/' . uniqid("img_", true) . "_" . $imageName;

        // Validate the file before upload
        if ($imageError !== UPLOAD_ERR_OK) {
            $errors[] = "Error uploading file: $imageName. Error Code: $imageError.";
            continue; // Skip to the next file
        }

        // Move the file to the destination directory
        if (move_uploaded_file($imageTmpName, $destinationPath)) {
            $uploaded_images[] = basename($destinationPath); // Store the sanitized file name
        } else {
            $errors[] = "Failed to upload image: $imageName.";
        }
    }

    // Return uploaded images or false if none were uploaded
    return empty($uploaded_images) ? false : $uploaded_images;
}

            
            
}

?>