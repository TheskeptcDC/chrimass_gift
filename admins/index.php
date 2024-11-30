<?php
        require('partials/menu.php');
        require('../models/product_category.php');
        require('../models/product.php');
        
      //   HERE WE HANDLE SESSIONS AND ALERTS 

      if (isset( $_SESSION['success_message'])) {
         ?>
            <script>
               alert('success')
            </script>
         <?php
      }

      // alert failure
      if (isset($_SESSION['error_message'])) {
         echo $_SESSION['error_message'];
      }

      // AKERT HUNDLING ENDS 

         //   HERE WE SHOW PRODUCTS BY CATEGORY ...ALSO ALLOWING ADMIN TO ADD ANEW PRODUCT
            include 'views/view_products.php';

         //  HERE WE ADD A NEW CATEGORY 
         
            include 'views/add_category.php';
         
         // UPTO HERE  

         // VIEW CATEGORIES HERE
?>
<div class="manage_categories">

   <?php
      include '../controllers/manage_categories.php';
   ?>

</div>

<?php
           

         // UPTO HERE 
         
         // HERE WE SHOW FOOTER CONTENT 

            include('partials/footer.php');

         // UPTO HERE 

?>

