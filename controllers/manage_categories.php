<?php
require_once '../config/constants.php';
require_once '../models/product_category.php';
// require_once '../models/functions.php';

$category = new product_category();
// delete a category
if (isset($_GET['cat_del'])) {
    $cat_id = $_GET['cat_del'];
    if ($category->delete($conn, $cat_id)) {
        $_SESSION['success_message'] = "Category deleted successfully.";
    } else {
        $_SESSION['error_message'] = "Failed to delete category. Make sure this category is empty first.";
    }
    header("Location: ../admins/index.php#manage_categories");
    exit();
}

// make updates ..
if (isset($_POST['update_cat'])) {
    $data = [
        'cat_id' => sanitize_input($_POST['cat_id']),
        'cat_name' => sanitize_input($_POST['cat_name']),
        'promo_text' => sanitize_input($_POST['promo_text']),
        'description' => sanitize_input($_POST['description']),
        'active' => sanitize_input($_POST['active']),
        'featured' => sanitize_input($_POST['featured'])
    ];
    $category = new product_category();
    $errors = $category->validateCategoryData($data); 

    if (empty($errors)) {
        if ($category->update($conn, $data)) {
            $_SESSION['success_message'] = "Category updated successfully.";
        } else {
            $_SESSION['error_message'] = "Failed to update category.";
        }
    } else {
        $_SESSION['error_message'] = implode("<br>", $errors);
        ?>
            <script>
                alert('failed')
            </script>
        <?php
    }
    header("Location: ../admins/index.php");
    exit();
}

// Fetch all categories
$categories = $category->selectAll($conn);

// Include the view
include '../admins/views/view_categories.php';
?>