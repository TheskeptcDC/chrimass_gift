<?php

class product_category{
    //public $cat_id;
    

    function selectAll($conn){
        $sql = "SELECT * FROM product_category WHERE active = 'yes' ";
        $get_cat_res = mysqli_query($conn,$sql);
        return $get_cat_res;
    }
    //to select featured and active categories 
    function select_active_featured(){
        $sql = "SELECT * FROM product_category WHERE active = 'yes' AND featured = 'yes' ";
        return $sql;
    }
    //to sectect active featured cats withe the conn parameter 
    function active_featured($conn){
        $sql = "SELECT * FROM product_category WHERE active = 'yes' AND featured = 'yes' ";
        $get_cat_res = mysqli_query($conn,$sql);
        return $get_cat_res;
    }

     //to select active  categories only
     function select_active(){
        $sql = "SELECT * FROM product_category WHERE active = 'yes'";
        return $sql;
    }

    //to search for categories
    function search_category($look){
        // $sql = "SELECT * FROM product_category WHERE active = 'yes' AND featured = 'yes' ";
        $sql = "SELECT * FROM product_category WHERE active = 'yes' AND category_name LIKE '%$look%' OR category_description LIKE '%$look%'  ";
        return $sql;
    }

   // To display the category
 

    // Function for getting the category ID based on the result object
    function displayCategory($res) {
        if ($res && mysqli_num_rows($res) > 0) {
            $categories = "";
            while ($rows = mysqli_fetch_assoc($res)) {
                $id = htmlspecialchars($rows['category_id']);
                $p_cat = htmlspecialchars($rows['category_name']);
                $promo_text = htmlspecialchars($rows['category_prom_text']);
                $cat_desc = htmlspecialchars($rows['category_description']);
                $categories = "<h1 class='latest'>{$id}<span>{$promo_text}</span></h1><div class='box-container'>";
            }
            return $categories;
        } else {
            return [];
        }
    }

    // Function for getting the category data based on the result object
    function displayCategoryData($res) {
        if ($res && mysqli_num_rows($res) > 0) {
            $categories = array(); 
    
            while ($rows = mysqli_fetch_assoc($res)) {
                $category = array(
                    'id' => htmlspecialchars($rows['category_id']),
                    'name' => htmlspecialchars($rows['category_name']),
                    'promo_text' => htmlspecialchars($rows['category_prom_text']),
                    'description' => htmlspecialchars($rows['category_description'])
                );
                
                $categories[] = $category;
            }
            
            return $categories;
        } else {
            return [];
        }
    }

    // for form validation
    function validateCategoryData($postData) {
        $errors = [];
        
        // Validate category name
        if (!isset($postData['cat_name']) || empty(trim($postData['cat_name']))) {
            $errors[] = "Please enter the category name";
        }
        
        // Validate promotional text
        if (!isset($postData['promo_text']) || empty(trim($postData['promo_text']))) {
            $errors[] = "Please enter a promotional text";
        }
        
        // Validate category ID ---SINCE WE ARE USING THIS CLASS FOR BOTH THE ADD TO CAT AND UPDATE CAT-- SO IT CONFLICTS
        if (!isset($postData['cat_id']) && !isset($postData['cat_name'])) {
            $errors[] = "Please select a product category";
        }
        
        if (!isset($postData['cat_name']) || empty($postData['cat_name'])) {
            $errors[] = "Please select a product category";
        }
        // Validate active status
        if (!isset($postData['active']) || !in_array($postData['active'], ['yes', 'no'])) {
            $errors[] = "Please choose if the category is active";
        }
        
        // Validate featured status
        if (!isset($postData['featured']) || !in_array($postData['featured'], ['yes', 'no'])) {
            $errors[] = "Please choose if the category is featured";
        }
        
        return $errors;
    }
    

    //FUNCTIONS USED BY THE ADMIN 
    
        function add($conn, $data) {
            $cat_name = mysqli_real_escape_string($conn, $data['name']);
            $promo_text = mysqli_real_escape_string($conn, $data['promo_text']);
            $description = mysqli_real_escape_string($conn, $data['description']);
            $featured = isset($data['featured']) ? $data['featured'] : 'no';
            $active = isset($data['active']) ? $data['active'] : 'no';
            $image_name = '';
    
            // Handle file upload
            if (isset($data['image']) && $data['image']['name'] != "") {
                $image_name = $data['image']['name'];
                $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                $image_name = "category_" . rand(000, 999) . '.' . $ext;
    
                $source_path = $data['image']['tmp_name'];
                $destination_path = "assets/categories/" . $image_name;
    
                // Create directory if it doesn't exist
                if (!file_exists("assets/categories/")) {
                    mkdir("assets/categories/", 0777, true);
                }
    
                $upload = move_uploaded_file($source_path, $destination_path);
    
                if (!$upload) {
                    return [
                        'success' => false,
                        'message' => "Failed to upload image."
                    ];
                }
            }
    
            $sql = "INSERT INTO product_category SET 
                    category_name = '$cat_name',
                    category_prom_text = '$promo_text',
                    category_description = '$description',
                    featured = '$featured',
                    active = '$active',
                    image_name = '$image_name'";
    
            $res = mysqli_query($conn, $sql);
    
            if ($res) {
                return [
                    'success' => true,
                    'message' => "New category added successfully."
                ];
            } else {
                return [
                    'success' => false,
                    'message' => "Failed to add new category: " . mysqli_error($conn)
                ];
            }
        }
    


    function delete($conn, $id) {
        try {
            $sql = "DELETE FROM `product_category` WHERE category_id = $id";
            $isDeleted = mysqli_query($conn, $sql);
    
            if ($isDeleted) {
                if (mysqli_affected_rows($conn) > 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            // Handle foreign key constraint error
            if ($e->getCode() == 1451) {
                // Error code for foreign key constraint failure
                error_log("Cannot delete or update a parent row: a foreign key constraint fails");
                return false;
            } else {
                // Other SQL errors
                error_log("MySQL error: " . $e->getMessage());
                return false;
            }
        }
    }
// function to update the categories 
    function update($conn, $data) {
        // Extract data from the associative array
        $cat_name = $data['name'];
        $cat_id = $data['id'];
        $active = $data['active'];
        $featured = $data['featured'];
        $promo_text = $data['promo_text'];
    
        // Create the SQL update query
        $sql = "UPDATE `product_category` SET 
        `category_name` = '$cat_name',
        `active` = '$active',
        `featured` = '$featured',
         `category_description` = '',
          `category_prom_text` = '$promo_text'
           WHERE `product_category`.`category_id` = $cat_id";
    
        // Execute the query
        $res = mysqli_query($conn, $sql);
    
        // Check if the query was successful and return true or false
        if ($res && mysqli_affected_rows($conn) > 0) {
            return true;
        } else {
            return false;
        }
    }
    
}


?>

