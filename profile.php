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
    <meta charset="utf-8">
    <title>Admin Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/sidebar.css">
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
    <button class="sidebar-item" onclick="location.href='#'">
        <img src="images/customers.png" class="sidebar-icon" />
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
    <button class="sidebar-item" onclick="location.href='profile.php'" id="profile"> 
        <img src="images/icon_profile.png" class="sidebar-icon" />
        <span class="sidebar-label">Profile</span>
    </button> 
    <br><br>
    <button class="sidebar-item" onclick="location.href='#'"> 
        <img src="images/logout.png" class="sidebar-icon" />
        <span class="sidebar-label">Log out</span>
    </button>
</aside>
    <div class="container" id="profileContainer">
        <!-- The profile information will be populated here by profile.js -->
    </div>

    <script src="profile.js"></script>
</body>
</html>
