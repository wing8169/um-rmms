<?php
session_start();
include("../config.php");

if (isset($_POST['emailAddr']) && isset($_POST['reportname']) && isset($_FILES['fileSubmit'])) {
    // get recipient ID based on emailAddr
    $stmt = $conn->prepare("SELECT ID FROM user WHERE email=?");
    $stmt->bind_param("s", $_POST['emailAddr']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $rec_id = $row['ID'];
    // get submission date
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $submission_date = date("Y-m-d");
    // insert report into database
    $stmt = $conn->prepare("INSERT INTO report (user_id, rec_id, name, submission_date) VALUES (?, ?, ?, ?);");
    $stmt->bind_param("iiss", $_SESSION['id'], $rec_id, $_POST['reportname'], $submission_date);
    $stmt->execute();
    // get id of new report
    $id = $stmt->insert_id;
    $stmt->close();
    // move the report into project folder
    $target_dir = "../../reports/";
    $file_name = basename($_FILES["fileSubmit"]["name"]);
    $extension_name = substr($file_name, strpos($file_name, "."));
    $target_file = $target_dir . $id . $extension_name;
    move_uploaded_file($_FILES["fileSubmit"]["tmp_name"], $target_file);
    // update report_path in database
    $stmt = $conn->prepare("UPDATE report SET file_path = ? WHERE id = ?");
    $target_file_modified = substr($target_file, 6);
    $stmt->bind_param("si", $target_file_modified, $id);
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
