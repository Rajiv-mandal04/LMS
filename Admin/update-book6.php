<?php
header('Content-Type: application/json');

$conn = new mysqli("127.0.0.1", "root", "", "library_db", 3309);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];

    // Add "(Updated)" if not already there
    // if (strpos($title, "(Updated)") === false) {
    //     $title .= " (Updated)";
    // }

    $updated_at = date("Y-m-d H:i:s");

    $stmt = $conn->prepare("UPDATE add_books1 SET title=?, author=?, category=?, updated_at=? WHERE id=?");
    $stmt->bind_param("ssssi", $title, $author, $category, $updated_at, $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Book updated successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Update failed"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
