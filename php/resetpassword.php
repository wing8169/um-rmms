<?php
session_start();
session_unset();
include("config.php");

function decode_email($m)
{
    // 2 0 1 9  0  5  2  1
    // 2 3 5 7 11 13 17 19
    // get today date
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $date = date('Ymd', time());
    // retrieve date info
    $date_info = substr($m, 2, 1) . substr($m, 3, 1) . substr($m, 5, 1) . substr($m, 7, 1) . substr($m, 11, 1) . substr($m, 13, 1) . substr($m, 17, 1) . substr($m, 19, 1);
    if ($date_info != $date)
        exit(json_encode(array(
            "status" => "fail",
            "msg" => "The confirmation email has expired. Please request again."
        )));
    // email decode
    $newm = substr_replace($m, '', 2 - 0, 1);  // 2
    $newm = substr_replace($newm, '', 3 - 1, 1);  // 2
    $newm = substr_replace($newm, '', 5 - 2, 1);  // 3
    $newm = substr_replace($newm, '', 7 - 3, 1);  // 4
    $newm = substr_replace($newm, '', 11 - 4, 1);  // 7
    $newm = substr_replace($newm, '', 13 - 5, 1);  // 8
    $newm = substr_replace($newm, '', 17 - 6, 1);  // 11
    $newm = substr_replace($newm, '', 19 - 7, 1);  // 12
    return $newm;
}

if (isset($_GET['email'])) {
    if (strlen($_GET['email']) < 20)
        exit(json_encode(array(
            "status" => "fail",
            "msg" => "Invalid address."
        )));
    // decode email
    $decoded_email = decode_email($_GET['email']);
    // get original email string
    $ori_email = "";
    $stmt = $conn->prepare("SELECT email FROM user");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $current_email = $row['email'];
        $verified = password_verify($current_email, $decoded_email);
        if (password_verify($current_email, $decoded_email)) {
            $ori_email = $current_email;
            break;
        }
    }
    $stmt->close();
    if ($ori_email == "") {
        exit(json_encode(array(
            "status" => "fail",
            "msg" => "Invalid address."
        )));
    }
    $_SESSION['tmp'] = $ori_email;
    header("Location: /um-rmms/resetpassword.html");
} else {
    // send fail message
    echo json_encode(array(
        "status" => "fail",
        "msg" => "Invalid address."
    ));
}
