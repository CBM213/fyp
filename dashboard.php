<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashborad</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/sidebar.css">
</head>
<body>
<div id="container">
    <aside id="sidebar">
    <!-- QuickBuy Logo and Name -->
    <div class="sidebar-item">
        <img src="images/quickbuy logo.png" class="sidebar-icon logo-icon" />
        <div class="sidebar-label">QuickBuy</div>
    </div>
    <br><br>
    <button class="sidebar-item" onclick="location.href='dashboard.php'" id="dash">
        <img src="images/icon_home.png" class="sidebar-icon" />
        <span class="sidebar-label">Dashboard</span>
    </button>
    <br><br>
    <button class="sidebar-item" onclick="location.href='Customers.php'"> 
        <img src="images/customers.png" class="sidebar-icon" />
        <span class="sidebar-label">Customers</span>
    </button>
    <br><br>
    <button class="sidebar-item" onclick="location.href='productslist.php'">
        <img src="images/icon_bookmark.png" class="sidebar-icon" />
        <span class="sidebar-label">Products</span>
    </button>
    <br><br>
    <button class="sidebar-item" onclick="location.href='categorieslist.php'"> 
        <img src="images/icon_category.png" class="sidebar-icon" />
        <span class="sidebar-label">Categories</span>
    </button>
    <br><br>
    <button class="sidebar-item" onclick="location.href='orderslist.php'">
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
    </button>
</aside>
<div class="content">
        <div class="header">
            <h1>Product Sales Dashboard</h1>
        </div>
        <div style="width:60%; margin:auto;">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="dashboard.js"></script>
</body>
</html>