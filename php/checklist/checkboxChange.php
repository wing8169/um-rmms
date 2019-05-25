<?php
session_start();
include("../config.php");
if (isset($_POST['checked']) && isset($_POST['id'])) {
    // update database
    $stmt = $conn->prepare("UPDATE checklist SET checked = ? WHERE ID=?;");
    $stmt->bind_param("ii", $_POST['checked'], $_POST['id']);
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
