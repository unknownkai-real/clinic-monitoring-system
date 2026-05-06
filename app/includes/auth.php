<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function requireAuth(): void {
    if (empty($_SESSION['user'])) {
        header('Location: /app/auth/login.php');
        exit;
    }
}

function requireRole(array $roles): void {
    requireAuth();
    if (!in_array($_SESSION['user']['role'], $roles, true)) {
        http_response_code(403);
        exit('Forbidden');
    }
}
