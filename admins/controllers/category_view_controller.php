<?php
// Include necessary configurations and database connection

// Initialize variables
$errors = [];
$success_message = '';
 $category = new product_category();
// Handle Add Category
if (isset($_POST['submit'])) {
    // Sanitize and validate category name
    $category_name = mysqli_real_escape_string($conn, trim($_POST['category_name']));
    $category_description = mysqli_real_escape_string($conn, trim($_POST['category_description']));
    $promo_text = mysqli_real_escape_string($conn, trim($_POST['promo_text']));
    
    // Validate category name
    if (empty($category_name)) {
        $errors[] = "Category name cannot be empty";
    } elseif (strlen($category_name) < 2) {
        $errors[] = "Category name must be at least 2 characters long";
    }
      // Validate category description
      if (empty($category_description)) {
        $errors[] = "Category description cannot be empty";
    } elseif (strlen($category_description) < 5) {
        $errors[] = "Category description must be at least 5 characters long";
    }

      // Validate category promo text
      if (empty($promo_text)) {
        $errors[] = "please add a phrase to describe this category, it cannot be empty";
    } elseif (strlen($promo_text) < 5) {
        $errors[] = "Category description must be at least 5 characters long";
    }
    // If no errors, proceed with database insertion
    if (empty($errors)) {
        // toss the data into an array 
        $data = array();
        $data['name'] = $category_name;
        $data['description'] = $category_description;
        $data['promo_text'] = $promo_text;
            
           
            $result = $category->add($conn,$data);
            
            if ($result) {
                $success_message = "Category Added Successfully";
                // Optionally clear the form
                $_POST['category_name'] = '';
            } else {
                $errors[] = "Failed to add category. " . mysqli_error($conn);
            }
        }
    }


// Handle Delete Category
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);  //make id int value
    $delete_result = $category->delete($conn,$id);
    if ($delete_result) {
        $success_message = "Category Deleted Successfully";
    } else {
        $errors[] = "Failed to delete category. check if this category has child products ";
    }

    
}

// update categories
if (isset($_POST['state'])) {
    # code...
    $data = array();
    $data['name'] = $_POST['cat_name'];
    $data['description'] = $_POST["cat_description"];
    $data['active'] = $_POST['active'];
    $data['featured'] = $_POST['featured'];
    $data['promo_text'] = $_POST['promo_text'];
    $data['id'] = $_POST['cat_id'];
    $edited_category = $category->update($conn,$data);

    if ($edited_category == true) {
        # code...
        $success_message = 'category updated';

    }else {
        # code...
        $errors[] = "failed to update";
    }

}

// Fetch existing categories
$categories = $category->getCategoriesAsArray($conn);
?>