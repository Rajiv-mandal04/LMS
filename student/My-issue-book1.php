
<?php
require_once __DIR__ . '/../auth.php';
requireRole('student');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>My Issued Books</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
body{background:#f2f6fc;min-height:100vh;padding:2rem;color:#2c3e50}
h1{text-align:center;font-size:2rem;margin-bottom:2rem;color:#1e3a5f}
.back{display:block;margin-bottom:20px;color:#1e3a5f;text-decoration:none}
.book-container{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:1.5rem}
.book-card{background:white;border:1px solid #dce3ed;border-left:5px solid #1e88e5;border-radius:8px;padding:1.2rem;box-shadow:0 2px 8px #0000000a}
.book-id{font-size:.85rem;color:#6c757d;margin-bottom:4px}
.book-title{font-size:1.1rem;font-weight:600;color:#1e3a5f;margin-bottom:5px}
.book-author{font-size:.95rem;color:#555;margin-bottom:8px}
.book-dates{font-size:.88rem;margin-top:5px}
</style>
</head>
<body>

<a class="back" href="dashboard.php">← Back to Dashboard</a>
<h1>📚 My Issued Books</h1>
<div class="book-container" id="bookList">Loading books...</div>

<script>
fetch("My-issue-book.php")
.then(res => {
    if (!res.ok) throw new Error("Failed to load books");
    return res.json();
})
.then(data => {
    const container = document.getElementById("bookList");
    container.innerHTML = "";

    if (!Array.isArray(data) || data.length === 0) {
        container.textContent = "No issued books found.";
        return;
    }

    data.forEach(book => {
        const card = document.createElement("div");
        card.className = "book-card";

        const fields = [
            ["book-id", "Book ID: " + (book.book_id ?? "—")],
            ["book-title", book.title ?? book.book_title ?? "Untitled"],
            ["book-author", "Author: " + (book.author ?? "Unknown")],
            ["book-dates", "📅 Issued: " + (book.issue_date ?? "—")],
            ["book-dates", "⏳ Due: " + (book.due_date ?? "—")]
        ];

        fields.forEach(([className, value]) => {
            const div = document.createElement("div");
            div.className = className;
            div.textContent = value;
            card.appendChild(div);
        });

        container.appendChild(card);
    });
})
.catch(error => {
    document.getElementById("bookList").textContent =
        "Error loading books. Please try again.";
    console.error(error);
});
</script>
</body>
</html>

