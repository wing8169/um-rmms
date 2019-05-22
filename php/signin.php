<?php
session_start();
include("config.php");
if (isset($_POST['email']) && isset($_POST['password'])) {
    $pw = "";
    // get hashed password from database
    $stmt = $conn->prepare("SELECT * FROM user WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $_POST['email']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        echo json_encode(array(
            "status" => "fail",
            "msg" => "Invalid email or password."
        ));
    } else {
        $row = $result->fetch_assoc();
        $pw = $row['password'];
        $fullname = $row['full_name'];
        $role = $row['role'];
        $id = $row['ID'];
        $stmt->close();
        // verify password
        if (password_verify($_POST['password'], $pw)) {
            // set session
            $_SESSION["user"] = $_POST['email'];
            $_SESSION["fullname"] = $fullname;
            $_SESSION["role"] = $role;
            $_SESSION["id"] = $id;
            // reply success message
            echo json_encode(array(
                "status" => "success",
                "msg" => $_POST["email"],
            ));
        } else {
            echo json_encode(array(
                "status" => "fail",
                "msg" => "Invalid email or password."
            ));
        }
    }
} else {
    // send fail message
    echo json_encode(array(
        "status" => "fail",
        "msg" => "Invalid email or password."
    ));
}
