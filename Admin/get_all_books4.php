<?php
header('Content-Type: application/json');

$conn = new mysqli("127.0.0.1", "root", "", "library_db", 3309);
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed."]));
}

$result = $conn->query("SELECT * FROM add_books1");
$books = [];

while ($row = $result->fetch_assoc()) {
    $books[] = $row;
}

echo json_encode($books);


$conn->close();
?>

