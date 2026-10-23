<?php
$conn = new mysqli("127.0.0.1", "root", "", "library_db", 3309);

$book_id = intval($_POST['book_id']);

// Get issued record
$issue = $conn->query("SELECT * FROM issued_books WHERE book_id=$book_id LIMIT 1")->fetch_assoc();
if (!$issue) { die("Book not found in issued records."); }

// Update book quantity in add_books1
$conn->query("UPDATE add_books1 SET quantity = quantity + 1 WHERE id=$book_id");

// Remove from issued_books
$conn->query("DELETE FROM issued_books WHERE book_id=$book_id LIMIT 1");

echo "Book returned successfully!";
?>
