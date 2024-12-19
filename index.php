<?php
// include all the necessary classes and files
    include 'models/product.php';
    include 'models/product_category.php';
    include 'config/constants.php';
//logic for login here before headrs are sent 
if (isset($_GET['action']) == false && isset($_POST['action']) == false) {
    # code...
    $action = 'home';
}
if (isset($_GET['action']) || isset($_POST['action'])) {
    
    # code...

    if($_GET['action'] == 'login'){
        include 'controllers/login_controller.php';
        include 'views/login-view.html';
        exit();
    }
}
// add the header at the top of each page
    include 'views/top-nav.html';
//include the cart
include 'views/cart-view.html';
// scan url and assign variables
if (isset($_GET['action'])) {
    $action = $_GET['action'];
        }else {
            $action = 'home';
}

// control flow for router
   
if ($action == 'home') {
    # code...
    include 'controllers/index_product_controller.php';
} elseif ($action == 'detailed_view') {
    //DISPLAY THE PRODUCT CLICKED ON AND SOME RELATED PRODUCTS BELOW IT 
    include 'controllers/detailed_product_controller.php';
    include 'controllers/related_category_products_controller.php';//display related products 
} elseif ($action == 'view_cart') {
    # code...
    include 'views/cart-view.html';
} elseif ($action == 'search') {
    include 'controllers/index_product_controller.php';
} elseif ($action == 'category') {
    if (isset($_GET['name'])) {
        $name = $_GET['name'];
        // DISPLAY THE PRODUCTS IN THE NAMED CATEGORY
        include 'controllers/index_product_by_category_controller.php';
        // DISPLAY RELATED PRODUCTS 
        include 'controllers/related_category_products_controller.php';
        // DISPLAY THE REST OF THE PRODUCTS 
        include 'controllers/index_product_controller.php';
    } else {
        $action = 'home';
    }
}
    
    
// add footer at the bottom of each page
    include 'views/footer-view.html';
?>
<!-- //include the much needed javascript  -->
<script src="js/cart.js"></script>
<script src="js/search.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

