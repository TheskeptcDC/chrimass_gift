<?php
    class product
    {


        function getProducts($conn){
            $sql = "SELECT `product_name`, `single_image`, `comment`, `new_price`, `old_price` FROM `product` WHERE `active` = 'yes'";
            $run = mysqli_query($conn,$sql);
            if ($run) {
                $row = mysqli_num_rows($run);
                    if ($row > 0) {
                        return $run;
                    } else {
                        return "no products available";
                    }
                    
            } else {
                return "failed";
            }
            
        }
    
    
    // TO GET PRODUCTS FROM A PARTICULAR CATEGORY
    function selectFromCategory($conn, $cat_id){
        $get_prod = "SELECT * FROM product WHERE category_id = $cat_id AND active = 'yes'";
        $get_prod_res = mysqli_query($conn, $get_prod);
        return $get_prod_res;
    }
}
?>