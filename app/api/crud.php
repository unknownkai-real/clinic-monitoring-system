<?php
require_once __DIR__.'/../includes/auth.php';
requireAuth();
require_once __DIR__.'/../config/db.php';
header('Content-Type: application/json');

$config = [
'students'=>['table'=>'students','fields'=>['student_id','first_name','last_name','course','department','medical_status','medical_note']],
'employees'=>['table'=>'employees','fields'=>['employee_id','first_name','last_name','designation','department','medical_status','medical_note']],
'medicines'=>['table'=>'medicines','fields'=>['medicine_name','brand','dosage','form','expiry_date','quantity','low_stock_threshold']],
'equipments'=>['table'=>'equipments','fields'=>['equipment_name','brand','color_size','quantity','requested']],
'damaged_equipment'=>['table'=>'damaged_equipment','fields'=>['equipment_name','brand','color_size','quantity','description','reported_by','status']],
'admissions'=>['table'=>'admissions','fields'=>['date','time_in','name','designation','reason','intervention','disposition','time_out','clinic_staff_name']],
'consultations'=>['table'=>'consultations','fields'=>['date','name','designation','reason','diagnosis','follow_up_checkup','follow_up_lab','remarks','physician_name']],
'borrowings'=>['table'=>'borrowings','fields'=>['date','name','designation','equipment_id','date_returned','remarks','clinic_staff']],
'first_aid'=>['table'=>'first_aid_cases','fields'=>['cause','date','time','name','designation','treatment','disposition','clinic_staff_name']],
];
$module=$_POST['module']??$_GET['module']??''; $action=$_POST['action']??$_GET['action']??'';
if(!isset($config[$module])){http_response_code(400); echo json_encode(['error'=>'Invalid module']); exit;}
$c=$config[$module]; $table=$c['table'];
try{
if($action==='list'){$rows=$pdo->query("SELECT * FROM $table WHERE deleted_at IS NULL ORDER BY id DESC")->fetchAll(); echo json_encode(['data'=>$rows]); exit;}
if($action==='save'){
$id=(int)($_POST['id']??0); $data=[]; foreach($c['fields'] as $f){$data[$f]=trim((string)($_POST[$f]??''));}
if($id>0){$sets=implode(',', array_map(fn($f)=>"$f=?", array_keys($data)));$stmt=$pdo->prepare("UPDATE $table SET $sets, updated_at=NOW() WHERE id=?");$stmt->execute([...array_values($data),$id]);}
else{$cols=implode(',',array_keys($data));$ph=implode(',',array_fill(0,count($data),'?'));$stmt=$pdo->prepare("INSERT INTO $table ($cols,created_at,updated_at) VALUES ($ph,NOW(),NOW())");$stmt->execute(array_values($data));
if($module==='borrowings'&&!empty($data['equipment_id'])){$pdo->prepare('UPDATE equipments SET quantity=quantity-1 WHERE id=? AND quantity>0')->execute([$data['equipment_id']]);}}
 echo json_encode(['ok'=>true]); exit;}
if($action==='delete'){ $id=(int)$_POST['id']; $pdo->prepare("UPDATE $table SET deleted_at=NOW() WHERE id=?")->execute([$id]); echo json_encode(['ok'=>true]); exit;}
if($action==='detail'){ $id=(int)$_GET['id']; $stmt=$pdo->prepare("SELECT * FROM $table WHERE id=?");$stmt->execute([$id]); echo json_encode($stmt->fetch()); exit;}
throw new Exception('Invalid action');
}catch(Throwable $e){http_response_code(500);echo json_encode(['error'=>$e->getMessage()]);}
