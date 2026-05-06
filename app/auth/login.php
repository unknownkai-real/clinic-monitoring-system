<?php
session_start();
require_once __DIR__ . '/../config/db.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare('SELECT id, username, password_hash, role, full_name FROM users WHERE username = ? AND deleted_at IS NULL');
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user'] = ['id'=>$user['id'],'username'=>$user['username'],'role'=>$user['role'],'full_name'=>$user['full_name']];
        header('Location: /app/index.php'); exit;
    }
    $error = 'Invalid credentials.';
}
?>
<!doctype html><html><head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light d-flex align-items-center" style="min-height:100vh"><div class="container"><div class="row justify-content-center"><div class="col-md-4"><div class="card shadow"><div class="card-body"><h4>Clinic Login</h4>
<?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post"><div class="mb-3"><label>Username</label><input class="form-control" name="username" required></div><div class="mb-3"><label>Password</label><input type="password" class="form-control" name="password" required></div><button class="btn btn-primary w-100">Login</button></form>
</div></div></div></div></div></body></html>
