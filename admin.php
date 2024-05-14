<?php
session_start();

header('Content-type: application/json'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        require 'DBConnect.php';
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $con->prepare("SELECT AdminID, Password FROM admins WHERE Email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($password == $user_data['Password']) {
                $_SESSION['AdminID'] = $user_data['AdminID'];
                echo json_encode(['status' => true, 'redirect' => 'orderslist.php']);
                exit();
            } else {
                echo json_encode(['status' => false, 'message' => 'Invalid credentials.']);
                exit();
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'User not found.']);
            exit();
        }
    } else {
        echo json_encode(['status' => false, 'message' => 'Missing credentials.']);
        exit();
    }
} else {
    echo json_encode(['status' => false, 'message' => 'Bad request.']);
    exit();
}
?>
