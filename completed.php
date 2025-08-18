<?php
session_start();
require_once 'php/db.php';

// თუ მომხმარებელი არ არის ავტორიზებული, გადავამისამართოთ რეგისტრაციის გვერდზე
if (!isset($_SESSION['user_id'])) {
    header("Location: register.php");
    exit();
}

$is_admin = ($_SESSION['user_role'] === 'admin');
$user_id = $_SESSION['user_id'];
$user_email = $_SESSION['user_email'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>SPS კითხვარი - შედეგები</title>
    <script src="https://kit.fontawesome.com/160820775c.js" crossorigin="anonymous"></script>
</head>
<body>
    <header class="admin-header">
        <a class="register-icon" href="register.php">
            <img src="images/user.png" alt="work">
        </a>
        <a class="index-icon" href="index.php">
            <img src="images/create.jpg" alt="index">
        </a>
        <a class="complated-icon" href="completed.php">
            <img src="images/complated.jpg" alt="completed">
        </a>
    </header>
    
    <main class="files-main">
        <div class="user-draft" style="<?php echo !$is_admin ? 'display:flex;': 'display:none;'; ?>"> 
            <h3>ჩემ მიერ შევსებული კითხვარები</h3>
            <div class="file-draft">
                <div class="draft-userbox1">
                    <h3 class="draft-name1">კითხვარის დასახელება</h3> 
                    <p class="draft-userdata1">შევსების თარიღი</p> 
                    <div class="user-download1">ჩამოტვირთვა</div> 
                </div>
                <?php
                if (!$is_admin) {
                    // SQL მოთხოვნა, რომელიც წამოიღებს ამ მომხმარებლის მიერ შევსებულ პასუხებს
                    $stmt = $conn->prepare("SELECT q.title, a.submitted_at, a.id FROM answers a JOIN questionnaires q ON a.questionnaire_id = q.id WHERE a.user_email = ? ORDER BY a.submitted_at DESC");
                    $stmt->bind_param("s", $user_email);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="draft-userbox">';
                        echo '<h3 class="draft-name"><a href="view_answer.php?id='.$row['id'].'" target="_blank">'.htmlspecialchars($row['title']).'</a></h3>'; 
                        echo '<p class="draft-userdata">'.date('Y-m-d H:i', strtotime($row['submitted_at'])).'</p>'; 
                        // ჩამოტვირთვის ღილაკს დავუმატოთ id, რომ JS-მა იცოდეს რომელი ფაილი ჩამოტვირთოს
                        echo '<button class="user-download" data-id="'.$row['id'].'"><i class="fa-solid fa-arrow-down"></i></button>'; 
                        echo '</div>';
                    }
                    $stmt->close();
                }
                ?>
            </div>
        </div>

        <div class="admin-draft" style="<?php echo $is_admin ? 'display:flex;' : 'display:none;'; ?>"> 
            <div class="complated-drafts-sort"> 
                <button class="admin-created-drafts active">ჩემი შექმნილი კითხვარები</button> 
                <button class="user-complated-drafts">მომხმარებლის შევსებული კითხვარები</button> 
            </div>
            
            <div class="admin-draftbox" style="display:flex;"> 
                 <div class="file-draft">
                    <div class="draft-adminbox1">
                         <h3 class="draft-name1">კითხვარის დასახელება</h3> 
                         <p class="draft-admindata1">შექმნის თარიღი</p> 
                         <div class="admin-draft-download1">*</div> 
                    </div>
                    <?php
                     if ($is_admin) {
                        $stmt = $conn->prepare("SELECT id, title, created_at FROM questionnaires WHERE admin_id = ? ORDER BY created_at DESC");
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) {
                             echo '<div class="draft-adminbox">';
                             echo '<h3 class="draft-name"><a href="view_questionnaire.php?id='.$row['id'].'" target="_blank">'.htmlspecialchars($row['title']).'</a></h3>';
                             echo '<p class="draft-admindata">'.date('Y-m-d H:i', strtotime($row['created_at'])).'</p>'; 
                             echo '<button class="admin-draft-download" data-id="'.$row['id'].'"><i class="fa-solid fa-arrow-down"></i></button>';
                             echo '</div>';
                        }
                        $stmt->close();
                     }
                     ?>
                 </div>
            </div>

            <div class="admin-userbox" style="display:none;"> 
                <div class="file-box sort-bar">
                    <div class="files1 file-check select-all"><input type="checkbox" id="select-all-checkbox"></div> 
                     <p class="files1 file-No">N</p> 
                     <div class="files1 seen"><i class="fa-solid fa-eye"></i></div>
                     <div class="files file-name"><p>კითხვარის სათაური</p><button id="file-sortBtn"><i class="fa-solid fa-sort"></i></button></div> 
                     <p class="files creator-name">სახელი/გვარი <button id="name-sortBtn"><i class="fa-solid fa-sort"></i></button></p>
                     <p class="files creator-email">მომხმარებლის მეილი</p>
                     <div class="download-icon"><i class="fa-solid fa-arrow-down"></i></div>
                </div>
                <div class="user-results">
                    </div>
                 <button class="download">მონიშნულის ჩამოტვირთვა</button> 
            </div>
        </div>
    </main>
    <script src="js/script.js"></script>
</body>
</html>