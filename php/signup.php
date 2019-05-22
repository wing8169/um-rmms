<?php
session_start();
include("config.php");
if (isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['psw']) && isset($_POST['role'])) {
    // check if user already exists.
    $stmt = $conn->prepare("SELECT COUNT(*) as 'num' FROM user WHERE email=?");
    $stmt->bind_param("s", $_POST['email']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $exist = $row['num'];
    if ($exist !== 0) {
        exit(json_encode(array(
            "status" => "fail",
            "msg" => "Account has already registered."
        )));
    }
    // hash password
    $pw = password_hash($_POST['psw'], PASSWORD_DEFAULT);
    // insert into database
    $stmt = $conn->prepare("INSERT INTO user (email, password, full_name, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $_POST['email'], $pw, $_POST['fullname'], $_POST['role']);
    $stmt->execute();
    $id = $stmt->insert_id;
    $stmt->close();
    // signed up, setup session
    $_SESSION['user'] = $_POST['email'];
    $_SESSION['fullname'] = $_POST['fullname'];
    $_SESSION['role'] = $_POST['role'];
    $_SESSION['id'] = $id;
    // send full name back
    echo json_encode(array(
        "status" => "success",
        "msg" => $_POST['fullname']
    ));
} else {
    // send fail message
    echo json_encode(array(
        "status" => "fail",
        "msg" => "Data is invalid."
    ));
}
