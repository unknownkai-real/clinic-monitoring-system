<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/db.php';
if (!empty($_SESSION['user'])) redirect_to('index.php');
$error='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $u=trim($_POST['username']??''); $p=$_POST['password']??'';
  $stmt=$pdo->prepare('SELECT id,username,password_hash,role,full_name FROM users WHERE username=? AND deleted_at IS NULL');
  $stmt->execute([$u]); $user=$stmt->fetch();
  if($user && password_verify($p,$user['password_hash'])){ $_SESSION['user']=['id'=>$user['id'],'username'=>$user['username'],'role'=>$user['role'],'full_name'=>$user['full_name']]; redirect_to('index.php'); }
  $error='Invalid username or password.';
}
?><!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light d-flex align-items-center" style="min-height:100vh"><div class="container"><div class="row justify-content-center"><div class="col-md-4"><div class="card shadow border-0"><div class="card-body p-4"><h4 class="mb-1">Clinic Monitoring</h4><p class="text-muted">Secure staff login</p><?php if($error):?><div class="alert alert-danger"><?=e($error)?></div><?php endif;?><form method="post"><div class="mb-3"><label>Username</label><input class="form-control" name="username" required></div><div class="mb-3"><label>Password</label><input type="password" class="form-control" name="password" required></div><button class="btn btn-primary w-100">Sign in</button></form></div></div></div></div></div></body></html>
