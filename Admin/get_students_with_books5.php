<?php
header('Content-Type: application/json');

$conn = new mysqli("127.0.0.1", "root", "", "library_db", 3309);
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Group by student and count issued books
$sql = "SELECT student_id, COUNT(*) AS total_books FROM issued_books GROUP BY student_id";
$result = $conn->query($sql);

$students = [];

while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

echo json_encode($students);
$conn->close();
?>
