<?php
session_start();
include("../config.php");

if (isset($_POST['taskname2']) && isset($_POST['sdate2']) && isset($_POST['edate2']) && isset($_POST['percent2'])) {
    // check if information provided to update.
    $id = $_SESSION['role'] == "supervisor" ? $_SESSION["progressid"] : $_SESSION['id'];
    $stmt = $conn->prepare("UPDATE task SET task_name=?, start_date=?, end_date=?, percent=?, dependencies=?, user_id=? WHERE task_name=?");
    $stmt->bind_param("sssssss", $_POST['taskname2'], $_POST['sdate2'], $_POST['edate2'], $_POST['percent2'], $_POST['depend2'], $id, $_POST['taskname2']);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    echo json_encode(array(
        "status" => "success",
        "msg" => "Progress is updated.",
    ));
} else {
    echo json_encode(array(
        "status" => "fail",
        "msg" => "Progress not found.",
    ));
}


/////////////////how to validate
