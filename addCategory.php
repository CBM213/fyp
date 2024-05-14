<?php
session_start();
include 'DBConnect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['AdminID'])) {
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $catName = $_POST['CatName'];
    $description = $_POST['Description']; 
    $quantity = $_POST['Quantity']; 

    $stmt = $con->prepare("INSERT INTO category (CatName, Description, Quantity) VALUES (:CatName, :Description, :Quantity)");
    
    $stmt->bindParam(':CatName', $catName);
    $stmt->bindParam(':Description', $description);
    $stmt->bindParam(':Quantity', $quantity);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Category added successfully']);
    } else {
        $errorInfo = $stmt->errorInfo();
        echo json_encode(['error' => 'Error adding category: ' . $errorInfo[2]]);
    }

    $stmt = null;
} else {
    echo json_encode(['error' => 'Invalid request method']);
}

$con = null;
?>
