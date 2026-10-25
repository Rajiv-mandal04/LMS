
<?php
require_once __DIR__ . '/../auth.php';
requireRole('admin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add New Book</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background: linear-gradient(135deg, #e3f2fd, #fce4ec);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 30px;
    }

    form {
      background-color: white;
      padding: 40px 30px;
      border-radius: 16px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 500px;
    }

    h2 {
      text-align: center;
      color: #0077cc;
      margin-bottom: 25px;
      font-size: 28px;
    }

    label {
      display: block;
      margin: 12px 0 6px;
      font-weight: 600;
      color: #333;
    }

    input {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
    }

    input:focus {
      outline: none;
      border-color: #0077cc;
    }

    button {
      width: 100%;
      margin-top: 25px;
      padding: 12px;
      background-color: #0077cc;
      color: white;
      border: none;
      font-size: 18px;
      font-weight: bold;
      border-radius: 8px;
      cursor: pointer;
    }

    button:hover {
      background-color: #005fa3;
    }

    .back {
      display: block;
      text-align: center;
      margin-top: 18px;
      color: #0077cc;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <form action="add-books1.php" method="POST">
    <h2>📚 Add New Book</h2>

    <label for="title">Book Title</label>
    <input type="text" id="title" name="title" maxlength="255" required>

    <label for="author">Author</label>
    <input type="text" id="author" name="author" maxlength="255" required>

    <label for="category">Category</label>
    <input type="text" id="category" name="category" maxlength="150" required>

    <label for="quantity">Quantity</label>
    <input type="number" id="quantity" name="quantity" min="0" required>

    <button type="submit">➕ Add Book</button>
    <a class="back" href="dashboard.php">← Back to Dashboard</a>
  </form>
</body>
</html>

