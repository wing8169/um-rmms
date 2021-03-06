<?php
use PHPMailer\PHPMailer\PHPMailer;

require_once('../PHPMailer/src/Exception.php');
require_once('../PHPMailer/src/PHPMailer.php');
require_once('../PHPMailer/src/SMTP.php');
// umrmms@gmail.com
// UM-0rmms

session_start();
include("../config.php");

if (isset($_POST['start_time']) && isset($_POST['end_time']) && isset($_POST['title']) && isset($_POST['venue']) && isset($_POST['notification']) && isset($_POST['description'])) {
    // insert meeting schedule into database
    $stmt = $conn->prepare("INSERT INTO meeting(user_id, start_time, end_time, title, venue, notification, description) VALUES (?, ?, ?, ?, ?, ?, ?);");
    $stmt->bind_param("issssss", $_SESSION['id'], $_POST['start_time'], $_POST['end_time'], $_POST['title'], $_POST['venue'], $_POST['notification'], $_POST['description']);
    $stmt->execute();
    $id = $stmt->insert_id;
    $stmt->close();
    // send notification email to owner
    $email = $_SESSION['user'];
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = '465';
    $mail->isHTML(true);
    $mail->Username = 'umrmms@gmail.com';
    $mail->Password = 'UM-0rmms';
    $mail->setFrom('No-reply@umrmms.org');
    $mail->Subject = 'UM-RMMS - New Meeting';
    $msg = "<h4>Dear User:</h4>
            <h4>Thank you for using our service. Below are the details of new meeting added:</h4>
            <ul>
                <li>Title: " . $_POST['title'] . "</li>
                <li>Description: " . $_POST['description'] . "</li>
                <li>Start time: " . $_POST['start_time'] . "</li>
                <li>End time: " . $_POST['end_time'] . "</li>
                <li>Venue: " . $_POST['venue'] . "</li>
            </ul>
            <h4>Sincerely</h4>
            <h4>Community of UM-RMMS</h4>
            ";
    $mail->Body = $msg;
    $mail->addAddress($email);
    $mail->Send();
    $guest_list = explode(",", $_POST["guests"]);
    foreach ($guest_list as &$guest) {
        // send notification email to all guests
        $email = $guest;
        $email = password_hash($email, PASSWORD_DEFAULT);
        $id = password_hash($id, PASSWORD_DEFAULT);
        $link_to_reset = 'https://um-rmms.herokuapp.com/php/addMeeting/acceptGuest.php?email=' . $email . '&id=' . $id;
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = '465';
        $mail->isHTML(true);
        $mail->Username = 'umrmms@gmail.com';
        $mail->Password = 'UM-0rmms';
        $mail->setFrom('No-reply@umrmms.org');
        $mail->Subject = 'UM-RMMS - New Meeting Invitation';
        $msg = "<h4>Dear User:</h4>
            <h4>Thank you for using our service. Below are the details of new meeting invitation:</h4>
            <ul>
                <li>Title: " . $_POST['title'] . "</li>
                <li>Description: " . $_POST['description'] . "</li>
                <li>Start time: " . $_POST['start_time'] . "</li>
                <li>End time: " . $_POST['end_time'] . "</li>
                <li>Venue: " . $_POST['venue'] . "</li>
            </ul>
            <h4>Kindly click the link here to accept the meeting: </h4>
            <a href='" . $link_to_reset . "'>" . $link_to_reset . "</a>
            <h4>Sincerely</h4>
            <h4>Community of UM-RMMS</h4>
            ";
        $mail->Body = $msg;
        $mail->addAddress($guest);
        $mail->Send();
    }
    // update events.json
    $jsonString = file_get_contents('../../events.json');
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
    file_put_contents('../../events.json', $newJsonString);
    // send full name back
    echo json_encode(array(
        "status" => "success",
        "msg" => "New meeting schedule added!"
    ));
} else {
    // send fail message
    echo json_encode(array(
        "status" => "fail",
        "msg" => "Data is invalid."
    ));
}
