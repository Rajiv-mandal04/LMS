<?php
require_once __DIR__ . '/../auth.php';
requireRole('admin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Return Book Panel</title>
<style>
*{box-sizing:border-box}
body{font-family:'Segoe UI',sans-serif;padding:25px;background:#f1f5f9;margin:0}
h2{text-align:center;color:#2d3436;margin-bottom:25px}
#returnList{max-width:850px;margin:auto}
.card{background:white;border-radius:10px;box-shadow:0 5px 15px #0001;padding:20px;margin-bottom:18px;overflow-wrap:anywhere}
.overdue{border-left:5px solid red}
.returned{border-left:5px solid green}
.fine{color:red;font-weight:bold}
.status{margin-top:8px}
.back{display:block;text-align:center;margin:20px;color:#0984e3}
</style>
</head>
<body>
<h2>📘 Return Book Panel</h2>
<div id="returnList">Loading...</div>
<a class="back" href="dashboard.php">← Back to Dashboard</a>
<script>
async function loadReturns() {
  const container = document.getElementById("returnList");
  try {
    const response = await fetch("return-book3.php");
    if (!response.ok) throw new Error("Request failed");
    const data = await response.json();
    container.replaceChildren();

    if (!Array.isArray(data) || data.length === 0) {
      container.textContent = "No issued books found.";
      return;
    }

    const today = new Date();
    today.setHours(0,0,0,0);

    data.forEach(book => {
      const card = document.createElement("div");
      card.className = "card";

      const title = document.createElement("div");
      title.textContent = `📖 Book: ${book.book_title ?? ""} by ${book.author ?? ""}`;

      const student = document.createElement("div");
      student.textContent = `👤 Student ID: ${book.student_id ?? ""}`;

      const issue = document.createElement("div");
      issue.textContent = `📅 Issue Date: ${book.issue_date ?? ""}`;

      const due = document.createElement("div");
      due.textContent = `📆 Due Date: ${book.due_date ?? ""}`;

      card.append(title, student, issue, due);

      if (book.return_date && book.return_date !== "0000-00-00") {
        card.classList.add("returned");
        const status = document.createElement("div");
        status.className = "status";
        status.style.color = "green";
        status.textContent = `✔ Returned on ${book.return_date}`;
        card.appendChild(status);
      } else if (book.due_date) {
        const dueDate = new Date(book.due_date + "T00:00:00");
        if (!Number.isNaN(dueDate.getTime()) && today > dueDate) {
          const days = Math.floor((today - dueDate) / 86400000);
          card.classList.add("overdue");
          const fine = document.createElement("div");
          fine.className = "fine";
          fine.textContent = `Overdue by ${days} days | Estimated fine: ₹${days * 5}`;
          card.appendChild(fine);
        } else if (!Number.isNaN(dueDate.getTime())) {
          const left = Math.ceil((dueDate - today) / 86400000);
          const status = document.createElement("div");
          status.className = "status";
          status.style.color = "green";
          status.textContent = `${left} days left`;
          card.appendChild(status);
        }
      }

      container.appendChild(card);
    });
  } catch (error) {
    container.textContent = "Error loading data. Check return-book3.php.";
    console.error(error);
  }
}
loadReturns();
</script>
</body>
</html>

