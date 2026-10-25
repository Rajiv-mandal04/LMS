
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../login/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        try {
            $stmt = $conn->prepare("DELETE FROM book_requests WHERE id = ?");
            $stmt->execute([$id]);

            echo "deleted";

        } catch (PDOException $e) {
            error_log("Delete request error: " . $e->getMessage());
            echo "error executing delete";
        }

    } else {
        echo "No ID provided.";
    }
} else {
    echo "Invalid request method.";
}
?>

