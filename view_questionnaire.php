<?php
require_once 'php/db.php';
if (!isset($_GET['id'])) {
    die("ID not provided.");
}
$id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT title, structure FROM questionnaires WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$q = $result->fetch_assoc();

if (!$q) {
    die("Questionnaire not found.");
}

echo "<h1>".htmlspecialchars($q['title'])."</h1>";
echo "<hr>";

$structure = json_decode($q['structure'], true);

foreach ($structure as $item) {
    if ($item['type'] === 'header') continue; // სათაურს აღარ ვხატავთ
    echo "<div>";
    echo "<h3>".htmlspecialchars($item['question'])."</h3>";
    // აქ შეიძლება დაიხატოს პასუხებიც, თუ საჭიროა
    echo "</div><br>";
}
$stmt->close();
$conn->close();
?>