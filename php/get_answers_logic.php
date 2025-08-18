<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    die("წვდომა შეზღუდულია.");
}

$output = '';
$count = 1;

$sql = "SELECT a.id, a.user_name, a.user_email, a.is_seen, q.title 
        FROM answers a 
        JOIN questionnaires q ON a.questionnaire_id = q.id 
        ORDER BY a.submitted_at DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $seen_class = $row['is_seen'] ? 'fa-solid fa-check' : '';

        $output .= '
        <div class="file-box file-saved">
            <div class="files1 file-check">
                <input type="checkbox" name="select" value="'.$row['id'].'">
            </div>
            <p class="files1 file-No1">'.$count++.'</p>
            <div class="files1 seen1">
                <i class="seen2 '.$seen_class.'"></i>
            </div>
            <h3 class="files file-name1"><a href="view_answer.php?id='.$row['id'].'" target="_blank">'.htmlspecialchars($row['title']).'</a></h3>
            <p class="files creator-name1">'.htmlspecialchars($row['user_name']).'</p>
            <p class="files creator-email1">'.htmlspecialchars($row['user_email']).'</p>
            <button class="download-bubbon" data-id="'.$row['id'].'">
                <i class="fa-solid fa-arrow-down"></i>
            </button>
        </div>';
    }
} else {
    $output = "<p>შევსებული კითხვარები არ მოიძებნა.</p>";
}

$conn->close();
echo $output;
?>