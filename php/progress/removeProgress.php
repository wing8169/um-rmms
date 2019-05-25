<?php
session_start();
include("../config.php");

if (isset($_POST['taskname2'])) {
    $id = $_SESSION['role'] == "supervisor" ? $_SESSION["progressid"] : $_SESSION['id'];
    // check if dependencies exist
    $stmt = $conn->prepare("SELECT COUNT(*) as tmp FROM task WHERE user_id = ? AND dependencies LIKE ?");
    $tmp = "%" . $_POST['taskname2'] . "%";
    $stmt->bind_param("is", $id, $tmp);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if ($row['tmp'] != 0) {
        $stmt->close();
        $conn->close();
        exit(json_encode(array(
            "status" => "fail",
            "msg" => "Dependency conflicts occur. Please remove all dependencies on this task before removal.",
        )));
    }
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
