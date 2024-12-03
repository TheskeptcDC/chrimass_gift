<?php
$category = new product_category();

    // select all the categories in the database 
$categories = $category->select_active_category_names($conn);
    // check db state on categories 
    
    if ($categories == "DB returned no results") {
        echo "no cats";
    } else {
        $number_of_categories = count($categories) - 1;
        while ($number_of_categories > 0) {
            echo '<li class="list-group-item"><a href="index.php?action=category&name=' . $categories[$number_of_categories] . '">' . $categories[$number_of_categories] . '</a></li>';

            $number_of_categories = $number_of_categories - 1;
        }
    }
    
?>