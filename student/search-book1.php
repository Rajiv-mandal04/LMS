
<?php
require_once __DIR__ . '/../auth.php';
requireRole('student');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>📚 Search Books</title>

<style>
*{box-sizing:border-box}
body{font-family:Arial,sans-serif;padding:30px;background:#e3e8ed}
h1{text-align:center;margin-bottom:20px;color:#2c3e50}
.back{display:inline-block;margin-bottom:20px;color:#0077cc;text-decoration:none}
#searchInput{width:min(100%,400px);padding:10px;margin-bottom:20px;border:1px solid #ccc;border-radius:6px;font-size:16px}
.table-wrapper{overflow-x:auto}
table{width:100%;border-collapse:collapse;margin-top:10px;background:white}
th,td{border:1px solid #767575;padding:12px;text-align:center}
th{background:#0077cc;color:white}
tr:hover{background:#f1f1f1}
.low-stock{color:#d90429;font-weight:bold}
@media(max-width:600px){body{padding:15px}th,td{padding:8px;font-size:13px}}
</style>
</head>
<body>

<a class="back" href="dashboard.php">← Back to Dashboard</a>
<h1>📚 Search Book</h1>

<input type="text" id="searchInput" placeholder="🔍 Search by Book ID or Title...">

<div class="table-wrapper">
<table id="bookTable">
<thead>
<tr>
<th>Book ID</th>
<th>Title</th>
<th>Author</th>
<th>Category</th>
<th>Quantity</th>
</tr>
</thead>
<tbody>
<tr><td colspan="5">Loading...</td></tr>
</tbody>
</table>
</div>

<script>
let books = [];
const tbody = document.querySelector("#bookTable tbody");

fetch("get_books1.php")
.then(res => {
    if (!res.ok) throw new Error("Failed to fetch books");
    return res.json();
})
.then(data => {
    if (!Array.isArray(data)) throw new Error("Unexpected response");
    books = data;
    displayBooks(books);
})
.catch(error => {
    tbody.innerHTML = "<tr><td colspan='5'>Error loading books. Please try again.</td></tr>";
    console.error(error);
});

function displayBooks(bookList) {
    tbody.innerHTML = "";

    if (bookList.length === 0) {
        tbody.innerHTML = "<tr><td colspan='5'>No matching books found.</td></tr>";
        return;
    }

    bookList.forEach(book => {
        const row = document.createElement("tr");

        const values = [
            book.id,
            book.title,
            book.author,
            book.category,
            Number(book.quantity) <= 0 ? "Out of Stock" : book.quantity
        ];

        values.forEach((value, index) => {
            const cell = document.createElement("td");
            cell.textContent = value ?? "—";

            if (index === 4 && Number(book.quantity) <= 0) {
                cell.className = "low-stock";
            }

            row.appendChild(cell);
        });

        tbody.appendChild(row);
    });
}

document.getElementById("searchInput").addEventListener("input", function() {
    const query = this.value.trim().toLowerCase();

    const filtered = books.filter(book =>
        String(book.id ?? "").includes(query) ||
        String(book.title ?? "").toLowerCase().includes(query)
    );

    displayBooks(filtered);
});
</script>
</body>
</html>

