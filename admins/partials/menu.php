<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>johms boutique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">
            
        </h1>

        <!-- Navbar -->
        <nav class="navbar bg-light" style="width: 100%">
            <div class="container-fluid">
                <!-- Hamburger button -->
                <button 
                    class="btn btn-outline-secondary" 
                    type="button" 
                    data-bs-toggle="offcanvas" 
                    data-bs-target="#offcanvasNav" 
                    aria-controls="offcanvasNav">
                    <!-- Hamburger icon from Bootstrap Icons -->
                    <b><i class="bi bi-list"></i></b>
                </button>
                <div class="logo-name">
                    <b>JOHMS ADMIN</b>
                </div>
                <span class="navbar-brand mb-0 h1">
                    <a href="index.php?action=login" style="text-decoration: none;">
                        <i class="bi bi-person-circle"></i>
                    </a>
                    <i class="bi bi-search search-toggle"></i>
                    <i class="bi bi-envelope-plus"></i>
    
                </span>
            </div>
            <div class="search-bar" style="display: none;">
                <form action="index.php" method="get" class="d-flex">
                    <input 
                        type="text" 
                        name="query" 
                        class="form-control me-2" 
                        placeholder="Search for products" 
                        required>
                    <input type="hidden" name="action" value="search">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
            
        </nav>

        <!-- Offcanvas Sidebar -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNav" aria-labelledby="offcanvasNavLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavLabel">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="list-group">
                    <li class="list-group-item"><a href="index.php?action=dashboard" >Dashboard</a></li>
                    <li class="list-group-item"><a href="index.php?action=products">products</a></li>
                    <li class="list-group-item"><a href="index.php?action=categories">categories</a></li>
                    <li class="list-group-item"><a href="index.php?action=orders">orders</a></li>
                    <li class="list-group-item"><a href="#">logout</a></li>
                    <li class="list-group-item"><a href="#">add new admin</a></li>
                </ul>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
