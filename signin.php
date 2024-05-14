<?php
header('Content-type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        try {
            require 'DBConnect.php';
            // Query to check for valid user details
            $SELECT_USER_DATA = "SELECT * FROM user WHERE Email = :email";
            $select_user_statement = $con->prepare($SELECT_USER_DATA);
            $select_user_statement->bindParam(':email', $email, PDO::PARAM_STR);
            $select_user_statement->execute();
            
            if ($select_user_statement->rowCount() > 0) {
                $user_data = $select_user_statement->fetch(PDO::FETCH_ASSOC);
                if ($password == $user_data['Password']) {
                    $user_object = array(
                        "userID" => $user_data['UserID'],
                        "email" => $user_data['Email']
                    );
                    http_response_code(200);
                    $server_response_success = array(
                        "code" => http_response_code(200),
                        "status" => true,
                        "message" => "User Verified",
                        "userData" => $user_object
                    );
                    echo json_encode($server_response_success);
                } else {
                    // Incorrect password
                    http_response_code(401); // More appropriate status code for unauthorized access
                    $server_response_error = array(
                        "code" => http_response_code(401),
                        "status" => false,
                        "message" => "Incorrect Login Credentials"
                    );
                    echo json_encode($server_response_error);
                }
            } else {
                // User not found
                http_response_code(404);
                $server_response_error = array(
                    "code" => http_response_code(404),
                    "status" => false,
                    "message" => "User Not Found"
                );
                echo json_encode($server_response_error);
            }
        } catch (Exception $ex) {
            // Server error
            http_response_code(500);
            $server_response_error = array(
                "code" => http_response_code(500),
                "status" => false,
                "message" => "Something Went Wrong! " . $ex->getMessage()
            );
            echo json_encode($server_response_error);
        }
    } else {
        // Invalid API parameters
        http_response_code(400);
        $server_response_error = array(
            "code" => http_response_code(400),
            "status" => false,
            "message" => "Invalid API Parameters"
        );
        echo json_encode($server_response_error);
    }
} else {
    // Bad request
    http_response_code(400);
    $server_response_error = array(
        "code" => http_response_code(400),
        "status" => false,
        "message" => "Bad Request"
    );
    echo json_encode($server_response_error);
}
?>