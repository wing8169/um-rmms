<?php
session_start();
include("../config.php");

// get all reports data
$stmt = $conn->prepare("SELECT report.ID, user.full_name, report.name, report.status, report.review, report.file_path, report.review_path, report.submission_date FROM report INNER JOIN user on user.ID = report.rec_id WHERE report.user_id = ? ORDER BY report.submission_date DESC;");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();
$data = array();
while ($row = $result->fetch_assoc()) {
    $id = $row['ID'];
    $rec_name = $row['full_name'];
    $name = $row['name'];
    $status = $row['status'];
    $review = $row['review'];
    $file_path = $row['file_path'];
    $review_path = $row['review_path'];
    $submission_date = $row['submission_date'];
    array_push($data, array(
        "id" => $id,
        "rec_name" => $rec_name,
        "name" => $name,
        "status" => $status,
        "review" => $review,
        "file_path" => $file_path,
        "review_path" => $review_path,
        "submission_date" => $submission_date
    ));
}
echo json_encode($data);
