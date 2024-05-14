<?php
    session_start();
    $AdminID = $_SESSION['AdminID'];
    if (!isset($AdminID)) {
        header('Location: index.php'); 
        exit;
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Category</title>
    <link rel="stylesheet" href="css/categorieslist.css">
</head>
<body>
    <div id="container">
    <aside id="sidebar">
    <div class="sidebar-item">
        <img src="images/quickbuy logo.png" class="sidebar-icon logo-icon" />
        <div class="sidebar-label">QuickBuy</div>
    </div>
    <br><br>
    <button class="sidebar-item" onclick="location.href='dashboard.php'">
        <img src="images/icon_home.png" class="sidebar-icon" />
        <span class="sidebar-label">Dashboard</span>
    </button>
    <br><br>
    <button class="sidebar-item" onclick="location.href='Customers.php'">
        <img src="images/icon_profile.png" class="sidebar-icon" />
        <span class="sidebar-label">Customers</span>
    </button>
    <br><br>
    <button class="sidebar-item" onclick="location.href='productslist.php'">
        <img src="images/icon_bookmark.png" class="sidebar-icon" />
        <span class="sidebar-label">Products</span>
    </button>
    <br><br>
    <button class="sidebar-item" onclick="location.href='categorieslist.php'" id="categories"> 
        <img src="images/icon_category.png" class="sidebar-icon" />
        <span class="sidebar-label">Categories</span>
    </button>
    <br><br>
    <button class="sidebar-item" onclick="location.href='orderslist.php'" id="orders">
        <img src="images/icon_orders.png" class="sidebar-icon" />
        <span class="sidebar-label">Orders</span>
    </button>
    <br><br><br>
    <button class="sidebar-item" onclick="location.href='profile.php'"> 
        <img src="images/icon_profile.png" class="sidebar-icon" />
        <span class="sidebar-label">Profile</span>
    </button> 
    <br><br>
    <button class="sidebar-item" onclick="location.href='Logout.php'"> 
        <img src="images/logout.png" class="sidebar-icon" />
        <span class="sidebar-label">Log out</span>
    </button>
</aside>
             <div id="new-category-container">
        <h2>Add New Category</h2>
        <form id="add-category-form">
            <input type="text" id="cat-name" placeholder="Category Name" required>
            <input type="text" id="cat-desc" placeholder="Description" required>
            <input type="number" id="cat-quantity" placeholder="Quantity" required>
            <button type="submit">Add Category</button>
        </form>
    </div>
    <script src="newCategory.js"></script>
</body>
</html>