<?php
$conn = new mysqli("127.0.0.1", "root", "", "library_db", 3309);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Added book_id
$sql = "SELECT book_id, book_title, author, issue_date, due_date FROM issued_books";
$result = $conn->query($sql);

$issued_books = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $issued_books[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($issued_books);

$conn->close();
?>
