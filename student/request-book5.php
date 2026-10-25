
<?php
require_once __DIR__ . '/../auth.php';
requireRole('student');

require_once __DIR__ . '/../login/db.php';

$data = json_decode(file_get_contents("php://input"), true);

$title = trim($data['title'] ?? '');
$author = trim($data['author'] ?? '');
$student_id = $_SESSION['user_id'];

if (!empty($title) && !empty($author)) {
    $query = "INSERT INTO book_requests
              (title, author, student_id, status, request_date)
              VALUES (?, ?, ?, 'pending', NOW())";

    $stmt = $conn->prepare($query);
    $stmt->execute([$title, $author, $student_id]);

    echo "✅ Book requested successfully!";
} else {
    echo "❌ Please fill in all fields.";
}
?>

