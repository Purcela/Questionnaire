<?php
session_start();

// PHPMailer-ის კლასების ჩატვირთვა
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    die("წვდომა შეზღუდულია.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $structure_json = $_POST['structure'];
    $emails_str = $_POST['emails'];
    $admin_id = $_SESSION['user_id'];

    // კითხვარის ბაზაში შენახვა
    $stmt = $conn->prepare("INSERT INTO questionnaires (admin_id, title, structure) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $admin_id, $title, $structure_json);

    if ($stmt->execute()) {
        $last_id = $conn->insert_id;
        $link = "http://localhost/kitkhvari/index.php?q_id=" . $last_id;

        // მეილების გაგზავნა PHPMailer-ით
        $mail = new PHPMailer(true);
        try {
            // სერვერის კონფიგურაცია (გამოიყენეთ თქვენი Gmail მონაცემები)
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'YOUR_GMAIL@gmail.com'; // <<== ჩაწერეთ თქვენი Gmail
            $mail->Password   = 'YOUR_APP_PASSWORD';      // <<== ჩაწერეთ თქვენი Gmail App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';

            // გამომგზავნი
            $mail->setFrom('YOUR_GMAIL@gmail.com', 'SPS კითხვარი');

            // ადრესატები
            $emails_arr = explode(',', $emails_str);
            foreach ($emails_arr as $email) {
                $mail->addAddress(trim($email));
            }

            // მეილის შიგთავსი
            $mail->isHTML(true);
            $mail->Subject = 'ახალი კითხვარი: ' . $title;
            $mail->Body    = 'გთხოვთ, შეავსოთ კითხვარი ბმულზე გადასვლით: <a href="'.$link.'">'.$link.'</a>';
            $mail->AltBody = 'გთხოვთ, შეავსოთ კითხვარი ბმულზე გადასვლით: ' . $link;

            $mail->send();
            echo 'კითხვარი წარმატებით შეიქმნა და გაიგზავნა მითითებულ მეილებზე.';
        } catch (Exception $e) {
            echo "კითხვარი შეიქმნა, მაგრამ მეილი ვერ გაიგზავნა. შეცდომა: {$mail->ErrorInfo}";
        }
    } else {
        echo "დაფიქსირდა შეცდომა კითხვარის შენახვისას.";
    }
    $stmt->close();
    $conn->close();
}
?>