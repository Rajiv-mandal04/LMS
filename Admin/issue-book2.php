<?php
$conn = new mysqli("127.0.0.1", "root", "", "library_db", 3309);
if ($conn->connect_error) {
    echo "error";
    exit;
}

$student_id = $conn->real_escape_string($_POST['student_id']);
$book_id = intval($_POST['book_id']);
$book_title = $conn->real_escape_string($_POST['book_title']);
$author = $conn->real_escape_string($_POST['author']);
$issue_date = $conn->real_escape_string($_POST['issue_date']);
$due_date = $conn->real_escape_string($_POST['due_date']);

if (!$book_id || !$student_id || !$book_title || !$author || !$issue_date || !$due_date) {
    echo "missing_data";
    exit;
}

$checkSql = "SELECT quantity FROM add_books1 WHERE id = $book_id";
$checkResult = $conn->query($checkSql);

if ($checkResult && $checkResult->num_rows > 0) {
    $row = $checkResult->fetch_assoc();

    if ((int)$row['quantity'] > 0) {
        $insertSql = "INSERT INTO issued_books (student_id, book_title, author, issue_date, due_date, book_id)
                      VALUES ('$student_id', '$book_title', '$author', '$issue_date', '$due_date', $book_id)";
        if ($conn->query($insertSql)) {
            $conn->query("UPDATE add_books1 SET quantity = quantity - 1 WHERE id = $book_id");
            $conn->query("DELETE FROM book_requests WHERE student_id = '$student_id' AND title = '$book_title'");
            echo "success";
        } else {
            echo "insert_failed";
        }
    } else {
        echo "not_available";
    }
} else {
    echo "book_not_found";
}

$conn->close();
?>
