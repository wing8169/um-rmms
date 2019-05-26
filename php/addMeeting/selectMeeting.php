<?php
include("php/config.php");
// update events.json
$jsonString = file_get_contents('events.json');
$data = json_decode($jsonString, true);
// find all the meetings including as guest 
$stmt = $conn->prepare("SELECT * from `meeting` WHERE user_id=" . $_SESSION['id'] . " OR ID in (SELECT meeting_id FROM guest WHERE user_id=" . $_SESSION['id'] . ");");
$stmt->execute();
$result = $stmt->get_result();
$new_data = array();
while ($row = $result->fetch_assoc()) {
    date_default_timezone_set("Asia/Kuala_Lumpur");
    // compute date time to milliseconds
    $start = $row['start_time'];
    $start_computed = strtotime($start) * 1000;
    $end = $row['end_time'];
    $end_computed = strtotime($end) * 1000;
    // {
    //     "id": "293",
    //     "title": "Group discussion 1",
    //     "url": "http://www.example.com/",
    //     "class": "event-warning",
    //     "start": "1362938400000",
    //     "end": "1362942000000",
    //     "image": "img/test.jpeg",
    //     "venue": "FSKTM",
    //     "description": "HS Ong and discuss about our project purpose."
    //   },
    $tmp =  array(
        "id" => (string)$row['ID'],
        "title" => $row['title'],
        "url" => '#',
        "class" => 'event-warning',
        "start" => (string)$start_computed,
        "end" => (string)$end_computed,
        "image" => 'img/test.jpeg',
        "venue" => $row['venue'],
        "description" => $row['description'],
    );
    array_push($new_data, $tmp);
}
$data["result"] = $new_data;
$newJsonString = json_encode($data);
file_put_contents('events.json', $newJsonString);
