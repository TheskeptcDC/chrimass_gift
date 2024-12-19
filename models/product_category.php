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
     function select_active_category_names($conn){
        $sql = "SELECT * FROM product_category WHERE active = 'yes'";
        $query = mysqli_query($conn,$sql);
        $count = mysqli_num_rows($query);

        // check number of categories if they exeed one the show else give output no categories in db
        if ($count > 0) {
            $active_categories = array();
            while ($rows = mysqli_fetch_assoc($query)) {
                $active_categories[] = $rows['category_name']; 
            }
            return $active_categories;
        } else {
            return "DB returned no results";
        }
    }

    //to search for categories
    function search_category($look){
        // $sql = "SELECT * FROM product_category WHERE active = 'yes' AND featured = 'yes' ";
        $sql = "SELECT * FROM product_category WHERE active = 'yes' AND category_name LIKE '%$look%' OR category_description LIKE '%$look%'  ";
        return $sql;
    }

   // To display the category
 

    // Function for getting the category ID based on the result object
    function getCategoriesAsArray($conn) {
        $sql = "SELECT * FROM `product_category`";
            $res = mysqli_query($conn,$sql);
        if ($res && mysqli_num_rows($res) > 0) {
            if ($res) {
                $categories = [];
                while ($row = mysqli_fetch_assoc($res)) {
                    $categories[] = $row;
                }
                return $categories;
            }
        } else {
            return [];
        }
    }

    //FUNCTIONS USED BY THE ADMIN 
    
        function add($conn, $data) {
            $cat_name = mysqli_real_escape_string($conn, $data['name']);
            $promo_text = mysqli_real_escape_string($conn, $data['promo_text']);
            $description = mysqli_real_escape_string($conn, $data['description']);
            $featured = isset($data['featured']) ? $data['featured'] : 'no';
            $active = isset($data['active']) ? $data['active'] : 'no';
    
                
            $sql = "INSERT INTO product_category SET 
                    category_name = '$cat_name',
                    category_prom_text = '$promo_text',
                    category_description = '$description',
                    featured = '$featured',
                    active = '$active'";
    
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
        $description =$data['description'];
    
        // Create the SQL update query
       $sql = "UPDATE `product_category` SET 
        `category_name` = '$cat_name',
        `active` = '$active',
        `category_description` = '$description',
        `featured` = '$featured',
         `category_description` = '$description',
          `category_prom_text` = '$promo_text'
           WHERE `category_id` = '$cat_id' ";
    
        // Execute the query
        $res = mysqli_query($conn, $sql);
    
        // Check if the query was successful and return true or false
        if ($res && mysqli_affected_rows($conn) > 0) {
            return true;
        } else {
            // return false;
            return $sql;
        }
    }
    
}


?>

