<?php

require 'DBConnect.php'; 

header('Content-Type: application/json');

try {
    $sql = "
        SELECT ProdName, sold, (sold * Price) AS revenue
        FROM product
        ORDER BY sold DESC, revenue DESC
        LIMIT 5
    ";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($products) {
        echo json_encode([
            'success' => true,
            'data' => $products
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'No products found'
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
}
?>
