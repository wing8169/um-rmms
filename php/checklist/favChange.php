<?php
session_start();
include("../config.php");
if (isset($_POST['favourite']) && isset($_POST['id'])) {
    // update database
    $stmt = $conn->prepare("UPDATE checklist SET favourite = ? WHERE ID=?;");
    $stmt->bind_param("ii", $_POST['favourite'], $_POST['id']);
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
