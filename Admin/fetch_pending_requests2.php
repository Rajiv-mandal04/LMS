<?php
require_once __DIR__ . '/../login/db.php';
// Fetch only 'pending' requests
$sql = "SELECT * FROM book_requests WHERE status = 'pending'";
$result = $conn->query($sql);

$requests = [];

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $requests[] = $row;
}

header('Content-Type: application/json');
echo json_encode($requests);
?>

