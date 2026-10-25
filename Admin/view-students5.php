<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../login/db.php';

$sql = "SELECT student_id, COUNT(*) AS total_books
        FROM issued_books
        GROUP BY student_id";

$result = $conn->query($sql);

$data = [];

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $data[] = $row;
}

echo json_encode($data);
?>

