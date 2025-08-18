<?php
session_start(); // სესიის დაწყება მომხმარებლის მონაცემების შესანახად
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password, $role);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // სესიაში ვინახავთ მომხმარებლის ID-ს და როლს
            $_SESSION['user_id'] = $id;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_role'] = $role;
            
            echo "ავტორიზაცია წარმატებულია";
            // header("Location: ../index.html"); // გადამისამართება მთავარ გვერდზე
        } else {
            echo "პაროლი არასწორია";
        }
    } else {
        echo "მომხმარებელი ამ მეილით არ მოიძებნა";
    }
    $stmt->close();
    $conn->close();
}
?>
