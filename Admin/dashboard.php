<?php
require_once __DIR__ . '/../auth.php';
requireRole('admin');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/29/29302.png">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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
            display: inline-block;
            background-color: #ff4c4c;
            color: white;
            padding: 9px 16px;
            font-size: 1rem;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            white-space: nowrap;
        }

        .logout-btn:hover {
            background-color: #e04343;
        }

        .welcome-msg {
            text-align: center;
            font-size: 1.6rem;
            font-weight: 500;
            margin: 35px 15px 0;
            color: #333;
        }

        main {
            width: min(1100px, 92%);
            margin: 45px auto;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 25px;
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
            transition: transform 0.2s ease, box-shadow 0.3s ease;
            padding: 20px;
        }

        .box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .box:focus-visible,
        .logout-btn:focus-visible {
            outline: 3px solid #222;
            outline-offset: 4px;
        }

        .box:nth-child(1) {
            background-color: #ff6f61;
        }

        .box:nth-child(2) {
            background-color: #6c5ce7;
        }

        .box:nth-child(3) {
            background-color: #00a8a8;
        }

        .box:nth-child(4) {
            background-color: #e84393;
        }

        .box:nth-child(5) {
            background-color: #d99400;
        }

        .box:nth-child(6) {
            background-color: #2d3436;
        }

        footer {
            background-color: #12507d;
            color: #fff;
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
                font-size: 1.25rem;
            }

            main {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 15px;
                margin: 30px auto;
            }

            .box {
                min-height: 135px;
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
            <span>LMS</span>
        </div>

        <div class="center-text">Admin Dashboard</div>

        <a href="../login/logout.php?role=admin" class="logout-btn">Logout</a>
    </header>

    <div class="welcome-msg">
        Welcome, Admin!
    </div>

    <main>
        <a href="add-books2.php" class="box">Add New Book</a>
        <a href="issue-book3.php" class="box">Issue Book</a>
        <a href="return-book4.php" class="box">Return Book</a>
        <a href="search-book4.php" class="box">Search Book</a>
        <a href="view-students6.php" class="box">View Students</a>
        <a href="update-book7.php" class="box">Update Book</a>
    </main>

    <footer>
        &copy; 2026 LMS. All rights reserved.
    </footer>

</body>
</html>

