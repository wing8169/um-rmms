<?php
session_start();
include("../config.php");

$id = $_SESSION['role'] == "supervisor" ? $_SESSION["progressid"] : $_SESSION['id'];
$stmt = $conn->prepare("SELECT * FROM task WHERE user_id=? ORDER BY start_date");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_all();

echo json_encode($row);
