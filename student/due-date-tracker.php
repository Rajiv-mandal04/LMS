<?php
require_once __DIR__ . '/../auth.php';
requireRole('student');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Due Date Tracker</title>

<style>
body{font-family:'Segoe UI',sans-serif;padding:20px;background:#f9fafb}
h2{text-align:center;color:#333;margin-bottom:25px}
table{width:100%;border-collapse:collapse;background:white;border-radius:10px;overflow:hidden;box-shadow:0 2px 10px #0000000d}
th,td{padding:14px 16px;text-align:left;border-bottom:1px solid #e5e7eb}
th{background:#1e3a8a;color:white}
tr:hover{background:#f1f5f9}
.overdue{color:#dc2626;font-weight:bold}
.left{color:#059669;font-weight:bold}
.back{display:inline-block;margin-bottom:20px;color:#1e3a8a;text-decoration:none}
@media(max-width:600px){
table,tbody,tr,td{display:block}
thead{display:none}
tr{margin-bottom:12px;border:1px solid #ddd}
td{position:relative;padding-left:45%;min-height:45px}
td:before{content:attr(data-label);position:absolute;left:10px;font-weight:bold}
}
</style>
</head>
<body>

<a class="back" href="dashboard.php">← Back to Dashboard</a>
<h2>📅 Due Date Tracker</h2>

<table>
<thead>
<tr>
<th>Book ID</th><th>Book</th><th>Author</th>
<th>Issue Date</th><th>Due Date</th><th>Status</th>
</tr>
</thead>
<tbody id="trackerTable">
<tr><td colspan="6">Loading...</td></tr>
</tbody>
</table>

<script>
fetch("get_issued_books.php")
.then(res => {
    if (!res.ok) throw new Error("Failed to load books");
    return res.json();
})
.then(data => {
    const table = document.getElementById("trackerTable");
    table.innerHTML = "";

    if (!Array.isArray(data) || data.length === 0) {
        table.innerHTML = "<tr><td colspan='6'>No issued books yet.</td></tr>";
        return;
    }

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    data.forEach(book => {
        const due = new Date(book.due_date + "T00:00:00");
        const days = Math.ceil((due - today) / 86400000);

        const status = days < 0
            ? "Overdue"
            : days === 0 ? "Due today" : days + " days left";

        const row = document.createElement("tr");

        [
            ["Book ID", book.book_id],
            ["Book", book.book_title],
            ["Author", book.author],
            ["Issue Date", book.issue_date],
            ["Due Date", book.due_date]
        ].forEach(([label, value]) => {
            const td = document.createElement("td");
            td.dataset.label = label;
            td.textContent = value ?? "—";
            row.appendChild(td);
        });

        const td = document.createElement("td");
        td.dataset.label = "Status";
        td.textContent = status;
        td.className = days < 0 ? "overdue" : "left";
        row.appendChild(td);

        table.appendChild(row);
    });
})
.catch(error => {
    document.getElementById("trackerTable").innerHTML =
        "<tr><td colspan='6'>Error loading books. Please try again.</td></tr>";
    console.error(error);
});
</script>
</body>
</html>

