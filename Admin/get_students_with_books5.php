
<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../login/db.php';

// Group by student and count issued books
$sql = "SELECT student_id, COUNT(*) AS total_books
        FROM issued_books
        GROUP BY student_id";

$result = $conn->query($sql);

$students = [];

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $students[] = $row;
}

echo json_encode($students);
?>
