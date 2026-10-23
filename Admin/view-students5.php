<?php
header('Content-Type: application/json');

$conn = new mysqli("127.0.0.1", "root", "", "library_db", 3309);
if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed"]);
    exit;
}

$sql = "SELECT student_id, COUNT(*) as total_books FROM issued_books GROUP BY student_id";
$result = $conn->query($sql);

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
$conn->close();
?>
