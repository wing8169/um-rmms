<?php
session_start();
include("../config.php");

date_default_timezone_set("Asia/Kuala_Lumpur");
if (isset($_POST['title']) && isset($_POST['deadlinedate']) && isset($_POST['comment'])) {
    // insert into database
    $stmt = $conn->prepare("INSERT INTO checklist (title, time, comment, user_id) VALUES (?, ?, ?, ?);");
    $stmt->bind_param("sssi", $_POST['title'], $_POST['deadlinedate'], $_POST['comment'], $_SESSION['id']);
    $stmt->execute();
    $stmt->close();
    // send success message
    echo json_encode(array(
        "status" => "success",
        "msg" => "success."
    ));
} else {
    // send fail message
    echo json_encode(array(
        "status" => "fail",
        "msg" => "Data is invalid."
    ));
}
