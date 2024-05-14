<?php
header('Content-Type: application/json');
include 'DBConnect.php';

// Check if the request is to update an order
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orderId = $_POST['order_id'];
    $status = $_POST['status'];

    $updateStmt = $con->prepare("UPDATE orders SET Status = :status WHERE OrderID = :orderId");
    $updateStmt->execute(['status' => $status, 'orderId' => $orderId]);

    if ($updateStmt->rowCount() > 0) {
        echo json_encode(["message" => "Order updated successfully"]);
    } else {
        echo json_encode(["error" => "Error updating order"]);
    }
    exit;
}

// The request is to fetch orders
$sql = "SELECT o.OrderID, o.Status, o.Amount, u.Username FROM orders o
JOIN user u on o.UserID=u.UserID";
$stmt = $con->query($sql);

if ($stmt === false) {
    $error_message = "Error fetching data: " . $con->errorInfo()[2];
    error_log($error_message);
    echo json_encode(["error" => $error_message]);
    exit;
}

$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($orders);
?>
