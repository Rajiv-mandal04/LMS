<?php
// Create connection
$conn = new mysqli("127.0.0.1", "root", "", "library_db", 3309);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Fetch only 'pending' requests
$sql = "SELECT * FROM book_requests WHERE status = 'pending'";
$result = $conn->query($sql);

$requests = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $requests[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($requests);

$conn->close();
?>
