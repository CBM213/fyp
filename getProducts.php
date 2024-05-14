<?php
header('Content-Type: application/json');

include 'DBConnect.php'; // Ensure your database connection details are correct.

$currentDate = date('Y-m-d');

// SQL query to select data, including conditional pricing based on deals
$sql = "SELECT p.ProductID, p.ProdName, p.Description, p.Price as OriginalPrice, p.Quantity, p.Image, p.Rating, c.CatName,
               CASE
                   WHEN :currentDate BETWEEN d.FromDate AND d.ToDate AND p.DiscountApplied = FALSE THEN p.Price * 0.9
                   ELSE p.Price
               END AS DiscountedPrice,
               CASE
                   WHEN :currentDate > d.ToDate AND p.DiscountApplied = TRUE THEN TRUE
                   ELSE FALSE
               END AS DiscountExpired
        FROM product AS p
        JOIN category AS c ON p.CategoryID = c.CategoryID
        LEFT JOIN deals AS d ON p.ProductID = d.ProductID";

$stmt = $con->prepare($sql);
$stmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);

// Execute the query
if (!$stmt->execute()) {
    $error_message = "Error fetching data: " . $con->errorInfo()[2];
    error_log($error_message);
    echo json_encode(["error" => $error_message]);
    exit;
}

// Fetch all rows as an associative array
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output fetched data for debugging purposes
echo json_encode(["data" => $products]);

foreach ($products as $product) {
    $productId = $product['ProductID'];
    $discountedPrice = $product['DiscountedPrice'];
    $discountExpired = $product['DiscountExpired'];

    if ($discountExpired) {
        // Reset DiscountApplied to FALSE if the discount has expired and set price back to original
        $updateSql = "UPDATE product SET Price = OriginalPrice, DiscountApplied = FALSE WHERE ProductID = :productId";
    } else {
        // Apply the discounted price and set DiscountApplied to TRUE
        $updateSql = "UPDATE product SET Price = :discountedPrice, DiscountApplied = TRUE WHERE ProductID = :productId";
    }

    $updateStmt = $con->prepare($updateSql);
    $updateStmt->bindParam(':discountedPrice', $discountedPrice, PDO::PARAM_STR);
    $updateStmt->bindParam(':productId', $productId, PDO::PARAM_INT);
    $updateStmt->execute();
}

$stmt->closeCursor();
?>
