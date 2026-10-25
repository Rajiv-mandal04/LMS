<?php
require_once __DIR__ . '/../auth.php';
requireRole('admin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>View Students</title>
<style>
*{box-sizing:border-box}
body{font-family:'Segoe UI',sans-serif;background:linear-gradient(to right,#e3f2fd,#bbdefb);margin:0;padding:30px 20px;min-height:100vh}
h2{text-align:center;color:#0d47a1;margin-bottom:30px}
.search-box{max-width:400px;margin:0 auto 30px}
input{width:100%;padding:12px 16px;font-size:16px;border-radius:8px;border:1px solid #90caf9;outline:none}
input:focus{border-color:#1976d2}
.card{background:white;border-left:6px solid #42a5f5;box-shadow:0 4px 15px #0002;border-radius:10px;padding:20px;margin:15px auto;max-width:600px;transition:transform .2s}
.card:hover{transform:scale(1.01)}
.highlight{font-weight:bold;color:#0d47a1}
.no-data{text-align:center;color:#c62828;margin-top:30px;font-weight:bold}
.back{display:block;text-align:center;margin:25px;color:#0d47a1}
</style>
</head>
<body>
<h2>📘 Students with Issued Books</h2>
<div class="search-box">
<input type="text" id="searchInput" placeholder="🔍 Search by Student ID...">
</div>
<div id="studentList">Loading...</div>
<a class="back" href="dashboard.php">← Back to Dashboard</a>

<script>
let allStudents = [];
const container = document.getElementById("studentList");

function renderStudents(data) {
  container.replaceChildren();

  if (!data.length) {
    const message = document.createElement("div");
    message.className = "no-data";
    message.textContent = "No issued book data found.";
    container.appendChild(message);
    return;
  }

  data.forEach(student => {
    const card = document.createElement("div");
    card.className = "card";

    const id = document.createElement("div");
    const idLabel = document.createElement("span");
    idLabel.className = "highlight";
    idLabel.textContent = "👤 Student ID: ";
    id.append(idLabel, document.createTextNode(String(student.student_id ?? "")));

    const total = document.createElement("div");
    const totalLabel = document.createElement("span");
    totalLabel.className = "highlight";
    totalLabel.textContent = "📚 Total Books: ";
    total.append(totalLabel, document.createTextNode(String(student.total_books ?? 0)));

    card.append(id, total);
    container.appendChild(card);
  });
}

fetch("view-students5.php")
  .then(res => {
    if (!res.ok) throw new Error("Request failed");
    return res.json();
  })
  .then(data => {
    allStudents = Array.isArray(data) ? data : [];
    renderStudents(allStudents);
  })
  .catch(error => {
    container.innerHTML = "";
    const message = document.createElement("div");
    message.className = "no-data";
    message.textContent = "Error loading data. Check view-students5.php.";
    container.appendChild(message);
    console.error(error);
  });

document.getElementById("searchInput").addEventListener("input", function() {
  const query = this.value.trim().toLowerCase();
  renderStudents(allStudents.filter(student =>
    String(student.student_id ?? "").toLowerCase().includes(query)
  ));
});
</script>
</body>
</html>

