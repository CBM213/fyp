<?php
header('Content-Type: application/json');

include 'DBConnect.php'; // Ensure your database connection details are correct.

$currentDate = date('Y-m-d');

// SQL query to select data, including conditional pricing based on deals
$sql = "SELECT p.ProductID, p.ProdName, p.Description, p.Price as OriginalPrice, p.Quantity, p.Image, p.Rating, c.CatName,
               CASE
                   WHEN :currentDate BETWEEN d.FromDate AND d.ToDate THEN p.Price*0.9
                   ELSE p.Price
               END AS DiscountedPrice
        FROM product AS p
        JOIN category AS c ON p.CategoryID = c.CategoryID
        LEFT JOIN deals AS d ON p.ProductID = d.ProductID";

$stmt = $con->prepare($sql);
$stmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
$stmt->execute();

if ($stmt->execute() === false) {
    $error_message = "Error fetching data: " . $con->errorInfo()[2];
    error_log($error_message);
    echo json_encode(["error" => $error_message]);
    exit;
}

// Fetch all rows as an associative array
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Iterate over each product to update the price in the product table
foreach ($products as $product) {
    $productId = $product['ProductID'];
    $discountedPrice = $product['DiscountedPrice'];

    // Update the price in the product table
    $updateSql = "UPDATE product SET Price = :discountedPrice WHERE ProductID = :productId";
    $updateStmt = $con->prepare($updateSql);
    $updateStmt->bindParam(':discountedPrice', $discountedPrice);
    $updateStmt->bindParam(':productId', $productId);
    $updateStmt->execute();
}

echo json_encode($products);
$stmt->closeCursor();
?>
