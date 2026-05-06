<?php
if (session_status() === PHP_SESSION_NONE) session_start();

function base_url(string $path = ''): string {
    $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $pos = strpos($scriptName, '/app/');
    $root = $pos !== false ? substr($scriptName, 0, $pos) : rtrim(dirname($scriptName), '/');
    return rtrim($root, '/') . '/app/' . ltrim($path, '/');
}

function redirect_to(string $path): void {
    header('Location: ' . base_url($path));
    exit;
}

function e(?string $v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
