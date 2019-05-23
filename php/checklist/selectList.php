<?php
session_start();
include("../config.php");

date_default_timezone_set("Asia/Kuala_Lumpur");
// get all reports data
$stmt = $conn->prepare("SELECT ID, title, time, comment, favourite, checked FROM checklist WHERE user_id = ?;");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();
$data = array();
while ($row = $result->fetch_assoc()) {
    $title = $row['title'];
    $id = $row['ID'];
    $date_time = $row['time'];
    $date_str = substr($date_time, 0, strpos($date_time, " "));
    $time_str = substr($date_time, strpos($date_time, " ") + 1, 5);
    $comment = $row['comment'];
    $favourite = $row['favourite'];
    $checked = $row['checked'];
    array_push($data, array(
        "id" => $id,
        "title" => $title,
        "date_time" => $date_time,
        "date_str" => $date_str,
        "time_str" => $time_str,
        "comment" => $comment,
        "favourite" => $favourite,
        "checked" => $checked
    ));
}
echo json_encode($data);
