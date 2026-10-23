<?php
$conn = new mysqli("127.0.0.1", "root", "", "library_db", 3309);

$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role = $_POST['role'];

$stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $password, $role);

if ($stmt->execute()) {
    echo "<script>alert('Signup successful'); window.location.href='index.html';</script>";
} else {
    echo "Error: " . $conn->error;
}
?>
