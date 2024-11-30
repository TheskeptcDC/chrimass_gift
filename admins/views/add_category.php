<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <style>
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #f5f5f5;
            --text-color: #333;
            --border-color: #ddd;
        }
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--secondary-color);
            margin: 0;
            padding: 0;
        }
        .main-content {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        h2 {
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 0.5rem;
            margin-bottom: 2rem;
        }
        form {
            display: grid;
            gap: 1rem;
        }
        .form-group {
            display: grid;
            gap: 0.5rem;
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 1rem;
        }
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        .radio-group {
            display: flex;
            gap: 1rem;
        }
        .primary-button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .primary-button:hover {
            background-color: #3a7bc8;
        }
        @media (max-width: 600px) {
            .main-content {
                padding: 1rem;
            }
            form {
                gap: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="main-content">
        <h2>Add Category</h2>
        <?php
        if (isset($_SESSION['error_message'])) {
            echo "<div class='error' style='color: red; margin-bottom: 1rem;'>" . $_SESSION['error_message'] . "</div>";
            unset($_SESSION['error_message']);
        }
        ?>
        <form action="../controllers/add_category_controller.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5"></textarea>
            </div>
            <div class="form-group">
                <label for="promo_text">Promotional text</label>
                <textarea id="promo_text" name="category_prom_text" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label>Featured</label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="featured" value="yes"> Yes
                    </label>
                    <label>
                        <input type="radio" name="featured" value="no" checked> No
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label>Active</label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="active" value="yes" checked> Yes
                    </label>
                    <label>
                        <input type="radio" name="active" value="no"> No
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            <div class="form-group">
                <button type="submit" name="submit" class="primary-button">Add Category</button>
            </div>
        </form>
    </div>
</body>
</html>