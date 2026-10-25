
<?php
require_once __DIR__ . '/../login/db.php';

// Added book_id
$sql = "SELECT book_id, book_title, author, issue_date, due_date FROM issued_books";
$result = $conn->query($sql);

$issued_books = [];

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $issued_books[] = $row;
}

header('Content-Type: application/json');
echo json_encode($issued_books);
?>

