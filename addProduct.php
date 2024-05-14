<?php
session_start();
include 'DBConnect.php';

header('Content-Type: application/json'); 

if (!isset($_SESSION['AdminID'])) {
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prodName = $_POST['ProdName'];
    $categoryName = $_POST['CatName']; 
    $price = $_POST['Price'];
    $quantity = $_POST['Quantity'];

    $stmt = $con->prepare("SELECT CategoryID FROM category WHERE CatName = :CatName");
    $stmt->bindParam(':CatName', $categoryName);
    $stmt->execute();
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$category) {
        echo json_encode(['error' => 'Category not found']);
        exit;
    }

    $categoryID = $category['CategoryID']; 

    $stmt = $con->prepare("INSERT INTO product (ProdName, CategoryID, Price, Quantity) VALUES (:ProdName, :CategoryID, :Price, :Quantity)");

    $stmt->bindParam(':ProdName', $prodName);
    $stmt->bindParam(':CategoryID', $categoryID); 
    $stmt->bindParam(':Price', $price);
    $stmt->bindParam(':Quantity', $quantity);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Product added successfully']);
    } else {
        $errorInfo = $stmt->errorInfo();
        echo json_encode(['error' => 'Error adding product: ' . $errorInfo[2]]);
    }

    $stmt = null; 
} else {
    echo json_encode(['error' => 'Invalid request method']);
}

$con = null; 
?>
