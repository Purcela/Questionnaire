<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("გთხოვთ, გაიაროთ ავტორიზაცია.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $new_password_repeat = $_POST['new_password_repeat'];
    $user_id = $_SESSION['user_id'];

    if ($new_password !== $new_password_repeat) {
        die("ახალი პაროლები არ ემთხვევა.");
    }
    
    if (strlen($new_password) < 6) {
        die("პაროლი უნდა შედგებოდეს მინიმუმ 6 სიმბოლოსგან.");
    }

    // ძველი პაროლის შემოწმება
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($old_password, $hashed_password)) {
        // თუ ძველი პაროლი სწორია, ვცვლით ახლით
        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $update_stmt->bind_param("si", $new_hashed_password, $user_id);
        
        if ($update_stmt->execute()) {
            echo "პაროლი წარმატებით შეიცვალა.";
        } else {
            echo "დაფიქსირდა შეცდომა.";
        }
        $update_stmt->close();
    } else {
        echo "ძველი პაროლი არასწორია.";
    }
    $conn->close();
}
?>