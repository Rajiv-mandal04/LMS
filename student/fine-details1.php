
<?php
require_once __DIR__ . '/../auth.php';
requireRole('student');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Fine Details</title>

<style>
body{font-family:'Segoe UI',sans-serif;margin:0;padding:30px;background:#f9fafb}
h2{text-align:center;color:#1e3a8a;margin-bottom:25px}
table{width:100%;border-collapse:collapse;background:white;box-shadow:0 6px 15px #0000001a;border-radius:8px;overflow:hidden}
th,td{padding:14px 18px;text-align:left;border-bottom:1px solid #eee}
th{background:#1e40af;color:white}
tr:nth-child(even){background:#f1f5f9}
.fine{color:#b91c1c;font-weight:bold}
.no-fine{color:green;font-weight:600}
.back{display:inline-block;margin-bottom:20px;color:#1e3a8a;text-decoration:none}
@media(max-width:650px){body{padding:12px}table{font-size:13px}th,td{padding:8px}}
</style>
</head>
<body>

<a class="back" href="dashboard.php">← Back to Dashboard</a>
<h2>📕 Fine Details</h2>

<table>
<thead>
<tr>
<th>Book ID</th><th>Book</th><th>Author</th>
<th>Due Date</th><th>Per Day Fine</th><th>Total Fine</th>
</tr>
</thead>
<tbody id="fineTable">
<tr><td colspan="6">Loading...</td></tr>
</tbody>
</table>

<script>
const perDayFine = 5;

fetch("fine-details.php")
.then(res => {
    if (!res.ok) throw new Error("Request failed");
    return res.json();
})
.then(data => {
    const table = document.getElementById("fineTable");
    table.innerHTML = "";

    if (!Array.isArray(data) || data.length === 0) {
        table.innerHTML = "<tr><td colspan='6'>No issued books found.</td></tr>";
        return;
    }

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    data.forEach(book => {
        const dueDate = new Date(book.due_date + "T00:00:00");
        const overdueDays = Math.max(
            0, Math.floor((today - dueDate) / 86400000)
        );
        const totalFine = overdueDays * perDayFine;

        const row = document.createElement("tr");

        const values = [
            book.book_id,
            book.book_title,
            book.author,
            book.due_date,
            "₹" + perDayFine,
            totalFine > 0
                ? "₹" + totalFine + " (" + overdueDays + " days late)"
                : "No Fine"
        ];

        values.forEach((value, index) => {
            const td = document.createElement("td");
            td.textContent = value ?? "—";

            if (index === 5) {
                td.className = totalFine > 0 ? "fine" : "no-fine";
            }

            row.appendChild(td);
        });

        table.appendChild(row);
    });
})
.catch(error => {
    document.getElementById("fineTable").innerHTML =
        "<tr><td colspan='6'>Error fetching fine details.</td></tr>";
    console.error(error);
});
</script>
</body>
</html>

