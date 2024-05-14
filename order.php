<?php
header('Content-Type: application/json');

require 'DBConnect.php';  // Make sure this file contains the correct database connection setup.

// Sanitize and validate the POST data
$userID = filter_input(INPUT_POST, 'userID', FILTER_SANITIZE_NUMBER_INT);
$paymentMethod = filter_input(INPUT_POST, 'paymentMethod', FILTER_SANITIZE_STRING);
$amount = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
$street = filter_input(INPUT_POST, 'street', FILTER_SANITIZE_STRING);
$building = filter_input(INPUT_POST, 'building', FILTER_SANITIZE_STRING);
$floor = filter_input(INPUT_POST, 'floor', FILTER_SANITIZE_STRING);
$apartment = filter_input(INPUT_POST, 'apartment', FILTER_SANITIZE_STRING);
$deliveryDate = filter_input(INPUT_POST, 'deliveryDate', FILTER_SANITIZE_STRING);
$deliveryTime = filter_input(INPUT_POST, 'deliveryTime', FILTER_SANITIZE_STRING);

// Convert comma-separated strings to arrays
$productIDs = isset($_POST['productIDs']) ? explode(',', $_POST['productIDs']) : [];
$quantities = isset($_POST['quantities']) ? explode(',', $_POST['quantities']) : [];

// Check for valid input including the new delivery date and time
if (!$userID || !$paymentMethod || !$amount || !$city || !$street || !$building || !$floor || !$apartment || empty($productIDs) || empty($quantities) || !$deliveryDate || !$deliveryTime) {
    echo json_encode(["error" => "Invalid input provided"]);
    exit;
}

try {
    $con->beginTransaction();

    // Insert the address
    $addressSql = "INSERT INTO address (City, Street, Building, Floor, Apartment) VALUES (?, ?, ?, ?, ?)";
    $stmt = $con->prepare($addressSql);
    $stmt->execute([$city, $street, $building, $floor, $apartment]);
    $addressID = $con->lastInsertId();

    // Insert the order with delivery date and time
    $orderSql = "INSERT INTO orders (UserID, AddressID, Status, PaymentMethod, Amount, DeliveryDate, DeliveryTime) VALUES (?, ?, 'PENDING', ?, ?, ?, ?)";
    $stmt = $con->prepare($orderSql);
    $stmt->execute([$userID, $addressID, $paymentMethod, $amount, $deliveryDate, $deliveryTime]);
    $orderID = $con->lastInsertId();

    // Prepare the statement to retrieve the product price
    $stmtPrice = $con->prepare("SELECT Price FROM product WHERE ProductID = ?");
    
    // Insert each order item along with the price
    $orderItemSql = "INSERT INTO orderitem (OrderID, ProductID, Quantity, Price) VALUES (?, ?, ?, ?)";
    $stmtOrderItem = $con->prepare($orderItemSql);
    
    foreach ($productIDs as $index => $productID) {
        // Retrieve the product's price
        $stmtPrice->execute([$productID]);
        $product = $stmtPrice->fetch(PDO::FETCH_ASSOC);
        if (!$product) {
            throw new Exception("Product ID $productID not found.");
        }
        
        // Execute the statement to insert order items
        $stmtOrderItem->execute([$orderID, $productID, $quantities[$index], $product['Price']]);
    }
        $emptyCartSql = "DELETE FROM cart WHERE UserID = ?";
        $stmtEmptyCart = $con->prepare($emptyCartSql);
        $stmtEmptyCart->execute([$userID]);
    $con->commit();
    echo json_encode(["success" => "Order and address information saved successfully"]);
    
} catch (PDOException $e) {
    $con->rollBack();
    echo json_encode(["error" => "An error occurred while placing the order: " . $e->getMessage()]);
} catch (Exception $e) {
    $con->rollBack();
    echo json_encode(["error" => "An error occurred: " . $e->getMessage()]);
}

?>
