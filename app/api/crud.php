<?php
require_once __DIR__.'/../includes/auth.php'; requireAuth(); require_once __DIR__.'/../config/db.php';
header('Content-Type: application/json');
$config=[
'students'=>['table'=>'students','fields'=>['student_id','first_name','last_name','course','department','medical_status','medical_note'],'unique'=>'student_id'],
'employees'=>['table'=>'employees','fields'=>['employee_id','first_name','last_name','designation','department','medical_status','medical_note'],'unique'=>'employee_id'],
'medicines'=>['table'=>'medicines','fields'=>['medicine_name','brand','dosage','form','expiry_date','quantity','low_stock_threshold']],
'admissions'=>['table'=>'admissions','fields'=>['date','time_in','name','designation','reason','intervention','disposition','time_out','clinic_staff_name']],
'consultations'=>['table'=>'consultations','fields'=>['date','name','designation','reason','diagnosis','follow_up_checkup','follow_up_lab','remarks','physician_name']],
'borrowings'=>['table'=>'borrowings','fields'=>['date','name','designation','equipment_id','date_returned','remarks','clinic_staff']],
'first_aid'=>['table'=>'first_aid_cases','fields'=>['cause','date','time','name','designation','treatment','disposition','clinic_staff_name']],
];
$m=$_REQUEST['module']??''; $a=$_REQUEST['action']??''; if(!isset($config[$m])){http_response_code(400);echo json_encode(['ok'=>false,'error'=>'Invalid module']);exit;}
$c=$config[$m]; $t=$c['table'];
try{
if($a==='list'){echo json_encode(['ok'=>true,'data'=>$pdo->query("SELECT * FROM $t WHERE deleted_at IS NULL ORDER BY id DESC")->fetchAll()]);exit;}
if($a==='save'){ $id=(int)($_POST['id']??0); $d=[]; foreach($c['fields'] as $f){$d[$f]=trim((string)($_POST[$f]??''));}
if(isset($c['unique']) && $d[$c['unique']]!==''){ $q=$pdo->prepare("SELECT id FROM $t WHERE {$c['unique']}=? AND deleted_at IS NULL".($id?" AND id<>$id":"")); $q->execute([$d[$c['unique']]]); if($q->fetch()){echo json_encode(['ok'=>false,'error'=>'Duplicate record']);exit;}}
if($id){$sets=implode(',',array_map(fn($f)=>"$f=?",array_keys($d)));$pdo->prepare("UPDATE $t SET $sets,updated_at=NOW() WHERE id=?")->execute([...array_values($d),$id]);}
else{$cols=implode(',',array_keys($d));$ph=rtrim(str_repeat('?,',count($d)),',');$pdo->prepare("INSERT INTO $t ($cols,created_at,updated_at) VALUES ($ph,NOW(),NOW())")->execute(array_values($d)); if($m==='borrowings'&&!empty($d['equipment_id']))$pdo->prepare('UPDATE equipments SET quantity=GREATEST(quantity-1,0) WHERE id=?')->execute([$d['equipment_id']]);}
 echo json_encode(['ok'=>true,'message'=>'Saved']);exit;}
if($a==='delete'){$pdo->prepare("UPDATE $t SET deleted_at=NOW() WHERE id=?")->execute([(int)$_POST['id']]);echo json_encode(['ok'=>true,'message'=>'Deleted']);exit;}
if($a==='detail'){$s=$pdo->prepare("SELECT * FROM $t WHERE id=?");$s->execute([(int)$_GET['id']]);echo json_encode(['ok'=>true,'data'=>$s->fetch()]);exit;}
throw new Exception('Invalid action');
}catch(Throwable $e){http_response_code(500);echo json_encode(['ok'=>false,'error'=>$e->getMessage()]);}
