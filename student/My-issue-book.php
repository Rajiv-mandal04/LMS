<?php
require_once __DIR__ . '/../login/db.php';

// Fetch book_id along with details
$sql = "SELECT book_id, book_title AS title, author, issue_date, due_date FROM issued_books";
$result = $conn->query($sql);

$books = [];

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $books[] = $row;
}

header('Content-Type: application/json');
echo json_encode($books);
?>

