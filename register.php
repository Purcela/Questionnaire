<?php
session_start();
require_once 'php/db.php';

$is_logged_in = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>SPS კითხვარი - მომხმარებელი</title>
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

    <main class="user-main">
        <div class="register-box" style="<?php echo $is_logged_in ? 'display:none;' : 'display:flex;'; ?>"> 
            <div class="form-box login"> 
                <h2>შესვლა</h2>
                <form class="form-content" id="login-form"> 
                    <input type="email" name="email" placeholder="მეილი" required> 
                    <input type="password" name="password" placeholder="პაროლი" required> 
                    <a href="#" class="forgot-pass-link">დაგავიწყდა პაროლი?</a> 
                    <button type="submit">შესვლა</button>
                </form>
                <button class="registr-form">დარეგისტრირდი</button> 
            </div>

            <div class="form-box signup" style="display:none;"> 
                <h2>რეგისტრაცია</h2>
                <form class="form-content" id="signup-form">
                    <input class="email" name="email" type="email" placeholder="მეილი" required> 
                    <input class="pass" name="password" type="password" placeholder="პაროლი" required> 
                    <input class="pass2" name="password_repeat" type="password" placeholder="გაიმეორე პაროლი" required> 
                    <div class="policy-text">
                       <input type="checkbox" id="policy" required> 
                       <label class="agree" for="policy">ვეთანხმები</label> 
                    </div>
                    <button type="submit">რეგისტრაცია</button> 
                </form>
                <button class="login-form">სისტემაში შესვლა</button> 
            </div>
        </div>

        <div class="profile-info" style="<?php echo $is_logged_in ? 'display:flex;': 'display:none;'; ?>">
            <div class="user-info">
                <div class="info-box">
                    <img class="profile-image" src="<?php echo isset($_SESSION['user_image']) ? $_SESSION['user_image'] : 'images/profile.png'; ?>" alt="User" /> 
                    <div class="info">
                        <p class="profile-email"><?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : ''; ?></p> 
                    </div>
                </div>
                <a href="php/logout.php"><button>გასვლა</button></a> 
                <div class="change-pass">
                    <p>პაროლის შეცვლა</p>
                    <form class="change-pass-form" id="change-password-form">
                        <input class="old-pass" name="old_password" type="password" placeholder="ძველი პაროლი"> 
                        <input class="new-pass" name="new_password" type="password" placeholder="ახალი პაროლი"> 
                        <input class="new-pass2" name="new_password_repeat" type="password" placeholder="გაიმეორე პაროლი"> 
                        <button class"pass-button" type="submit">შეცვლა</button> 
                    </form>
                </div>
            </div>
        </div>
    </main>
    
    <script src="js/script.js"></script>
</body>
</html>