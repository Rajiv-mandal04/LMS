<?php
header('Content-Type: application/json');

$conn = new mysqli("127.0.0.1", "root", "", "library_db", 3309);

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM add_books1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode(["success" => true, "book" => $row]);
    } else {
        echo json_encode(["success" => false, "message" => "Book not found"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid ID"]);
}
?>
