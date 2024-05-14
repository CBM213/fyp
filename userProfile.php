<?php
header('Content-Type: application/json');

// Check if the HTTP request is a GET request
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode([
        "code" => 405,
        "status" => false,
        "message" => "Invalid request method. Please use GET."
    ]);
    exit;
}

if (empty($_GET['userID']) || !filter_var($_GET['userID'], FILTER_VALIDATE_INT)) {
    http_response_code(400);
    echo json_encode([
        "code" => 400,
        "status" => false,
        "message" => "Invalid or missing userID parameter. userID must be an integer."
    ]);
    exit;
}

$userID = $_GET['userID'];

try {
    require 'DBConnect.php'; // Database connection file

    // SQL to fetch user data
    $SELECT_USER_DATA = "SELECT UserID, Email, FirstName, LastName FROM user WHERE UserID = :userID";
    $stmt = $con->prepare($SELECT_USER_DATA);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return successful response with user data
        echo json_encode([
            "code" => 200,
            "status" => true,
            "message" => "User Profile Retrieved Successfully",
            "userData" => $user_data
        ]);
    } else {
        // User not found
        http_response_code(404);
        echo json_encode([
            "code" => 404,
            "status" => false,
            "message" => "User not found"
        ]);
    }
} catch (PDOException $e) {
    // Handle PDO specific exception if database connection failed
    http_response_code(500);
    echo json_encode([
        "code" => 500,
        "status" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);
} catch (Exception $ex) {
    // Handle general exceptions
    http_response_code(500);
    echo json_encode([
        "code" => 500,
        "status" => false,
        "message" => "Server error: " . $ex->getMessage()
    ]);
} finally {
    // Optional: Close the database connection
    $con = null;
}
?>