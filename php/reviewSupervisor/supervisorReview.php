<?php
session_start();
include("../config.php");

if (isset($_POST['reportID']) && isset($_POST['setstatus']) && isset($_FILES['fileSubmit']) && isset($_POST['reason'])) {
    // move the report into project folder
    $target_dir = "../../reviews/";
    $file_name = basename($_FILES["fileSubmit"]["name"]);
    $extension_name = substr($file_name, strpos($file_name, "."));
    $target_file = $target_dir . $_POST['reportID'] . $extension_name;
    move_uploaded_file($_FILES["fileSubmit"]["tmp_name"], $target_file);
    // update review_path in database
    $stmt = $conn->prepare("UPDATE report SET review_path = ? WHERE id = ?");
    $target_file_modified = substr($target_file, 6);
    $stmt->bind_param("si", $target_file_modified, $_POST['reportID']);
    $stmt->execute();
    $stmt->close();
    // update status, review in database
    $stmt = $conn->prepare("UPDATE report SET status = ?, review = ? WHERE id = ?");
    $stmt->bind_param("ssi", $_POST['setstatus'], $_POST['reason'], $_POST['reportID']);
    $stmt->execute();
    $stmt->close();
    // return success message
    echo json_encode(array(
        "status" => "success",
        "msg" => "Successfully uploaded report."
    ));
} else {
    // send fail message
    echo json_encode(array(
        "status" => "fail",
        "msg" => "Data is invalid."
    ));
}
