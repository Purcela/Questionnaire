<?php
session_start(); // სესიის დაწყება
require_once 'php/db.php'; // მონაცემთა ბაზასთან კავშირის ფაილის ჩართვა

// ვადგენთ, არის თუ არა მომხმარებელი ადმინისტრატორი
$is_admin = (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin');

// ვამოწმებთ, მოთხოვნილია თუ არა კონკრეტული კითხვარი URL-ში (მაგ: index.php?q_id=1)
$questionnaire_id = isset($_GET['q_id']) ? (int)$_GET['q_id'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Free Web tutorials">
    <meta name="keywords" content="HTML, CSS, PHP, JavaScript">
    <meta name="author" content="G">
    <meta name="google" content="notranslate" />
    <script src="https://kit.fontawesome.com/160820775c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>SPS კითხვარი</title>
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

    <main class="index-main">
        <div class="questions-box" style="<?php echo ($is_admin && !$questionnaire_id) ? 'display:none;' : 'display:block;'; ?>">
            <form id="user-questionnaire-form">
                <div class="question-user">
                    <div class="question-list question-list1">
                        <?php
                        if ($questionnaire_id > 0) {
                            // PHP კოდი ბაზიდან კონკრეტული კითხვარის წამოსაღებად და გამოსასახად
                            // ეს ნაწილი მოგვიანებით შეივსება
                            echo "<h2>კითხვარი #{$questionnaire_id}</h2>";
                            // აქ დაიხატება კითხვარის სტრუქტურა
                        } else if (!$is_admin) {
                            echo "<p>გთხოვთ, გახსნათ კითხვარი ადმინისტრატორის მიერ გამოგზავნილი ბმულით.</p>";
                        }
                        ?>
                    </div>
                    <?php if ($questionnaire_id > 0): ?>
                        <button type="submit" class="user-submit">დასრულება</button> 
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <?php if ($is_admin && !$questionnaire_id): ?>
        <div class="question-admin" style="display:block;"> 
            <div class="question-head">
                <textarea class="Questionnaire-info" name="Questionnaire" id="question-00" placeholder="კითხვარის სათაური / აღწერა"></textarea> 
                <button class="form-add add-question-head" title="სათაურის დამატება ფორმაში">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
            <div class="Necessary-box"> 
                <div class="Necessary"> 
                    <form class="Necessary-1 choice" id="Institution">
                        <input list="browsers" name="institution" id="browser" placeholder="აირჩიე დაწესებულება">
                        <datalist id="browsers">
                            <option value="სპეციალური პენიტენციური სამსახური (ადმინისტრაცია)">
                            <option value="ესკორტირების და სპეციალურ ღონისძიებათა მთავარი სამმართველო">
                            <option value="წვევანდელთა გადამზადების ცენტრი">
                            <option value="N1 პენიტენციური დაწესებულება"> 
                            <option value="N2 პენიტენციური დაწესებულება"> 
                            <option value="N3 პენიტენციური დაწესებულება"> 
                            <option value="N5 პენიტენციური დაწესებულება"> 
                            <option value="N6 პენიტენციური დაწესებულება"> 
                            <option value="N8 პენიტენციური დაწესებულება"> 
                            <option value="N8 პენიტენციური დაწესებულების ნაწილი"> 
                            <option value="N10 პენიტენციური დაწესებულება"> 
                            <option value="N11 პენიტენციური დაწესებულება"> 
                            <option value="N12 პენიტენციური დაწესებულება">  
                            <option value="N14 პენიტენციური დაწესებულება"> 
                            <option value="N15 პენიტენციური დაწესებულება">  
                            <option value="N16 პენიტენციური დაწესებულება"> 
                            <option value="N17 პენიტენციური დაწესებულება"> 
                            <option value="N18 პენიტენციური დაწესებულება"> 
                        </datalist>
                    </form>
                    <input class="Necessary-2" type="text" id="fname" name="fname" placeholder="სახელი / გვარი"> 
                    <input class="Necessary-3" type="email" id="email" name="email" placeholder="სამსახურის მეილი:">
                    <input class="Necessary-4" type="text" id="work" name="work" placeholder="თანამდებობა"> 
                </div>
                <button class="form-add add-Necessary" title="აუცილებელი ველების დამატება ფორმაში">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
            <div class="Questionnaire-1"> 
                <textarea class="question-1" type="text" placeholder="კითხვა (ერთი სწორი პასუხი)"></textarea> 
                <div class="answers-1">
                    <div class="add-radio">
                        <input type="radio" id="yes" name="fav_language" value="HTML">
                        <label for="radio1"> --- </label>
                    </div>
                    <div class="add-other">
                        <input type="radio" id="other" name="fav_language" value="HTML">
                        <label for="radio2"> სხვა:
                            <input type="text" id="user-answer" name="answer1" value="">
                        </label>
                    </div> 
                    <button class="form-add add-select-one" title="პასუხის ვარიანტის დამატება">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
                <button class="form-add add-Questionnaire-1" title="ამ კითხვის დამატება ფორმაში">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
            <div class="Questionnaire-2"> 
               <textarea class="question-2" type="text" placeholder="კითხვა (რამდენიმე სწორი პასუხი)"></textarea> 
                <div class="answers-2">
                    <div class="add-radio1">
                        <input type="checkbox" id="yes" name="answer" value="answer">
                        <label for="checkbox1"> --- </label>
                    </div>
                    <div class="add-other1">
                        <input type="checkbox" id="other" name="answer" value="Bike">
                        <label for="checkbox2"> სხვა:
                            <input type="text" id="user-answer" name="answer2" value="">
                        </label> 
                    </div>
                     <button class="form-add add-select-Several" title="პასუხის ვარიანტის დამატება">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
                <button class="form-add add-Questionnaire-2" title="ამ კითხვის დამატება ფორმაში">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
            <div class="Questionnaire-3"> 
               <textarea class="question-3" type="text" placeholder="შეფასების კითხვა"></textarea> 
                 <form class="rate answers-3">
                    <p> ცუდი </p>
                    <input type="radio" id="star-1" name="rate" value="1" />
                    <label for="star5" title="text"> 1 </label>
                    <input type="radio" id="star-2" name="rate" value="2" />
                    <label for="star4" title="text"> 2 </label>
                    <input type="radio" id="star-3" name="rate" value="3" />
                    <label for="star3" title="text"> 3 </label>
                    <input type="radio" id="star-4" name="rate" value="4" />
                    <label for="star2" title="text"> 4 </label>
                    <input type="radio" id="star-5" name="rate" value="5" />
                    <label for="star1" title="text"> 5 </label>
                    <input type="radio" id="star-6" name="rate" value="6" />
                    <label for="star5" title="text"> 6 </label>
                    <input type="radio" id="star-7" name="rate" value="7" />
                    <label for="star4" title="text"> 7 </label>
                    <input type="radio" id="star-8" name="rate" value="8" />
                    <label for="star3" title="text"> 8 </label>
                    <input type="radio" id="star-9" name="rate" value="9" />
                    <label for="star2" title="text"> 9 </label>
                    <input type="radio" id="star-10" name="rate" value="10" />
                    <label for="star1" title="text"> 10 </label>
                    <p> კარდი </p>
                </form> 
                 <button class="form-add add-rate" title="შეფასების კითხვის დამატება ფორმაში">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
            <div class="Questionnaire-4"> 
              <textarea class="question-4" type="text" placeholder=" კითხვარი ტექსტური პასუხით "></textarea>
              <textarea class="answers-4" type="text" placeholder=" ჩაწერეთ პასუხი "></textarea>
              <button class="form-add add-text-answer" title="ღია კითხვის დამატება ფორმაში">
                 <i class="fa-solid fa-plus"></i>
              </button>
            </div>
            <div class="finished-form">
                <div class="question-list">
                    </div>
                <div class="admin-function">
                    <input class="admin-input" type="text" id="admin-mail" name="send-mail" placeholder="მეილი/ები"> 
                    <button class="admin-submit">გაგზავნა</button> 
                </div>
            </div>
        </div>
        <?php endif; ?>
    </main>

    <script src="js/script.js"></script>
</body>
</html>