<?php
header('Content-type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = $_POST['email'];
        // Storing password without hashing (not recommended for real applications)
        $password = $_POST['password'];
        try {
            require 'DBConnect.php';
            // Checking if the email already exists
            $CHECK_EMAIL_EXISTS = "SELECT * FROM `user` WHERE Email=:email";
            $check_email_stmt = $con->prepare($CHECK_EMAIL_EXISTS);
            $check_email_stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $check_email_stmt->execute();
            if ($check_email_stmt->rowCount() > 0) {
                // Email already exists
                http_response_code(409); // Conflict
                $response_error = array(
                    "code" => http_response_code(409),
                    "status" => false,
                    "message" => "Email already exists!"
                );
                echo json_encode($response_error);
            } else {
                // Email does not exist, proceed with registration
                $INSERT_USER_DATA = "INSERT INTO `user` (Email, Password) VALUES (:email, :password)";
                $insert_user_stmt = $con->prepare($INSERT_USER_DATA);
                $insert_user_stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $insert_user_stmt->bindParam(':password', $password, PDO::PARAM_STR);
                if ($insert_user_stmt->execute()) {
                    // User successfully registered
                    http_response_code(201); // Created
                    $response_success = array(
                        "code" => http_response_code(201),
                        "status" => true,
                        "message" => "User successfully registered."
                    );
                    echo json_encode($response_success);
                } else {
                    // Failed to register user
                    http_response_code(500); // Internal Server Error
                    $response_error = array(
                        "code" => http_response_code(500),
                        "status" => false,
                        "message" => "Failed to register user."
                    );
                    echo json_encode($response_error);
                }
            }
        } catch (Exception $ex) {
            http_response_code(500); // Internal Server Error
            $response_error = array(
                "code" => http_response_code(500),
                "status" => false,
                "message" => "An error occurred: " . $ex->getMessage()
            );
            echo json_encode($response_error);
        }
    } else {
        http_response_code(400); // Bad Request
        $response_error = array(
            "code" => http_response_code(400),
            "status" => false,
            "message" => "Invalid API parameters! Please check the documentation."
        );
        echo json_encode($response_error);
    }
} else {
    http_response_code(405); // Method Not Allowed
    $response_error = array(
        "code" => http_response_code(405),
        "status" => false,
        "message" => "Invalid request method. This endpoint accepts POST requests only."
    );
    echo json_encode($response_error);
}
?>
