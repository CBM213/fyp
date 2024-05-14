<?php
header('Content-Type: application/json');

// Include your database connection file
include 'DBConnect.php';

// Assume you get the userID and productID as GET parameters for this example
$userID = filter_input(INPUT_GET, 'userID', FILTER_SANITIZE_NUMBER_INT);
$productID = filter_input(INPUT_GET, 'productID', FILTER_SANITIZE_NUMBER_INT);

// Check for valid input
if (!$userID || !$productID) {
    echo json_encode(["error" => "Invalid or missing userID or productID"]);
    exit;
}

// SQL query to remove an item from the cart
$sql = "DELETE FROM cart WHERE UserID = ? AND ProductID = ?";
$stmt = $con->prepare($sql);

if ($stmt === false) {
    // If there's an error in the query, log it and return an error message in JSON format
    $error_message = "Error preparing query: " . $con->errorInfo()[2];
    error_log($error_message);
    echo json_encode(["error" => $error_message]);
    exit;
}

// Bind parameters and execute the statement
$result = $stmt->execute([$userID, $productID]);

if ($result) {
    // If the item is successfully removed from the cart, return a success message
    echo json_encode(["message" => "Item removed from cart"]);
} else {
    // If there's an error in executing the statement, return an error message
    echo json_encode(["error" => "Error removing item from cart"]);
}

// Close the cursor to free up resources
$stmt->closeCursor();
?>
