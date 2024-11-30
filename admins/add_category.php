<?php
include("partials/menu.php");
?>
<!-- main section starts-->
<div class="main-content">
    <div class="wrapper">
        <strong>
            <?php
            if (isset($_SESSION['cat-failed'])) {
                echo $_SESSION['cat-failed'];
                unset($_SESSION['cat-failed']);
            } else {
                echo "Add Category";
            }
            ?>
        </strong>
        <br>
        <!-- CODE FOR ADD category TABLE-->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="table-full">
                <tr>
                    <td>Title</td>
                    <td><input type="text" name="title" required></td>
                </tr>
                <tr>
                    <td>Descriptio</td>
                    <td><textarea name="description" rows="5" cols="30"></textarea></td>
                </tr>
                <tr>
                    <td>Featured</td>
                    <td>
                        <input type="radio" name="featured" value="yes"> Yes
                        <input type="radio" name="featured" value="no" checked> No
                    </td>
                </tr>
                <tr>
                    <td>Active</td>
                    <td>
                        <input type="radio" name="active" value="yes" checked> Ye
                        <input type="radio" name="active" value="no"> No
                    </td>
                </tr>
                <tr>
                    <td>Image</td>
                    <td>
                        <input type="file" name="image" accept="image/*">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="primary-button">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<!-- main section ends-->

<?php
include("partials/footer.php");

if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $featured = isset($_POST['featured']) ? $_POST['featured'] : 'no';
    $active = isset($_POST['active']) ? $_POST['active'] : 'no';

    $image_name = '';
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        $image_name = $_FILES['image']['name'];
        $ext = end(explode('.', $image_name));
        $image_name = "category_".rand(000, 999).'.'.$ext;

        $source_path = $_FILES['image']['tmp_name'];
        $destination_path = "../images/category/".$image_name;

        $upload = move_uploaded_file($source_path, $destination_path);

        if (!$upload) {
            $_SESSION['cat-failed'] = "Failed to upload image.";
            header('location:'.SITEURL.'admin/add-category.php');
            die();
        }
    }

    $sql = "INSERT INTO category SET 
            title = '$title',
            description = '$description',
            featured = '$featured',
            active = '$active',
            image_name = '$image_name'";

    $res = mysqli_query($conn, $sql);

    if ($res) {
        $_SESSION['cat-added'] = "New category added successfully.";
        header('location:'.SITEURL.'admin/manage-category.php');
    } else {
        $_SESSION['cat-failed'] = "Failed to add new category. " . mysqli_error($conn);
        header('location:'.SITEURL.'admin/add-category.php');
    }
}
?>