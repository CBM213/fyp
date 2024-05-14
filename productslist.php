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
    <title>Products List</title>
    <link rel="stylesheet" href="css/productslist.css">
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
        <img src="images/customers.png" class="sidebar-icon" />
        <span class="sidebar-label">Customers</span>
    </button>
    <br><br>
    <button class="sidebar-item" onclick="location.href='productslist.php'" id="products">
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
    <button class="sidebar-item" onclick="location.href='#'"> 
        <img src="images/logout.png" class="sidebar-icon" />
        <span class="sidebar-label">Log out</span>
    </button>
</aside>
        <main id="main-content">
            <header>
            <div class="main-search-input-wrap">
       
     
       <div class="main-search-input fl-wrap">
                                           <div class="main-search-input-item">
                                               <input type="text"  value="" placeholder="Search">
                                       </div>
            </header>
            <section id="products-list">
                <h2>Products</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th><button id="addcat" onclick="window.location='newProduct.php';">Add Product</button><th>
                        </tr>
                    </thead>
                    <tbody>
                    <div class="dropdown">
                       
                    </tbody>
                </table>
            </section>
        </main>
    </div>
    <script src="productslist.js"></script>
</body>
</html>