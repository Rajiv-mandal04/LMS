<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../login/db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("SELECT * FROM add_books1 WHERE id = ?");
    $stmt->execute([$id]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo json_encode(["success" => true, "book" => $row]);
    } else {
        echo json_encode(["success" => false, "message" => "Book not found"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid ID"]);
}
?>

