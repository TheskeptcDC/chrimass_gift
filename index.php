<?php
// include all the necessary classes and files
    include 'models/product.php';
    include 'models/product_category.php';
    include 'config/constants.php';

// add the header at the top of each page
    include 'views/top-nav.html';

// control flow for router
    if (isset($home)) {
        # code...
    }elseif (isset($detailed_view)) {
        # code...
    } {
        include 'controllers/index_product_controller.php';
    }elseif ($view_cart) {
        # code...
    }elseif ($checkout) {
        # code...
    }
    
// add footer at the bottom of each page
    include 'views/footer-view.html';

?>