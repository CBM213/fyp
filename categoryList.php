<?php
header('Content-Type: application/json');
include 'DBConnect.php';

// Get the list of categories from the database
$sql = "SELECT CategoryID, CatName FROM category ORDER BY CatName ASC";
$stmt = $con->prepare($sql);
$stmt->execute();

$categories = array();

// Fetch all categories
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // Each category will have a 'name' and an 'id'
    $categories[] = array('id' => $row['CategoryID'], 'name' => $row['CatName']);
}

// Check if categories are found
if ($categories) {
    echo json_encode(array('success' => true, 'categories' => $categories));
} else {
    echo json_encode(array('success' => false, 'message' => 'No categories found'));
}

$stmt->closeCursor();
?>
