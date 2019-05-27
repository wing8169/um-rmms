<?php
session_start();
include("../config.php");
// find all the emails
$stmt = $conn->prepare("SELECT email FROM user");
$stmt->execute();
$result = $stmt->get_result();
$emails = array();
while ($row = $result->fetch_assoc()) {
    $tmp = $row['email'];
    if ($tmp != $_SESSION['user']) array_push($emails, $tmp);
}
echo json_encode($emails);
