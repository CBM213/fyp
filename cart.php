<?php
header('Content-Type: application/json');

// Sanitize and validate the POST data
$userID = filter_input(INPUT_POST, 'userID', FILTER_SANITIZE_NUMBER_INT);
$productID = filter_input(INPUT_POST, 'productID', FILTER_SANITIZE_NUMBER_INT);
$quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);

// Check for valid input
if ($userID === null || $productID === null || $quantity === null || $userID === false || $productID === false || $quantity === false) {
    // Invalid input
    echo json_encode(["error" => "Invalid product ID, quantity, or userID"]);
    exit;
}

// Database connection file
require 'DBConnect.php';

// Check if the user exists
$userExists = $con->prepare("SELECT 1 FROM user WHERE UserID = ?");
$userExists->execute([$userID]);
if ($userExists->fetchColumn() == false) {
    echo json_encode(["error" => "User does not exist"]);
    exit;
}

// Check if the product exists
$productExists = $con->prepare("SELECT 1 FROM product WHERE ProductID = ?");
$productExists->execute([$productID]);
if ($productExists->fetchColumn() == false) {
    echo json_encode(["error" => "Product does not exist"]);
    exit;
}

// SQL query
$sql = "INSERT INTO cart (UserID, ProductID, Quantity) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE Quantity = Quantity + VALUES(Quantity)";

// Prepare statement
$stmt = $con->prepare($sql);

try {
    // Execute statement
    $stmt->execute([$userID, $productID, $quantity]);
    
    // Check if the statement was successful
    if ($stmt->rowCount() > 0) {
        // Success
        echo json_encode(["success" => "Product added to cart"]);
    } else {
        // No rows affected
        echo json_encode(["error" => "No changes made to the cart. Item may already be at the desired quantity or does not exist."]);
    }
} catch (PDOException $e) {
    // Log the error
    error_log("SQL Error: " . $e->getMessage());

    // Constraint violation check
    if ($e->getCode() == 23000) {
        // Determine specific constraint violation
        $errorInfo = $e->errorInfo[2];
        if (strpos($errorInfo, 'fk_user') !== false) {
            echo json_encode(["error" => "Constraint violation: The specified user does not exist."]);
        } elseif (strpos($errorInfo, 'fk_product') !== false) {
            echo json_encode(["error" => "Constraint violation: The specified product does not exist."]);
        } else {
            echo json_encode(["error" => "Unknown constraint violation. Please ensure the user and product exist and are correct."]);
        }
    } else {
        // Generic error message
        echo json_encode(["error" => "An error occurred while updating the cart: " . $e->getMessage()]);
    }
}
?>
