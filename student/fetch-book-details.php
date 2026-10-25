
<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../login/db.php';

$book_id = intval($_GET['book_id'] ?? 0);

$stmt = $conn->prepare(
    "SELECT * FROM issued_books WHERE book_id = ? LIMIT 1"
);
$stmt->execute([$book_id]);

$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    echo json_encode(["error" => "No issued record found for this Book ID"]);
    exit;
}

// Fine calculation
$today = date('Y-m-d');
$fine = 0;

if (strtotime($today) > strtotime($row['due_date'])) {
    $daysLate = (strtotime($today) - strtotime($row['due_date'])) / 86400;
    $fine = $daysLate * 5; // Rs. 5 per day late
}

echo json_encode([
    "book_id" => $row['book_id'],
    "book_title" => $row['book_title'],
    "author" => $row['author'],
    "issue_date" => $row['issue_date'],
    "due_date" => $row['due_date'],
    "fine" => $fine
]);
?>

