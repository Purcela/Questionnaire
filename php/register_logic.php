<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_repeat = $_POST['password_repeat'];

    // შემოწმება, ხომ არ არის მეილი უკვე რეგისტრირებული
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "მითითებული მეილი უკვე რეგისტრირებულია";
    } elseif ($password !== $password_repeat) {
        echo "პაროლები არ ემთხვევა";
    } else {
        // პაროლის დაჰეშირება უსაფრთხოებისთვის
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $insert_stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $insert_stmt->bind_param("ss", $email, $hashed_password);
        
        if ($insert_stmt->execute()) {
            echo "რეგისტრაცია წარმატებით დასრულდა";
            // აქ შეგიძლიათ მომხმარებლის ავტომატური ავტორიზაცია და გადამისამართება
        } else {
            echo "დაფიქსირდა შეცდომა: " . $conn->error;
        }
        $insert_stmt->close();
    }
    $stmt->close();
    $conn->close();
}
?>
