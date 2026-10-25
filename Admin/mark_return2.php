
<?php
require_once __DIR__ . '/../login/db.php';

$id = $_GET['id'] ?? 0;
$today = date('Y-m-d');

try {
    $sql = "UPDATE issued_books SET return_date = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$today, $id]);

    echo "Return marked successfully.";

} catch (PDOException $e) {
    error_log("Return update error: " . $e->getMessage());
    echo "Error updating record.";
}
?>
