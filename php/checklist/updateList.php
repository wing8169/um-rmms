<?php
session_start();
include("../config.php");

date_default_timezone_set("Asia/Kuala_Lumpur");
if (isset($_POST['deadline']) && isset($_POST['comment']) && isset($_POST['id'])) {
    // update database
    $stmt = $conn->prepare("UPDATE checklist SET comment = ?, time = ? WHERE ID = ?;");
    $stmt->bind_param("ssi", $_POST['comment'], $_POST['deadline'], $_POST['id']);
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
