<?php
header('Content-Type: application/json');
include 'DBConnect.php';

$sql = "SELECT u.UserID, u.Username, u.AddressID, a.* 
FROM user u
INNER JOIN Address a on u.AddressID=a.AddressID";
$stmt = $con->query($sql);
if ($stmt === false) {
    $error_message = "Error fetching data: " . $con->errorInfo()[2]; 
    error_log($error_message);
    echo json_encode(["error" => $error_message]);
    exit;
}

$customers = $stmt->fetchAll(PDO::FETCH_ASSOC); 

echo json_encode($customers);

$stmt->closeCursor();

?>