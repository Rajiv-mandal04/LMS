<?php
session_start();
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.html");
    exit;
}

$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";
$role = strtolower(trim($_POST["role"] ?? ""));

if (
    $email === "" ||
    $password === "" ||
    !in_array($role, ["admin", "student"], true)
) {
    echo "<script>
        alert('Please enter valid login details.');
        window.location.href='index.html';
    </script>";
    exit;
}

try {
    // Find user by email first
    $stmt = $conn->prepare(
        "SELECT id, name, email, password, role
         FROM users
         WHERE LOWER(email) = LOWER(:email)
         LIMIT 1"
    );

    $stmt->execute([":email" => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check user, password and selected role
    if (
        $user &&
        password_verify($password, $user["password"]) &&
        strtolower($user["role"]) === $role
    ) {
        session_regenerate_id(true);

        $_SESSION[$role . "_user_id"] = $user["id"];
        $_SESSION[$role . "_user_name"] = $user["name"];
        $_SESSION[$role . "_role"] = $role;

        if ($role === "admin") {
         header("Location: /Admin/dashboard.php");
        } else {
         header("Location: /student/dashboard.php");
       }
exit;

    }

    echo "<script>
        alert('Invalid email, password, or selected role.');
        window.location.href='index.html';
    </script>";
    exit;

} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo "Login failed. Please try again.";
}
