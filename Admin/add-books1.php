<?php
// DB Connection
require_once __DIR__ . '/../login/db.php';

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect form data
    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $quantity = intval($_POST['quantity'] ?? 0);

    // Insert query
    try {
        $sql = "INSERT INTO add_books1 (title, author, category, quantity)
                VALUES (:title, :author, :category, :quantity)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':author' => $author,
            ':category' => $category,
            ':quantity' => $quantity
        ]);

        echo "<script>alert('✅ Book added successfully!'); window.location.href='dashboard.php';</script>";

    } catch (PDOException $e) {
        error_log("Add book error: " . $e->getMessage());
        echo "❌ Error adding book.";
    }

} else {
    echo "Invalid Request!";
}
?>

