<?php
require_once __DIR__ . '/../login/db.php';

$book_id = intval($_POST['book_id']);

// Get issued record
$stmt = $conn->prepare("SELECT * FROM issued_books WHERE book_id = ? LIMIT 1");
$stmt->execute([$book_id]);
$issue = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$issue) {
    die("Book not found in issued records.");
}

// Update book quantity in add_books1
$stmt = $conn->prepare("UPDATE add_books1 SET quantity = quantity + 1 WHERE id = ?");
$stmt->execute([$book_id]);

// Remove from issued_books
$stmt = $conn->prepare("DELETE FROM issued_books WHERE id = ?");
$stmt->execute([$issue['id']]);

echo "Book returned successfully!";
?>

