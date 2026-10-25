<?php
require_once __DIR__ . '/../auth.php';
requireRole('admin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Search Books</title>
<style>
*{box-sizing:border-box}
body{font-family:'Segoe UI',sans-serif;margin:0;padding:30px 20px;background:linear-gradient(to right,#f1f2b5,#135058);min-height:100vh}
h2{color:white;text-align:center;font-size:2rem;margin-bottom:30px;text-shadow:1px 1px 3px #000}
.search-box{max-width:400px;margin:0 auto 30px}
.search-box input{width:100%;padding:12px 18px;border-radius:30px;border:0;font-size:1rem;box-shadow:0 3px 10px #0002}
.book-list{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:20px;max-width:1100px;margin:auto}
.card{background:white;border-radius:12px;padding:20px;box-shadow:0 6px 16px #0002;transition:transform .3s;overflow-wrap:anywhere}
.card:hover{transform:translateY(-4px)}
.title{font-size:1.2rem;font-weight:bold;color:#333}
.author{color:#666;margin:8px 0}
.category{font-size:.9rem;background:#e3f2fd;padding:4px 8px;border-radius:4px;display:inline-block;margin-bottom:8px}
.stock{font-weight:bold;color:#0984e3}
.no-results{text-align:center;color:white;font-size:1.2rem;margin-top:20px}
.back{display:block;text-align:center;margin:25px;color:white}
</style>
</head>
<body>
<h2>📚 Search Books in Library</h2>
<div class="search-box">
<input type="text" id="searchInput" placeholder="🔍 Search by title or Book ID...">
</div>
<div class="book-list" id="bookList">Loading books...</div>
<a class="back" href="dashboard.php">← Back to Dashboard</a>
<script>
let books = [];
const list = document.getElementById("bookList");

function displayBooks(items) {
  list.replaceChildren();
  if (!items.length) {
    const message = document.createElement("div");
    message.className = "no-results";
    message.textContent = "No books found.";
    list.appendChild(message);
    return;
  }

  items.forEach(book => {
    const card = document.createElement("div");
    card.className = "card";

    const title = document.createElement("div");
    title.className = "title";
    title.textContent = "📖 " + (book.title ?? "");

    const author = document.createElement("div");
    author.className = "author";
    author.textContent = "👨‍💼 " + (book.author ?? "");

    const category = document.createElement("div");
    category.className = "category";
    category.textContent = "🗂️ " + (book.category ?? "");

    const stock = document.createElement("div");
    stock.className = "stock";
    stock.textContent = "📦 In Stock: " + (book.quantity ?? 0);

    const id = document.createElement("div");
    id.style.cssText = "font-size:.85rem;color:#999;margin-top:8px";
    id.textContent = "ID: " + book.id;

    card.append(title, author, category, stock, id);
    list.appendChild(card);
  });
}

fetch("get_all_books4.php")
  .then(res => {
    if (!res.ok) throw new Error("Request failed");
    return res.json();
  })
  .then(data => {
    books = Array.isArray(data) ? data : [];
    displayBooks(books);
  })
  .catch(error => {
    list.textContent = "Error loading books. Check get_all_books4.php.";
    console.error(error);
  });

document.getElementById("searchInput").addEventListener("input", function() {
  const query = this.value.trim().toLowerCase();
  displayBooks(books.filter(book =>
    String(book.title ?? "").toLowerCase().includes(query) ||
    String(book.id ?? "").includes(query)
  ));
});
</script>
</body>
</html>

