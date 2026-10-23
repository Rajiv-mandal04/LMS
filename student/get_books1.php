<?php
header('Content-Type: application/json');

// Database connection
$conn = new mysqli("127.0.0.1", "root", "", "library_db", 3309);

if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Query books
$result = $conn->query("SELECT * FROM add_books1");

$books = [];

while ($row = $result->fetch_assoc()) {
    $books[] = $row;
}

echo json_encode($books);
$conn->close();
?>
