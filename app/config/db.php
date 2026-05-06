<?php
/**
 * Database bootstrap for XAMPP/local usage.
 * Override defaults via environment variables:
 * DB_HOST, DB_NAME, DB_USER, DB_PASS, DB_PORT
 */
$host = getenv('DB_HOST') ?: '127.0.0.1';
$port = getenv('DB_PORT') ?: '3306';
$db   = getenv('DB_NAME') ?: 'clinic_monitoring';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS');
if ($pass === false) {
    $pass = '';
}
$charset = 'utf8mb4';

$dsn = "mysql:host={$host};port={$port};dbname={$db};charset={$charset}";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    http_response_code(500);
    $safeMessage = htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    echo "<!doctype html><html><head><meta charset='utf-8'><title>Database Setup Required</title>"
       . "<style>body{font-family:Arial,sans-serif;padding:24px;line-height:1.5}code{background:#f2f2f2;padding:2px 6px;border-radius:4px}.box{max-width:900px;margin:auto;border:1px solid #ddd;border-radius:8px;padding:20px}</style>"
       . "</head><body><div class='box'><h2>Database connection failed</h2>"
       . "<p>The system could not connect to MySQL using:</p>"
       . "<p><code>host={$host}</code> <code>port={$port}</code> <code>db={$db}</code> <code>user={$user}</code></p>"
       . "<h3>Fix steps (XAMPP)</h3><ol>"
       . "<li>Start <b>Apache</b> and <b>MySQL</b> in XAMPP Control Panel.</li>"
       . "<li>Open <code>http://localhost/phpmyadmin</code>.</li>"
       . "<li>Create database <code>{$db}</code> and import <code>app/database/clinic_monitoring.sql</code>.</li>"
       . "<li>If needed, edit <code>app/config/db.php</code> or set env vars <code>DB_HOST/DB_NAME/DB_USER/DB_PASS/DB_PORT</code>.</li>"
       . "</ol><p><b>Driver error:</b> <code>{$safeMessage}</code></p></div></body></html>";
    exit;
}
