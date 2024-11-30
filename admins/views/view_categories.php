    <style>
        /* Add your styles here */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .heading {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .table-responsive {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        input[type="text"], input[type="submit"] {
            padding: 5px;
        }
        .btn {
            padding: 5px 10px;
            color: white;
            border: none;
            cursor: pointer;
        }
        .btn-success {
            background-color: #4CAF50;
        }
        .btn-danger {
            background-color: #f44336;
        }
    </style>
    <div class="heading">Categories</div>

    <div class="table-responsive" id="cat_update">
        <table class="table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Promo</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <form action="../controllers/manage_categories.php" method="POST">
                            <td>
                                <input type="text" name="cat_name" value="<?php echo htmlspecialchars($category['category_name']); ?>">
                            </td>
                            <td>
                                <input type="text" name="promo_text" value="<?php echo htmlspecialchars($category['category_prom_text']); ?>">
                            </td>
                            <td>
                                <input type="radio" name="featured" value="yes" <?php echo ($category['featured'] == 'yes') ? 'checked' : ''; ?>>Yes
                                <input type="radio" name="featured" value="no" <?php echo ($category['featured'] == 'no') ? 'checked' : ''; ?>>No
                            </td>
                            <td>
                                <input type="radio" name="active" value="yes" <?php echo ($category['active'] == 'yes') ? 'checked' : ''; ?>>Yes
                                <input type="radio" name="active" value="no" <?php echo ($category['active'] == 'no') ? 'checked' : ''; ?>>No
                            </td>
                            <td>
                                <input type="hidden" name="cat_id" value="<?php echo $category['category_id']; ?>">
                                <input type="submit" name="update_cat" value="Update" class="btn btn-success">
                            </td>
                        </form>
                        <td>
                            <a href="../controllers/manage_categories.php?cat_del=<?php echo $category['category_id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>