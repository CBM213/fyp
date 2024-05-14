<?php
header('Content-Type: application/json');

// Include your database connection file
include 'DBConnect.php';

// Function to log messages to the PHP error log
function customLog($message) {
    error_log(date('[Y-m-d H:i:s] ') . $message);
}

// Function to update the product price by reducing it by 10%
function applyDiscount($pdo, $productID, $originalPrice) {
    $discountedPrice = $originalPrice * 0.9; // Apply 10% discount
    $sql = "UPDATE product SET Price = ?, DiscountApplied = 1, LastDiscountApplied = NOW() WHERE ProductID = ?";
    $stmt = $pdo->prepare($sql);
    $success = $stmt->execute([$discountedPrice, $productID]);
    if ($success) {
        customLog("Applied discount to product ID: {$productID}");
    } else {
        customLog("Failed to apply discount to product ID: {$productID}");
    }
    return $success;
}

// Get the current month
$currentMonth = date('n');

// Determine the category ID based on the current month
$categoryID = (12/ $currentMonth) + 1; // Cycles through 1, 2, and 3

try {
    // Begin transaction
    $con->beginTransaction();
    customLog("Transaction started");

    // Select products in the determined category that haven't been discounted this month
    $stmt = $con->prepare("SELECT ProductID, Price FROM product WHERE CategoryID = ? AND (LastDiscountApplied IS NULL OR MONTH(LastDiscountApplied) != ?)");
    $stmt->execute([$categoryID, $currentMonth]);
    $productsToDiscount = $stmt->fetchAll(PDO::FETCH_ASSOC);
    customLog("Selected products to apply discounts for category ID: {$categoryID}");

    // Iterate over each product and apply the discount
    foreach ($productsToDiscount as $product) {
        applyDiscount($con, $product['ProductID'], $product['Price']);
    }

    // Commit transaction
    $con->commit();
    customLog("Transaction committed");

    // Select and display current deals with updated prices
    $stmt = $con->prepare("SELECT p.ProductID, p.ProdName, p.Description, p.Price, p.Quantity, p.Image, p.Rating
                            FROM product AS p
                            WHERE p.CategoryID = ?");
    $stmt->execute([$categoryID]);
    $currentDeals = $stmt->fetchAll(PDO::FETCH_ASSOC);
    customLog("Fetched current deals with updated prices");

    echo json_encode(['success' => true, 'deals' => $currentDeals]);

} catch (Exception $e) {
    // Rollback the transaction if something fails
    $con->rollBack();
    customLog("Transaction rolled back due to exception: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

// Close connection
$con = null;
customLog("Database connection closed");
?>
