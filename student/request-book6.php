<?php
require_once __DIR__ . '/../auth.php';
requireRole('student');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Request a Book</title>

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:"Segoe UI",Tahoma,Geneva,Verdana,sans-serif}
body{background:linear-gradient(to right,#e0eafc,#cfdef3);display:flex;justify-content:center;align-items:center;min-height:100vh;padding:20px}
.request-card{background:white;padding:40px 35px;border-radius:18px;box-shadow:0 10px 25px #0000001a;width:100%;max-width:450px;text-align:center}
.request-card h2{font-size:24px;margin-bottom:25px;color:#222}
.request-card input{width:100%;padding:12px 14px;margin:10px 0;border:1px solid #ccc;border-radius:8px;font-size:16px}
.request-card input:focus{outline:none;border-color:#3a8fff;box-shadow:0 0 5px #3a8fff66}
.request-card button{margin-top:20px;width:100%;padding:14px;background:#007bff;color:white;font-size:16px;border:0;border-radius:8px;cursor:pointer}
.request-card button:hover{background:#0056cc}
.message{margin-top:15px;font-weight:bold;overflow-wrap:anywhere}
.success{color:green}
.error{color:red}
.back{display:block;margin-top:20px;color:#007bff;text-decoration:none}
</style>
</head>
<body>

<div class="request-card">
    <h2>📚 Request a Book</h2>

    <form id="requestForm">
        <input type="text" id="title" placeholder="Book Title" maxlength="255" required>
        <input type="text" id="author" placeholder="Author" maxlength="255" required>
        <button type="submit" id="submitBtn">Request Book</button>
    </form>

    <div class="message" id="messageBox" role="status"></div>
    <a class="back" href="dashboard.php">← Back to Dashboard</a>
</div>

<script>
document.getElementById("requestForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    const title = document.getElementById("title").value.trim();
    const author = document.getElementById("author").value.trim();
    const messageBox = document.getElementById("messageBox");
    const submitBtn = document.getElementById("submitBtn");

    if (!title || !author) {
        messageBox.textContent = "Please fill in all fields.";
        messageBox.className = "message error";
        return;
    }

    submitBtn.disabled = true;
    messageBox.textContent = "Submitting request...";
    messageBox.className = "message";

    try {
        const response = await fetch("request-book5.php", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify({title, author})
        });

        const result = await response.text();

        messageBox.textContent = result;
        messageBox.className = "message " +
            (response.ok ? "success" : "error");

        if (response.ok) {
            document.getElementById("requestForm").reset();
        }
    } catch (error) {
        messageBox.textContent = "Server error. Please try again.";
        messageBox.className = "message error";
    } finally {
        submitBtn.disabled = false;
    }
});
</script>
</body>
</html>

