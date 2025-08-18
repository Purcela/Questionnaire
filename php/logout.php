<?php
session_start(); // სესიის დაწყება
session_unset(); // ყველა სესიის ცვლადის გასუფთავება
session_destroy(); // სესიის განადგურება

header("Location: ../register.php"); // გადამისამართება ავტორიზაციის გვერდზე
exit();
?>