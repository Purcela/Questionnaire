<?php
$servername = "localhost";
$username = "root"; // XAMPP-ის სტანდარტული მომხმარებელი
$password = ""; // XAMPP-ის სტანდარტული პაროლი (ცარიელი)
$dbname = "sps_kitkhvari";

// კავშირის შექმნა
$conn = new mysqli($servername, $username, $password, $dbname);

// კავშირის შემოწმება
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// ქართული სიმბოლოების კორექტულად ასახვისთვის
$conn->set_charset("utf8");
?>
