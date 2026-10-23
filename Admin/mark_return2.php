<?php
$id = $_GET['id'] ?? 0;

$conn = new mysqli("127.0.0.1", "root", "", "library_db", 3309);

if ($conn->connect_error) {
    die("Connection failed");
}

$today = date('Y-m-d');

$sql = "UPDATE issued_books SET return_date = '$today' WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    echo "Return marked successfully.";
} else {
    echo "Error updating record.";
}

$conn->close();
?>
