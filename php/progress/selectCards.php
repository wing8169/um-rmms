<?php
session_start();
include("../config.php");

date_default_timezone_set("Asia/Kuala_Lumpur");
// get all reports data
$stmt = $conn->prepare("SELECT ID, email, full_name FROM user WHERE ID in (SELECT user_id FROM meeting WHERE ID in (SELECT meeting_id FROM guest WHERE user_id = ?));");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();
$data = array();
while ($row = $result->fetch_assoc()) {
    $id = $row['ID'];
    $email = $row['email'];
    $full_name = $row['full_name'];
    array_push($data, array(
        "id" => $id,
        "email" => $email,
        "full_name" => $full_name,
    ));
}
echo json_encode($data);
