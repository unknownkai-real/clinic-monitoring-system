<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="/app/index.php">ClinicMS</a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav me-auto">
        <?php foreach ([
          'students.php'=>'Students', 'employees.php'=>'Employees', 'inventory.php'=>'Inventory',
          'admissions.php'=>'Admissions', 'consultations.php'=>'Consultations', 'borrowings.php'=>'Borrowings', 'first_aid.php'=>'First Aid'
        ] as $file=>$label): ?>
          <li class="nav-item"><a class="nav-link" href="/app/modules/<?= $file ?>"><?= $label ?></a></li>
        <?php endforeach; ?>
      </ul>
      <span class="text-white me-3"><?= htmlspecialchars($_SESSION['user']['full_name']) ?> (<?= htmlspecialchars($_SESSION['user']['role']) ?>)</span>
      <a class="btn btn-sm btn-outline-light" href="/app/auth/logout.php" onclick="return confirm('Logout?')">Logout</a>
    </div>
  </div>
</nav>
<div class="container py-4">
