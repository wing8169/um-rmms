<?php
session_start();
include("../config.php");

if (isset($_POST['email'])) {
    $id = $_SESSION['id'];
    // check if email exist database
    $stmt = $conn->prepare("SELECT COUNT(*) FROM user WHERE email=?");
    $stmt->bind_param("s", $_POST['email']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_all();
    if ($row[0][0] == 0) {
        exit(json_encode(array(
            "status" => "fail",
            "msg" => "Email is not in database.",
        )));
    }
    // check if email is added already
    $stmt = $conn->prepare("SELECT COUNT(*) FROM student WHERE user_id=? AND student_id IN (SELECT ID FROM user WHERE email=?)");
    $stmt->bind_param("is", $id, $_POST['email']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_all();
    if ($row[0][0] != 0) {
        exit(json_encode(array(
            "status" => "fail",
            "msg" => "The email has already been added.",
        )));
    }
    // add new record to database
    $stmt = $conn->prepare("INSERT INTO student (student_id, user_id) SELECT user.ID , ? FROM user WHERE user.email = ?");
    $stmt->bind_param("ss", $id, $_POST['email']);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    echo json_encode(array(
        "status" => "success",
        "msg" => "Student successfully added.",
    ));
} else {
    echo json_encode(array(
        "status" => "fail",
        "msg" => "Fail to add student.",
    ));
}
