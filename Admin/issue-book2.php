
<?php
require_once __DIR__ . '/../login/db.php';

$student_id = $_POST['student_id'] ?? '';
$book_id = intval($_POST['book_id'] ?? 0);
$book_title = $_POST['book_title'] ?? '';
$author = $_POST['author'] ?? '';
$issue_date = $_POST['issue_date'] ?? '';
$due_date = $_POST['due_date'] ?? '';

if (!$book_id || !$student_id || !$book_title || !$author || !$issue_date || !$due_date) {
    echo "missing_data";
    exit;
}

try {
    $checkStmt = $conn->prepare("SELECT quantity FROM add_books1 WHERE id = ?");
    $checkStmt->execute([$book_id]);
    $row = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        if ((int)$row['quantity'] > 0) {
            $insertStmt = $conn->prepare(
                "INSERT INTO issued_books
                (student_id, book_title, author, issue_date, due_date, book_id)
                VALUES (?, ?, ?, ?, ?, ?)"
            );

            if ($insertStmt->execute([
                $student_id, $book_title, $author,
                $issue_date, $due_date, $book_id
            ])) {
                $updateStmt = $conn->prepare(
                    "UPDATE add_books1 SET quantity = quantity - 1 WHERE id = ?"
                );
                $updateStmt->execute([$book_id]);

                $deleteStmt = $conn->prepare(
                    "DELETE FROM book_requests WHERE student_id = ? AND title = ?"
                );
                $deleteStmt->execute([$student_id, $book_title]);

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
} catch (PDOException $e) {
    error_log("Issue book error: " . $e->getMessage());
    echo "error";
}
?>
