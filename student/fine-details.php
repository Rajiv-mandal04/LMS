
<?php
require_once __DIR__ . '/../login/db.php';

// Added book_id to fetch
$sql = "SELECT book_id, student_id, book_title, author, issue_date, due_date
        FROM issued_books";
$result = $conn->query($sql);

$fineData = [];
$today = date("Y-m-d");
$finePerDay = 5; // ₹5/day

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $dueDate = $row['due_date'];
    $daysOverdue = floor((strtotime($today) - strtotime($dueDate)) / (60 * 60 * 24));

    $row['days_overdue'] = max(0, $daysOverdue);
    $row['fine'] = ($daysOverdue > 0) ? ($daysOverdue * $finePerDay) : 0;
    $row['fine_per_day'] = $finePerDay;

    $fineData[] = $row;
}

header('Content-Type: application/json');
echo json_encode($fineData);
?>

