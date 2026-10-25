
<?php
require_once __DIR__ . '/../auth.php';
requireRole('admin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Update Book - Admin</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<style>
body{background:linear-gradient(135deg,#e3f2fd,#fce4ec);font-family:'Segoe UI',sans-serif;min-height:100vh;padding:20px}
.form-container{max-width:600px;margin:50px auto;background:#fff;padding:30px;border-radius:20px;box-shadow:0 0 15px #0002}
.form-title{font-size:24px;font-weight:bold;color:#007bff;text-align:center;margin-bottom:25px}
</style>
</head>
<body>
<div class="form-container">
<div class="form-title">📚 Update Book Details</div>

<form id="updateForm">
<div class="mb-3">
<label for="bookId" class="form-label">Enter Book ID</label>
<input type="number" id="bookId" name="id" class="form-control" min="1" required>
</div>

<button type="button" id="findBook" class="btn btn-secondary w-100 mb-3">Find Book</button>

<div id="bookDetails" style="display:none">
<div class="mb-3">
<label for="title" class="form-label">Title</label>
<input type="text" id="title" name="title" class="form-control" required>
</div>
<div class="mb-3">
<label for="author" class="form-label">Author</label>
<input type="text" id="author" name="author" class="form-control" required>
</div>
<div class="mb-3">
<label for="category" class="form-label">Category</label>
<input type="text" id="category" name="category" class="form-control" required>
</div>
<div class="mb-3">
<label for="quantity" class="form-label">Quantity (Not Editable)</label>
<input type="number" id="quantity" name="quantity" class="form-control" readonly>
</div>
<button type="submit" class="btn btn-primary w-100">Update Book</button>
</div>
</form>

<div id="response-msg" class="mt-3" role="status"></div>
<a href="dashboard.php" class="d-block text-center mt-3">← Back to Dashboard</a>
</div>

<script>
const msgBox = document.getElementById("response-msg");
const details = document.getElementById("bookDetails");

document.getElementById("findBook").addEventListener("click", loadBook);
document.getElementById("bookId").addEventListener("keydown", function(e) {
  if (e.key === "Enter") {
    e.preventDefault();
    loadBook();
  }
});

async function loadBook() {
  const id = document.getElementById("bookId").value;
  if (!id) {
    msgBox.textContent = "Enter a valid Book ID.";
    return;
  }

  try {
    const response = await fetch("fetch-book6.php?id=" + encodeURIComponent(id));
    const data = await response.json();

    if (!data.success) {
      details.style.display = "none";
      msgBox.textContent = data.message || "Book not found.";
      return;
    }

    document.getElementById("title").value = data.book.title ?? "";
    document.getElementById("author").value = data.book.author ?? "";
    document.getElementById("category").value = data.book.category ?? "";
    document.getElementById("quantity").value = data.book.quantity ?? 0;
    details.style.display = "block";
    msgBox.textContent = "";
  } catch (error) {
    msgBox.textContent = "Unable to load book. Check fetch-book6.php.";
    console.error(error);
  }
}

document.getElementById("updateForm").addEventListener("submit", async function(e) {
  e.preventDefault();

  try {
    const response = await fetch("update-book6.php", {
      method: "POST",
      body: new FormData(this)
    });
    const data = await response.json();

    msgBox.className = "mt-3 alert " + (data.success ? "alert-success" : "alert-danger");
    msgBox.textContent = data.message || (data.success ? "Book updated." : "Update failed.");
  } catch (error) {
    msgBox.className = "mt-3 alert alert-danger";
    msgBox.textContent = "Unable to update book. Check update-book6.php.";
    console.error(error);
  }
});
</script>
</body>
</html>

