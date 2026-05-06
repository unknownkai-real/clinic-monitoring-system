<?php $current = basename($_SERVER['PHP_SELF']); ?>
<div class="app-shell">
<aside class="sidebar shadow-sm">
  <div class="p-3 border-bottom"><h5 class="mb-0 text-primary"><i class="bi bi-heart-pulse"></i> ClinicMS</h5></div>
  <nav class="nav flex-column p-2">
    <?php $links=['index.php'=>'speedometer2|Dashboard','students.php'=>'people|Students','employees.php'=>'person-badge|Employees','inventory.php'=>'capsule|Inventory','admissions.php'=>'clipboard2-pulse|Admissions','consultations.php'=>'journal-medical|Consultations','borrowings.php'=>'box-seam|Borrowings','first_aid.php'=>'bandage|First Aid'];
    foreach($links as $file=>$meta): [$icon,$label]=explode('|',$meta); $active=($current===$file)?'active':''; $href=$file==='index.php'?base_url('index.php'):base_url('modules/'.$file); ?>
    <a class="nav-link <?= $active ?>" href="<?= e($href) ?>"><i class="bi bi-<?= e($icon) ?> me-2"></i><?= e($label) ?></a>
    <?php endforeach; ?>
  </nav>
</aside>
<main class="content">
<header class="topbar shadow-sm bg-white px-3 py-2 d-flex justify-content-between align-items-center">
  <div><strong><?= e(ucfirst(str_replace('.php','',$current==='index.php'?'dashboard':$current))) ?></strong></div>
  <div><?= e($_SESSION['user']['full_name']) ?> <span class="badge text-bg-info"><?= e($_SESSION['user']['role']) ?></span>
  <a class="btn btn-outline-danger btn-sm ms-2" href="<?= e(base_url('auth/logout.php')) ?>" onclick="return confirm('Logout now?')">Logout</a></div>
</header>
<div class="container-fluid p-3">
<nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="<?= e(base_url('index.php')) ?>">Home</a></li><li class="breadcrumb-item active"><?= e(ucfirst(str_replace('.php','',$current==='index.php'?'Dashboard':$current))) ?></li></ol></nav>
