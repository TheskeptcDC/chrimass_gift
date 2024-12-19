<?php

        require('../config/constants.php');
        require('../config/login_check.php');
        require('partials/menu.php');
        require('../models/product_category.php');
        require('../models/product.php');

//get action value from url
if (isset($_GET['action'])) {
   # code...
   $action = $_GET['action'];
}elseif (isset($_POST['action'])) {
   # code...
   $action = $_POST['action'];
} else {
   # code...
   $action = 'dashboard';
}

        
//router functionality 
if ($action == 'dashboard') {
   # code...
   echo 'dashbord';
   echo UPLOAD_DIR;
} elseif ($action =='products') {
   # code...
   include 'controllers/products_view_controller.php';
}elseif ($action == 'categories') {
   # code...
   include 'controllers/category_view_controller.php';
   include 'views/admin-category-view.html';
}elseif ($action == 'orders') {
   # code...
   include 'controllers/manage_orders.php';
}elseif ($action == 'login') {
   # code...
   include 'controllers/login_controller.php';
   include '../views/login-view.html';
} else{
   # code...
   $action = 'dashboard';
   echo '';
}


         // UPTO HERE 
include 'partials/footer.php';

?>

