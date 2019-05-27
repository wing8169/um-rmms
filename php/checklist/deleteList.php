<?php
session_start();
include("../config.php");

if (isset($_POST['id'])) {
    // delete database
    $stmt = $conn->prepare("DELETE FROM checklist WHERE ID = ?;");
    $stmt->bind_param("i", $_POST['id']);
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
