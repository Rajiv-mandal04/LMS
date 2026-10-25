
<?php
session_start();

$role = $_GET['role'] ?? '';

if (!in_array($role, ['admin', 'student'], true)) {
    header("Location: index.html");
    exit;
}

unset(
    $_SESSION[$role . "_user_id"],
    $_SESSION[$role . "_user_name"],
    $_SESSION[$role . "_role"]
);

// Clear shared session variables only if they belong to this role
if (($_SESSION["role"] ?? '') === $role) {
    unset(
        $_SESSION["user_id"],
        $_SESSION["user_name"],
        $_SESSION["role"]
    );
}

header("Location: index.html");
exit;
?>

