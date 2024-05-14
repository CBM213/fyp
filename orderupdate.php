<?php
session_start();
include 'DBConnect.php';

// Check for a valid admin session
if (!isset($_SESSION['AdminID'])) {
    // Return an error in JSON format
    echo json_encode(['error' => 'Unauthorized access.']);
    exit;
}

// Make sure we have the necessary POST data
if (isset($_POST['order_id']) && isset($_POST['status'])) {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['status'];

    // Validate and sanitize inputs
    $orderId = filter_var($orderId, FILTER_SANITIZE_NUMBER_INT);
    $newStatus = filter_var($newStatus, FILTER_SANITIZE_STRING);

    // Prepare the SQL statement to avoid SQL injection
    $stmt = $con->prepare("UPDATE orders SET Status = :status WHERE OrderID = :orderId");

    // Bind the parameters to the statement
    $stmt->bindParam(':status', $newStatus, PDO::PARAM_STR);
    $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);

    // Execute the statement and check if it was successful
    if ($stmt->execute()) {
        // Return a success message in JSON format
        echo json_encode(['message' => 'Order status updated successfully.']);
    } else {
        // Return an error message in JSON format
        $errorInfo = $stmt->errorInfo();
        echo json_encode(['error' => "Error updating order: " . $errorInfo[2]]);
    }
} else {
    // Return an error message in JSON format
    echo json_encode(['error' => 'Order ID or status not provided.']);
}

// Close the statement and the connection if necessary
if (isset($stmt)) {
    $stmt = null;
}
$con = null;
?>
