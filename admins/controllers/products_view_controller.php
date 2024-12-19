<?php
   
        $product = new product();


// handle actions 
if (isset($_POST['state'])) {
    # code...
    if ($_POST['state'] == 'add_product') {
        # code...
        $data = array();
        $images = array();
        $data = $_POST;
        if (isset($_FILES['images'])) {
            $images = $_FILES['images'];
            $checked_input = $product->add($conn,$data,$images);
            var_dump($checked_input);
        }
        
        
    }
    
} 

// handle product deletion
if (isset($_GET['id'])) {
    # code...
    $delete = $product->delete($_GET['id'],$conn);
    if ($delete) {
        # code...
        echo 'deleting';
    }
    var_dump($delete);
}
$category = new product_category();
        $categories = $category->getCategoriesAsArray($conn);
        // unbundele the array
        foreach ($categories as $cat) {
            # code...
            $category_name = $cat['category_name'];
            $category_id = $cat['category_id'];
            // lets add the new products form here 
            include 'views/admin-category-add-product.html';
                // lets handle the products under this category now 
                $product = new product();
                    $products = $product->getProductsByCategoryId($conn,$category_id);
                    // if the category is empty write code to by pass it 
                        // lets unbundle the products 
                        foreach ($products as $prod) {
                            # code...
                            $product_name = $prod['product_name'];
                            $new_price = $prod['new_price'];
                            $old_price = $prod['old_price'];
                            $active = $prod['active'];
                            $featured = $prod['featured'];
                            $product_id = $prod['product_id'];
                            include 'views/admin-products-view.html';
                        }
            ?>
                         </div>
                </div>
            </div>
        </div>
    </div>
            <?php
        }
    
?>