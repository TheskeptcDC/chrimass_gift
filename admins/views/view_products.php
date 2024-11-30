<div class="heading" id="products">products</div>
        <div class="container table-responsive">
         <table class="table">
<?php
    //lets get the data for the catalog
    $category = new product_category($conn);
    $res = $category->selectAll($conn);
    if ($res && mysqli_num_rows($res)>0) {
          #get the datainto the array $rows
            while ($rows = mysqli_fetch_assoc($res)) {
                $cat_id = $rows['category_id'];
                $p_cat = $rows['category_name'];
                $promo_text = $rows['category_prom_text'];
                $cat_desc = $rows['category_description'];
?>
          <tr>
    <th><?php echo $p_cat; ?></th>
    <th>
        <form action="admin_ops/add_product.php" method="post" enctype="multipart/form-data">
            <td><b><input type="text" name="prod_name" placeholder="new product" required></b></td>
            <td><input type="text" name="new_price" placeholder="new price"></td>
            <td><input type="text" name="old_price" placeholder="old price"></td>
            <td>
                <textarea name="prod_desc" placeholder="description"></textarea>
            </td>
            <td>
                <input type="radio" name="active" value="yes"> Active
                <input type="radio" name="active" value="no" required> Inactive
            </td>
            <td>
                <input type="radio" name="featured" value="yes"> Featured
                <input type="radio" name="featured" value="no"> Not Featured
            </td>
            <td>
                <input type="hidden" name="cat_id" value="<?php echo $cat_id; ?>">
                <input type="hidden" name="prod_id" value="">
            </td>
            <tr>
                <td><img src="" alt="product image"></td>
                <td><input type="file" name="images[]" multiple></td>
                <td><input type="submit" name="add_prod" value="Add" class="btn add_cat"></td>
            </tr>
        </form>
    </th>
</tr>

<?php
        // for the products in the loaded category
        $product = new product();
        $get_prod_res = $product->selectFromCategory($conn,$cat_id);
                     if ($get_prod_res) {
                        $count = mysqli_num_rows($get_prod_res);
                        if ($count > 0) {
                            //the category has products
                            //get the products
                            while ($prod_rows = mysqli_fetch_assoc($get_prod_res)) {
                                $prod_name = $prod_rows['product_name'];
                                $prod_desc = $prod_rows['product_description'];
                                $prod_img = $prod_rows['product_images'];
                                $prod_id = $prod_rows['product_id'];
                                $old_price = $prod_rows['old_price'];
                                $new_price = $prod_rows['new_price'];
                                $active = $prod_rows['active'];
                                $featured = $prod_rows['featured'];
?>
            <tr>
               <th>product</th>
               <th>new price</th>
               <th>old price</th>
               <td>prod desc</td>
               <th>active</th>
               <th>featued</th>
               <th></th>
            </tr>
           
            <tr>
         <form action="../test.php" method="post" entype="multipart/form-data">
               <td><b><input type="text" name="prod_name" value="<?php echo $prod_name; ?>"></b></td>
               <td><input type="text" name="new_price" value="<?php echo $new_price;?>"></td>
               <td><input type="text" name="old_price" value="<?php echo $old_price; ?>"></td>
               <td>
                  <input type="textarea" name="prod_desc" value="<?php echo $prod_desc; ?>">
               </td>
               <td>
                  <input type="radio" name="active" value="yes" <?php if ($active == 'yes') {
                                                   echo "checked";
                                       } ?>>
                  <input type="radio" name="active" value="no"<?php if ($active == 'no') {
                                                                        echo "checked";
                                                            } ?>>
               </td>
               <td>
                  <input type="radio" name="featured" value="yes" <?php if ($featured == 'yes') {
                                                   echo "checked";
                                       } ?>>
                  <input type="radio" name="featured" value="no" <?php if ($featured == 'no') {
                                                                        echo "checked";
                                                            } ?>>
               </td>
               <td>
                  <?php echo $cat_id; ?>
                  <input type="hidden" name="cat_id" value="<?php echo $cat_id;?>"> 
                  <input type="hidden" name="prod_id" value="<?php echo $prod_id;?>">
               </td>
            </tr>
            <tr>
               <td><img src="<?php echo $prod_image;?>" alt="product image"></td>
               <td><input type="file" name="prod_image" value="<?php echo $prod_image; ?>"></td>
               <td><input type="submit" name="prod_update" class="btn btn-success add_cat" value="update"></td>
               <td><a href="./index.php?del_id=<?=$prod_id?>" class="btn btn-danger add_cat">delete</a></td>
         </form>
            </tr>
<?php
                            }
                           }else {
                              echo "<tr> <td> no products to show </td> </tr>";
                           }
                        }
?>

<?php
            }
         }
?>
 </table>
         </div>

<?php
//for deleting products
if (isset($_GET['del_id'])) {
   if ($_SERVER['REQUEST_METHOD'] == 'GET') {
       $prod_id = $_GET['del_id'];
       $prod_to_delete = new product();
       $isDeleted = $prod_to_delete->delete($conn,$prod_id);
       if ($isDeleted) {
           echo "deleting..$prod_id";

       }
   }else {
       echo "request error";
   }
   
}

?>