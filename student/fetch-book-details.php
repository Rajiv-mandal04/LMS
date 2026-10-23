<?php
$conn = new mysqli("127.0.0.1", "root", "", "library_db", 3309);

$book_id = intval($_GET['book_id']);

$q = $conn->query("SELECT * FROM issued_books WHERE book_id=$book_id LIMIT 1");
if ($q->num_rows == 0) {
    echo json_encode(["error" => "No issued record found for this Book ID"]);
    exit;
}

$row = $q->fetch_assoc();

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
