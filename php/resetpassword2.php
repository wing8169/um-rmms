<?php
session_start();
include("config.php");

if (isset($_POST['psw'])) {
    if (!isset($_SESSION['tmp'])) {
        exit(json_encode(array(
            "status" => "fail",
            "msg" => "Sesison expired. Please click the confirmation link attached in email again, or send another password reset request."
        )));
    }
    $email = $_SESSION['tmp'];
    // get account based on email
    $stmt = $conn->prepare("SELECT * FROM user WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        echo json_encode(array(
            "status" => "fail",
            "msg" => "Error in finding your account."
        ));
    } else {
        // get id
        $row = $result->fetch_assoc();
        $id = $row['ID'];
        $stmt->close();
        // hash password
        $password = $_POST['psw'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // update password
        $stmt = $conn->prepare("UPDATE user SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashed_password, $id);
        $stmt->execute();
        $stmt->close();
        // return success message
        session_unset();
        echo json_encode(array(
            "status" => "success",
            "msg" => "Password has been resetted. Please log in again."
        ));
    }
} else {
    // send fail message
    echo json_encode(array(
        "status" => "fail",
        "msg" => "Invalid password."
    ));
}
