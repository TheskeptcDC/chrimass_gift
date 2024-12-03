<?php
// include all the necessary classes and files
    include 'models/product.php';
    include 'models/product_category.php';
    include 'config/constants.php';

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
        echo "in home";
        include 'controllers/index_product_controller.php';
    }elseif ($action == 'detailed_view') {
        if (isset($_GET['id'])) {//check if product id is set
            # code...
            $id = $_GET['id'];
            include 'controllers/detailed_product_controller.php';//show product details
            
            //display similar products
            include 'controllers/related_category_products_controller.php';
        } else {
            //display the home 
            $action = 'home';
        }
    } elseif ($action == 'view_cart') {
        # code...
        include 'views/cart-view.html';
    }elseif (isset($checkout)) {
        # code...
    }elseif ($action =='category') {
        if (isset($_GET['name'])) {
            $name = $_GET['name'];
            // DISPLAY THE PRODUCTS IN THE NAMED CATEGORY
            include 'controllers/index_product_by_category_controller.php';
            // DISPLAY RELATED PRODUCTS 
            include 'controllers/related_category_products_controller.php';
            // DISPLAY THE REST OF THE PRODUCTS 
            include 'controllers/index_product_controller.php';
        }elseif ($action == 'search') {
            # code...
            echo "we in";
            if (isset($_GET['query'])) {
                # code...
                $query = $_GET['query'];
                include 'controllers/search_results_controller.php';
            } else {
                # code...
                $action = 'home';
            }
            
        }
        else {
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

