<?php
use PHPMailer\PHPMailer\PHPMailer;

require_once('PHPMailer/src/Exception.php');
require_once('PHPMailer/src/PHPMailer.php');
require_once('PHPMailer/src/SMTP.php');
// umrmms@gmail.com
// UM-0rmms

function encode_email($m)
{
    // 2 0 1 9  0  5  2  1
    // 2 3 5 7 11 13 17 19
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $date = date('Ymd', time());
    // email encode
    $newm = substr_replace($m, substr($date, 0, 1), 2, 0);
    $newm = substr_replace($newm, substr($date, 1, 1), 3, 0);
    $newm = substr_replace($newm, substr($date, 2, 1), 5, 0);
    $newm = substr_replace($newm, substr($date, 3, 1), 7, 0);
    $newm = substr_replace($newm, substr($date, 4, 1), 11, 0);
    $newm = substr_replace($newm, substr($date, 5, 1), 13, 0);
    $newm = substr_replace($newm, substr($date, 6, 1), 17, 0);
    $newm = substr_replace($newm, substr($date, 7, 1), 19, 0);
    return $newm;
}

session_start();
include("config.php");
if (isset($_POST['email'])) {
    // get account based on email
    $stmt = $conn->prepare("SELECT * FROM user WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $_POST['email']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        echo json_encode(array(
            "status" => "fail",
            "msg" => "The account does not exist."
        ));
    } else {
        // get email
        $row = $result->fetch_assoc();
        $email = $row['email'];
        $stmt->close();
        // hash the email
        $email = password_hash($email, PASSWORD_DEFAULT);
        // encode email with date
        $email = encode_email($email);
        $link_to_reset = 'http://um-rmms.herokuapp.com/php/resetpassword.php?email=' . $email;
        // send reset password email to user
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
        $mail->Subject = 'UM-RMMS - Confirmation for Password Reset';
        $msg = "<h2>Dear User:</h2>
                <h2>Thank you for using our service. Please click the link below for password reset:</h2>
                <a href='" . $link_to_reset . "'>" . $link_to_reset . "</a>
                <h2>Take note that the link will expire after 1 day.</h2>
                ";
        // $msg = "<h1>Dear User:</h1><h1>Thank you for using our service. Please click the link below for password reset:</h1><a href='" . $link_to_reset . "'>" . $link_to_reset . "</a><h2>Take note that the link will expire after 1 day.</2>";
        $mail->Body = $msg;
        $mail->addAddress($_POST['email']);
        $mail->Send();
        echo json_encode(array(
            "status" => "success",
            "msg" => "A confirmation email has sent to your email account. Please check your inbox / Spam mail."
        ));
    }
} else {
    // send fail message
    echo json_encode(array(
        "status" => "fail",
        "msg" => "Invalid email."
    ));
}
