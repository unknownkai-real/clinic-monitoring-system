<?php require_once __DIR__.'/includes/header.php'; require_once __DIR__.'/config/db.php'; require_once __DIR__.'/includes/sidebar.php';
$metrics = [
'total_students'=>'SELECT COUNT(*) FROM students WHERE deleted_at IS NULL',
'total_employees'=>'SELECT COUNT(*) FROM employees WHERE deleted_at IS NULL',
'total_admissions'=>'SELECT COUNT(*) FROM admissions WHERE deleted_at IS NULL',
'total_consultations'=>'SELECT COUNT(*) FROM consultations WHERE deleted_at IS NULL',
'available_medicines'=>'SELECT COALESCE(SUM(quantity),0) FROM medicines WHERE deleted_at IS NULL',
'low_stock'=>'SELECT COUNT(*) FROM medicines WHERE quantity <= low_stock_threshold AND deleted_at IS NULL',
'borrowed_equipment'=>'SELECT COUNT(*) FROM borrowings WHERE date_returned IS NULL AND deleted_at IS NULL',
'total_first_aid'=>'SELECT COUNT(*) FROM first_aid_cases WHERE deleted_at IS NULL'];
$data=[]; foreach($metrics as $k=>$q){$data[$k]=(int)$pdo->query($q)->fetchColumn();}
$visits=$pdo->query("SELECT DATE_FORMAT(date,'%Y-%m') m, COUNT(*) c FROM admissions WHERE deleted_at IS NULL GROUP BY m ORDER BY m DESC LIMIT 12")->fetchAll();
?>
<div class="row g-3 mb-4"><?php foreach($data as $k=>$v): ?><div class="col-md-3"><div class="card"><div class="card-body"><h6><?= ucwords(str_replace('_',' ',$k)) ?></h6><h3><?= $v ?></h3></div></div></div><?php endforeach; ?></div>
<div class="card"><div class="card-body"><h5>Monthly Clinic Visits</h5><canvas id="visits"></canvas></div></div>
<script>
const rows = <?= json_encode(array_reverse($visits)) ?>;
new Chart(document.getElementById('visits'), {type:'line', data:{labels:rows.map(r=>r.m), datasets:[{label:'Visits', data:rows.map(r=>r.c), borderColor:'#0d6efd'}]}});
</script>
<?php require_once __DIR__.'/includes/footer.php'; ?>
