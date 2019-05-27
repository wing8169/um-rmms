<?php
session_start();
session_unset();
include("../config.php");

if (isset($_GET['email']) && isset($_GET['id'])) {
    $hashed_email = htmlspecialchars($_GET["email"]);
    $hashed_id = htmlspecialchars($_GET["id"]);
    // get original email string
    $ori_email = "";
    $stmt = $conn->prepare("SELECT email FROM user");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $current_email = $row['email'];
        $verified = password_verify($current_email, $hashed_email);
        if ($verified) {
            $ori_email = $current_email;
            break;
        }
    }
    $stmt->close();
    if ($ori_email == "") {
        exit(json_encode(array(
            "status" => "fail",
            "msg" => "Invalid address."
        )));
    }
    // get original meeting id string
    $ori_id = "";
    $stmt = $conn->prepare("SELECT ID FROM meeting");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $current_id = $row['ID'];
        $verified = password_verify($current_id, $hashed_id);
        if ($verified) {
            $ori_id = $current_id;
            break;
        }
    }
    $stmt->close();
    if ($ori_id == "") {
        exit(json_encode(array(
            "status" => "fail",
            "msg" => "Invalid address."
        )));
    }
    // find the user id
    $stmt = $conn->prepare("SELECT ID FROM user WHERE email=?");
    $stmt->bind_param("s", $ori_email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $tmp_id = $row['ID'];
    // find if the user id is already in the meeting.
    $stmt = $conn->prepare("SELECT COUNT(*) as tmp FROM guest WHERE user_id=? AND meeting_id=?");
    $stmt->bind_param("ii", $tmp_id, $ori_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $tmp = $row['tmp'];
    if ($tmp != 0) {
        exit("<script type='text/javascript'>alert('You are already in the meeting. You will be redirected to the home page now.'); location.href = '/';</script>");
    }
    // insert the user id
    $stmt = $conn->prepare("INSERT INTO guest(user_id, meeting_id) VALUES (?, ?);");
    $stmt->bind_param("ii", $tmp_id, $ori_id);
    $stmt->execute();
    $stmt->close();
    // alert user
    echo "<script type='text/javascript'>alert('Successfully joined the meeting! You will be redirected to the home page now.'); location.href = '/';</script>";
} else {
    // send fail message
    echo json_encode(array(
        "status" => "fail",
        "msg" => "Invalid address."
    ));
}
