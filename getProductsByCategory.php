<?php
header('Content-Type: application/json');

// Include the database connection file
include 'DBConnect.php';

// Retrieve the category ID from the query parameter
$categoryId = isset($_GET['CategoryID']) ? $_GET['CategoryID'] : '';

// Check if the category ID is provided
if(empty($categoryId)) {
    echo json_encode(array('success' => false, 'message' => 'Category ID is required'));
    exit;
}

try {
    // Prepare the SQL statement to fetch products by category ID
    $sql = "SELECT ProductID, ProdName, Description, Price, Quantity, Image, Rating FROM product WHERE CategoryID = ?";
    $stmt = $con->prepare($sql);
    
    // Bind the category ID to the prepared statement
    $stmt->bindParam(1, $categoryId, PDO::PARAM_INT);
    
    // Execute the statement
    $stmt->execute();
    
    // Fetch all products for the category
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Check if products are found
    if ($products) {
        // Encode the products array as JSON and output it
        echo json_encode(array('success' => true, 'products' => $products));
    } else {
        // No products found for the category
        echo json_encode(array('success' => false, 'message' => 'No products found for this category'));
    }
} catch (PDOException $e) {
    // If there's an error in the query, log it and return an error message in JSON format
    $error_message = "Error fetching data: " . $e->getMessage();
    error_log($error_message);
    echo json_encode(array('success' => false, 'message' => $error_message));
}

// Close the cursor and the database connection if necessary
if (isset($stmt)) {
    $stmt->closeCursor();
}

// Close the database connection if necessary
if (isset($con)) {
    $con = null;
}
?>
