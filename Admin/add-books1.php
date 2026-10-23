<?php
// DB Connection
$conn = new mysqli("127.0.0.1", "root", "", "library_db", 3309);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $title = $conn->real_escape_string($_POST['title'] ?? '');
    $author = $conn->real_escape_string($_POST['author'] ?? '');
    $category = $conn->real_escape_string($_POST['category'] ?? '');
    $quantity = intval($_POST['quantity'] ?? 0);

    // Insert query (id auto-increment hai, added_at default hai)
    $sql = "INSERT INTO add_books1 (title, author, category, quantity)
            VALUES ('$title', '$author', '$category', $quantity)";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('✅ Book added successfully!'); window.location.href='dashboard.html';</script>";
    } else {
        echo "❌ Error: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid Request!";
}
?>
