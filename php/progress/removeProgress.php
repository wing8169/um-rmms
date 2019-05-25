<?php
session_start();
include("../config.php");

if (isset($_POST['taskname2'])) {
    $id = $_SESSION['role'] == "supervisor" ? $_SESSION["progressid"] : $_SESSION['id'];
    $stmt = $conn->prepare("DELETE FROM task WHERE task_name=? AND user_id=?");
    $stmt->bind_param("ss", $_POST['taskname2'], $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    echo json_encode(array(
        "status" => "success",
        "msg" => "Progress is deleted.",
    ));
} else {
    echo json_encode(array(
        "status" => "fail",
        "msg" => "Progress not found.",
    ));
}
