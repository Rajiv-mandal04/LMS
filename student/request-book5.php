<?php
$conn = new mysqli("127.0.0.1", "root", "", "library_db", 3309);
$data = json_decode(file_get_contents("php://input"), true);

$title = $data['title'] ?? '';
$author = $data['author'] ?? '';
$student_id = $data['student_id'] ?? '';

if (!empty($title) && !empty($author) && !empty($student_id)) {
    $query = "INSERT INTO book_requests (title, author, student_id, status, request_date)
              VALUES ('$title', '$author', '$student_id', 'pending', NOW())";

    if ($connect->query($query)) {
        echo "✅ Book requested successfully!";
    } else {
        echo "❌ Error: " . $connect->error;
    }
} else {
    echo "❌ Please fill in all fields.";
}
?>
