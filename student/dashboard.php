
<?php
require_once __DIR__ . '/../auth.php';
requireRole('student');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Dashboard</title>
    <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/29/29302.png">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #0077cc;
            color: white;
            padding: 15px 30px;
            position: relative;
            gap: 15px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.4rem;
            font-weight: bold;
        }

        .logo img {
            width: 40px;
            height: 40px;
            border-radius: 5px;
        }

        .center-text {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            font-size: 1.5rem;
            font-weight: bold;
        }

        .logout-btn {
            background-color: #ff4c4c;
            color: white;
            padding: 9px 16px;
            font-size: 1rem;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: #e04343;
        }

        .welcome-msg {
            text-align: center;
            font-size: 1.6rem;
            font-weight: 500;
            margin: 40px 15px 0;
            color: #333;
        }

        main {
            width: min(1100px, 90%);
            margin: 50px auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .box {
            min-height: 170px;
            border-radius: 12px;
            color: white;
            font-size: 1.2rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.3s;
            padding: 20px;
        }

        .box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .box:nth-child(1) { background-color: #f39c12; }
        .box:nth-child(2) { background-color: #27ae60; }
        .box:nth-child(3) { background-color: #e74c3c; }
        .box:nth-child(4) { background-color: #9b59b6; }
        .box:nth-child(5) { background-color: #3498db; }
        .box:nth-child(6) { background-color: #16a085; }

        footer {
            background-color: #12507d;
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            margin-top: auto;
        }

        @media (max-width: 768px) {
            header {
                padding: 15px;
                flex-wrap: wrap;
            }

            .center-text {
                position: static;
                transform: none;
                order: 3;
                width: 100%;
                text-align: center;
                font-size: 1.3rem;
            }

            .logo {
                font-size: 1.2rem;
            }

            main {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
                margin: 30px auto;
            }

            .box {
                min-height: 140px;
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            main {
                grid-template-columns: 1fr;
            }

            .welcome-msg {
                font-size: 1.3rem;
            }
        }
    </style>
</head>

<body>

    <header>
        <div class="logo">
            <img
                src="https://cdn-icons-png.flaticon.com/512/29/29302.png"
                alt="LMS Logo">
            LMS
        </div>

        <div class="center-text">Student Dashboard</div>

        <a href="../login/logout.php?role=student" class="logout-btn"
           onclick="return confirm('Are you sure you want to logout?');">
             Logout
        </a>
    </header>

    <div class="welcome-msg">
        Welcome,
        <?= htmlspecialchars($_SESSION['user_name'] ?? 'Student', ENT_QUOTES, 'UTF-8') ?>!
    </div>

    <main>
        <a href="My-issue-book1.php" class="box">My Issued Books</a>
        <a href="due-date-tracker.php" class="box">My Due Date Tracker</a>
        <a href="fine-details1.php" class="box">My Fine Status</a>
        <a href="search-book1.php" class="box">Search Books</a>
        <a href="request-book6.php" class="box">Request a Book</a>
        <a href="my-return-book5.php" class="box">My Returned Books</a>
    </main>

    <footer>
        © 2026 LMS. All rights reserved.
    </footer>

</body>
</html>

