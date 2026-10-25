<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../login/db.php';

$sql = "SELECT * FROM issued_books";
$result = $conn->query($sql);

$books = [];

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $books[] = $row;
}

echo json_encode($books);
?>
