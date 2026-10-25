
<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../login/db.php';

$result = $conn->query("SELECT * FROM add_books1");
$books = [];

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $books[] = $row;
}

echo json_encode($books);
?>

