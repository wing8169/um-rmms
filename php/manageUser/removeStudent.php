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
    // check if email has been added
    $stmt = $conn->prepare("SELECT COUNT(*) FROM student WHERE user_id=? AND student_id IN (SELECT ID FROM user WHERE email=?)");
    $stmt->bind_param("is", $id, $_POST['email']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_all();
    if ($row[0][0] == 0) {
        exit(json_encode(array(
            "status" => "fail",
            "msg" => "Email has no yet been added.",
        )));
    }

    $stmt = $conn->prepare("SELECT ID from user WHERE email=?");
    $stmt->bind_param("s", $_POST['email']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $temp = $row['ID'];

    $stmt2 = $conn->prepare("DELETE FROM student WHERE student_id=?");
    $stmt2->bind_param("s", $temp);
    $stmt2->execute();

    $stmt->close();
    $conn->close();

    echo json_encode(array(
        "status" => "success",
        "msg" => "Student successfully removed.",
    ));
} else {
    echo json_encode(array(
        "status" => "fail",
        "msg" => "Fail to remove student.",
    ));
}
