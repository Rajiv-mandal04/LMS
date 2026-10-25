<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function requireRole($role) {
    $userId = $_SESSION[$role . "_user_id"] ?? null;
    $userRole = $_SESSION[$role . "_role"] ?? null;

    if (!$userId || $userRole !== $role) {
        header("Location: /login/index.html");
        exit;
    }

    $_SESSION["user_id"] = $userId;
    $_SESSION["user_name"] = $_SESSION[$role . "_user_name"] ?? "";
    $_SESSION["role"] = $userRole;
}
?>

