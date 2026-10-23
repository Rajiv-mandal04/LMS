<?php
$conn = new mysqli("127.0.0.1", "root", "", "library_db", 3309);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Added book_id to fetch
$sql = "SELECT book_id, student_id, book_title, author, issue_date, due_date FROM issued_books";
$result = $conn->query($sql);

$fineData = [];
$today = date("Y-m-d");
$finePerDay = 5; // ₹5/day

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dueDate = $row['due_date'];
        $daysOverdue = floor((strtotime($today) - strtotime($dueDate)) / (60 * 60 * 24));

        $row['days_overdue'] = max(0, $daysOverdue);
        $row['fine'] = ($daysOverdue > 0) ? ($daysOverdue * $finePerDay) : 0;
        $row['fine_per_day'] = $finePerDay;

        $fineData[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($fineData);
$conn->close();
?>
