<?php
session_start();
$conn = new mysqli("127.0.0.1", "root", "", "library_db", 3309);

$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];

$stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND role=?");
$stmt->bind_param("ss", $email, $role);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        if ($role === 'admin') {
            header("Location: ../admin/dashboard.html");
        } else {
            header("Location: ../student/dashboard.html");
        }
        exit;
    }
}

echo "<script>alert('Invalid login'); window.location.href='index.html';</script>";
?>
