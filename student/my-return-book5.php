<?php
require_once __DIR__ . '/../auth.php';
requireRole('student');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Return Book</title>
<style>
*{box-sizing:border-box}
body{font-family:'Segoe UI',Arial,sans-serif;margin:0;background:#f0f4f8;color:#333}
header{background:linear-gradient(90deg,#0077b6,#00b4d8);color:white;padding:20px;text-align:center;font-size:1.5rem;font-weight:bold}
.back{display:block;margin:20px auto 0;max-width:500px;color:#0077b6;text-decoration:none}
main{max-width:500px;margin:25px auto;background:white;padding:25px;border-radius:12px;box-shadow:0 4px 20px #00000014}
.input-row{display:flex;gap:10px}
input[type=number]{min-width:0;flex:2;padding:10px;font-size:1rem;border-radius:8px;border:1px solid #ccc}
button{flex:1;padding:10px;background:#0077b6;color:white;border:0;font-weight:bold;border-radius:8px;cursor:pointer}
button:hover{background:#023e8a}
.details{margin-top:20px;display:none;border-top:1px solid #eee;padding-top:15px}
#fine_text{color:#d90429;font-weight:bold}
.popup{display:none;position:fixed;inset:0;width:100%;height:100%;background:#0008;z-index:1000}
.popup-content{background:white;padding:25px;border-radius:10px;width:min(300px,85%);text-align:center;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%)}
.popup-content h3{color:#d90429}
.popup-content input{width:90%;margin-top:10px;padding:8px;border:1px solid #ccc;border-radius:6px}
.popup-content button{margin-top:12px;width:100%}
.btn-cancel{background:#adb5bd}
.btn-cancel:hover{background:#6c757d}
#message{margin-top:15px}
@media(max-width:540px){main,.back{width:90%}.input-row{flex-wrap:wrap}}
</style>
</head>
<body>
<header>📚 Return Book</header>

<a class="back" href="dashboard.php">← Back to Dashboard</a>

<main>
    <div class="input-row">
        <input type="number" id="book_id" min="1" placeholder="Enter Book ID">
        <button type="button" onclick="fetchDetails()">Search</button>
    </div>

    <div class="details" id="details">
        <p><b>Title:</b> <span id="title"></span></p>
        <p><b>Author:</b> <span id="author"></span></p>
        <p><b>Issue Date:</b> <span id="issue_date"></span></p>
        <p><b>Due Date:</b> <span id="due_date"></span></p>
        <p id="fine_text"></p>
        <button type="button" onclick="submitReturn()">Return Book</button>
    </div>

    <p id="message" role="status"></p>
</main>

<div class="popup" id="finePopup">
    <div class="popup-content">
        <h3>Fine Payment</h3>
        <p>Fine amount: ₹<span id="fine_amount"></span></p>
        <input type="number" id="fine_input" min="0" step="1" placeholder="Enter fine amount">
        <button type="button" onclick="payFine()">Pay & Return</button>
        <button type="button" class="btn-cancel" onclick="closePopup()">Cancel</button>
    </div>
</div>

<script>
let currentBookId = null;
let fine = 0;

async function fetchDetails() {
    const bookId = document.getElementById('book_id').value;
    const message = document.getElementById('message');

    if (!bookId || Number(bookId) <= 0) {
        alert("Please enter a valid Book ID.");
        return;
    }

    document.getElementById('details').style.display = 'none';
    message.textContent = 'Searching...';

    try {
        const response = await fetch(
            `fetch-book-details.php?book_id=${encodeURIComponent(bookId)}`
        );
        const data = await response.json();

        if (!response.ok || data.error) {
            throw new Error(data.error || 'Could not find the issued book.');
        }

        currentBookId = data.book_id;
        fine = Number(data.fine) || 0;

        document.getElementById('title').textContent = data.book_title ?? '';
        document.getElementById('author').textContent = data.author ?? '';
        document.getElementById('issue_date').textContent = data.issue_date ?? '';
        document.getElementById('due_date').textContent = data.due_date ?? '';
        document.getElementById('fine_text').textContent =
            fine > 0 ? `Outstanding fine: ₹${fine}` : 'No fine due.';

        document.getElementById('details').style.display = 'block';
        message.textContent = '';
    } catch (error) {
        message.textContent = error.message || 'Error loading book details.';
    }
}

function submitReturn() {
    if (!currentBookId) {
        alert('Search for your issued book first.');
        return;
    }

    if (fine > 0) {
        document.getElementById('fine_amount').textContent = fine;
        document.getElementById('finePopup').style.display = 'block';
    } else {
        completeReturn();
    }
}

function payFine() {
    const enteredFine = Number(document.getElementById('fine_input').value);

    if (!Number.isFinite(enteredFine) || enteredFine !== fine) {
        alert(`Enter the exact fine amount: ₹${fine}`);
        return;
    }

    // This confirms the amount only. Actual payment must be verified
    // by a trusted payment gateway/server before marking a fine paid.
    completeReturn();
}

function closePopup() {
    document.getElementById('finePopup').style.display = 'none';
}

async function completeReturn() {
    const message = document.getElementById('message');

    try {
        const response = await fetch('my-return-book4.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams({book_id: currentBookId})
        });

        const result = await response.text();

        if (!response.ok) {
            throw new Error(result || 'Unable to return the book.');
        }

        alert(result);
        location.reload();
    } catch (error) {
        message.textContent = error.message || 'Return failed. Please try again.';
    }
}
</script>
</body>
</html>

