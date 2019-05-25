<?php
session_start();
include("../config.php");

if (isset($_POST['taskname']) && isset($_POST['sdate']) && isset($_POST['edate']) && isset($_POST['percent'])) {
    // check if progress already exists.
    $id = $_SESSION['role'] == "supervisor" ? $_SESSION["progressid"] : $_SESSION['id'];
    $stmt = $conn->prepare("SELECT task_name FROM task WHERE user_id=?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_all();
    foreach ($row as $name) {
        if ($name[0] == ($_POST['taskname'])) {
            echo json_encode(array(
                "status" => "fail",
                "msg" => "Progress already exists.",
            ));
            exit();
        }
    }
    $stmt = $conn->prepare("INSERT INTO task (task_name, start_date, end_date, percent, dependencies, user_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $_POST['taskname'], $_POST['sdate'], $_POST['edate'], $_POST['percent'], $_POST['depend'], $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    echo json_encode(array(
        "status" => "success",
        "msg" => "Progress insert successfully.",
    ));
}
