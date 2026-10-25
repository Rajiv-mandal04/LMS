
<?php
require_once __DIR__ . '/../auth.php';
requireRole('admin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin - Issue Book</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:Arial,sans-serif}
body{background:linear-gradient(to right,#74ebd5,#acb6e5);min-height:100vh;padding:30px 15px}
.wrapper{display:flex;gap:25px;flex-wrap:wrap;max-width:1200px;margin:auto}
.panel{background:white;border-radius:15px;box-shadow:0 10px 25px #0002;padding:25px;flex:1 1 450px;min-width:0}
h2{font-size:23px;margin-bottom:25px;color:#2d3436}
.table-wrap{overflow-x:auto}
table{width:100%;border-collapse:collapse}
th,td{padding:10px;border:1px solid #ddd;text-align:center}
th{background:#f1f1f1}
button{padding:8px 12px;border:0;border-radius:5px;color:white;cursor:pointer;margin:2px}
.issue-btn{background:#00a884}.delete-btn{background:#d63031}
label{display:block;font-weight:bold;margin:10px 0 5px}
input{width:100%;padding:10px;border:1px solid #ccc;border-radius:7px;margin-bottom:12px}
.submit-btn{width:100%;padding:12px;background:#0984e3;color:white;border:0;border-radius:8px;cursor:pointer}
.message{margin-top:12px;overflow-wrap:anywhere}
.back{display:inline-block;margin-top:20px;color:#0652dd}
</style>
</head>
<body>
<div class="wrapper">
<div class="panel">
<h2>📚 Student Requests</h2>
<div class="table-wrap">
<table>
<thead><tr>
<th>Title</th><th>Author</th><th>Student ID</th><th>Status</th><th>Date</th><th>Action</th>
</tr></thead>
<tbody id="requestBody"><tr><td colspan="6">Loading requests...</td></tr></tbody>
</table>
</div>
</div>

<div class="panel">
<h2>📘 Issue a Book</h2>
<form id="issueForm">
<label for="student_id">Student ID</label>
<input type="number" name="student_id" id="student_id" min="1" required>
<label for="book_id">Book ID</label>
<input type="number" name="book_id" id="book_id" min="1" required>
<label for="book_title">Book Title</label>
<input type="text" name="book_title" id="book_title" required>
<label for="author">Author</label>
<input type="text" name="author" id="author" required>
<label for="issue_date">Issue Date</label>
<input type="date" name="issue_date" id="issue_date" required>
<label for="due_date">Due Date</label>
<input type="date" name="due_date" id="due_date" required>
<button class="submit-btn" type="submit">📤 Issue Book</button>
</form>
<div class="message" id="issueMessage" role="status"></div>
<a class="back" href="dashboard.php">← Back to Dashboard</a>
</div>
</div>

<script>
const tbody = document.getElementById("requestBody");

function makeCell(value) {
  const td = document.createElement("td");
  td.textContent = value ?? "";
  return td;
}

async function fetchRequests() {
  tbody.replaceChildren();
  try {
    const response = await fetch("fetch_pending_requests2.php");
    if (!response.ok) throw new Error("Request failed");
    const data = await response.json();

    if (!Array.isArray(data) || data.length === 0) {
      const row = document.createElement("tr");
      const cell = makeCell("No pending requests");
      cell.colSpan = 6;
      row.appendChild(cell);
      tbody.appendChild(row);
      return;
    }

    data.forEach(req => {
      const row = document.createElement("tr");
      [req.title, req.author, req.student_id, req.status, req.request_date]
        .forEach(value => row.appendChild(makeCell(value)));

      const action = document.createElement("td");

      const issue = document.createElement("button");
      issue.type = "button";
      issue.className = "issue-btn";
      issue.textContent = "Issue";
      issue.addEventListener("click", () => {
        document.getElementById("student_id").value = req.student_id ?? "";
        document.getElementById("book_title").value = req.title ?? "";
        document.getElementById("author").value = req.author ?? "";
        document.getElementById("book_id").value = req.book_id ?? "";
      });

      const del = document.createElement("button");
      del.type = "button";
      del.className = "delete-btn";
      del.textContent = "Delete";
      del.addEventListener("click", async () => {
        if (!confirm("Delete this request?")) return;
        try {
          const response = await fetch("delete_request2.php", {
            method: "POST",
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            body: new URLSearchParams({id: req.id})
          });
          const result = (await response.text()).trim();
          if (result === "deleted") {
            alert("Request deleted successfully.");
            fetchRequests();
          } else {
            alert("Delete failed: " + result);
          }
        } catch {
          alert("Unable to delete request.");
        }
      });

      action.append(issue, del);
      row.appendChild(action);
      tbody.appendChild(row);
    });
  } catch (error) {
    const row = document.createElement("tr");
    const cell = makeCell("Error loading requests. Check the backend endpoint.");
    cell.colSpan = 6;
    row.appendChild(cell);
    tbody.appendChild(row);
    console.error(error);
  }
}

document.getElementById("issueForm").addEventListener("submit", async function(e) {
  e.preventDefault();

  const issueDate = document.getElementById("issue_date").value;
  const dueDate = document.getElementById("due_date").value;
  const message = document.getElementById("issueMessage");

  if (dueDate < issueDate) {
    message.textContent = "Due date cannot be before the issue date.";
    return;
  }

  try {
    const response = await fetch("issue-book2.php", {
      method: "POST",
      body: new FormData(this)
    });
    const result = (await response.text()).trim();

    if (result === "success") {
      message.textContent = "Book issued successfully.";
      this.reset();
      await fetchRequests();
    } else if (result === "not_available") {
      message.textContent = "Book is not available.";
    } else {
      message.textContent = "Issue failed: " + result;
    }
  } catch {
    message.textContent = "Unable to contact the server.";
  }
});

fetchRequests();
</script>
</body>
</html>

