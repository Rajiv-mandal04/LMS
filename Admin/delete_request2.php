<?php
error_reporting(E_ALL);
ini_set('display_errors', 1); // Show all errors

$conn = new mysqli("127.0.0.1", "root", "", "library_db", 3309);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        $stmt = $conn->prepare("DELETE FROM book_requests WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "deleted";
        } else {
            echo "error executing delete: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "No ID provided.";
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
