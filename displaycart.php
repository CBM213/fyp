<?php
header('Content-Type: application/json');

// Include your database connection file
include 'DBConnect.php';

// Assume you get the userID as a GET parameter for this example
$userID = filter_input(INPUT_GET, 'userID', FILTER_SANITIZE_NUMBER_INT);

// Check for valid input
if (!$userID) {
    echo json_encode(["error" => "Invalid or missing userID"]);
    exit;
}

// SQL query to fetch cart items for a specific user
$sql = "SELECT 
            c.Quantity as cartQuantity, 
            p.ProductID, p.ProdName, p.Description, p.Price, p.Image, p.Rating, 
            cat.CatName 
        FROM cart AS c 
        JOIN product AS p ON c.ProductID = p.ProductID 
        JOIN category AS cat ON p.CategoryID = cat.CategoryID 
        WHERE c.UserID = ?";

$stmt = $con->prepare($sql);

if ($stmt === false) {
    // If there's an error in the query, log it and return an error message in JSON format
    $error_message = "Error preparing query: " . $con->errorInfo()[2];
    error_log($error_message);
    echo json_encode(["error" => $error_message]);
    exit;
}

// Execute the statement with the userID parameter
$stmt->execute([$userID]);

// Fetch all rows as an associative array
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($cartItems)) {
    // If no cart items are found for the user, return a message indicating the cart is empty
    echo json_encode(["message" => "Cart is empty"]);
    exit;
}

// Encode the cart items array as JSON and output it
echo json_encode(["cartItems" => $cartItems]);

// Close the cursor to free up resources
$stmt->closeCursor();
?>
