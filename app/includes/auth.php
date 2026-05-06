<?php
require_once __DIR__ . '/../config/app.php';

function requireAuth(): void {
    if (empty($_SESSION['user'])) redirect_to('auth/login.php');
}

function requireRole(array $roles): void {
    requireAuth();
    if (!in_array($_SESSION['user']['role'], $roles, true)) {
        http_response_code(403);
        exit('Forbidden');
    }
}
