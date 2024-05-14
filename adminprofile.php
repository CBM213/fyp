<?php
header('Content-type: application/json');
session_start();

// Check if the AdminID is present in the session
if (isset($_SESSION['AdminID']) && !empty($_SESSION['AdminID'])) {
    $AdminID = $_SESSION['AdminID'];

    try {
        require 'DBConnect.php'; // Make sure DBConnect.php has the correct PDO connection code

        // Prepared statement to fetch admin data without password
        $stmt = $con->prepare("SELECT AdminID, Email, FirstName, LastName FROM admins WHERE AdminID = :AdminID");
        $stmt->bindParam(':AdminID', $AdminID, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $adminData = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode([
                "status" => true,
                "message" => "Admin data retrieved successfully.",
                "data" => $adminData
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                "status" => false,
                "message" => "Admin not found."
            ]);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            "status" => false,
            "message" => "Database error: " . $e->getMessage()
        ]);
    }
} else {
    http_response_code(400);
    echo json_encode([
        "status" => false,
        "message" => "Missing AdminID in session."
    ]);
}
?>
