
<?php
session_start();
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.html");
    exit;
}

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$plainPassword = $_POST["password"] ?? "";

// Public signup se sirf student account banega.
$role = $_POST["role"] ?? "student";

if (!in_array($role, ["admin", "student"], true)) {
    die("Invalid role selected.");
}

if ($name === "" || !filter_var($email, FILTER_VALIDATE_EMAIL) || $plainPassword === "") {
    die("Please enter valid signup details.");
}

$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

try {
    $stmt = $conn->prepare(
        "INSERT INTO users (name, email, password, role)
         VALUES (:name, :email, :password, :role)"
    );

    $stmt->execute([
        ":name" => $name,
        ":email" => $email,
        ":password" => $hashedPassword,
        ":role" => $role
    ]);

    echo "<script>
        alert('Signup successful! Please login.');
        window.location.href='index.html';
    </script>";
    exit;

} catch (PDOException $e) {
    if ($e->getCode() === "23505") {
        echo "<script>
            alert('This email is already registered.');
            window.location.href='index.html';
        </script>";
    } else {
        error_log($e->getMessage());
        http_response_code(500);
        echo "Signup failed. Please try again.";
    }
}

