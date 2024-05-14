<?php
header('Content-Type: application/json');
include 'DBConnect.php';

$sql = "SELECT CategoryID, CatName, Description, Quantity FROM category";
$stmt = $con->query($sql);

if ($stmt === false) {
    $error_message = "Error fetching data: " . $con->errorInfo()[2]; 
    error_log($error_message);
    echo json_encode(["error" => $error_message]);
    exit;
}

$categories = $stmt->fetchAll(PDO::FETCH_ASSOC); 

echo json_encode($categories);

$stmt->closeCursor();

?>