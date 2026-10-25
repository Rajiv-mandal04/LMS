
<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../login/db.php';

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

    try {
        $stmt = $conn->prepare(
            "UPDATE add_books1
             SET title = ?, author = ?, category = ?, updated_at = ?
             WHERE id = ?"
        );

        $stmt->execute([
            $title,
            $author,
            $category,
            $updated_at,
            $id
        ]);

        echo json_encode([
            "success" => true,
            "message" => "Book updated successfully"
        ]);

    } catch (PDOException $e) {
        error_log("Update book error: " . $e->getMessage());

        echo json_encode([
            "success" => false,
            "message" => "Update failed"
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request"
    ]);
}
?>

