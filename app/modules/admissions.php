<?php require_once __DIR__.'/../includes/header.php'; require_once __DIR__.'/../includes/sidebar.php'; ?>
<div class="d-flex justify-content-between mb-3"><h4>Clinic Admissions</h4><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formModal" onclick="editRow()">Add Record</button></div>
<table id="tbl" class="table table-striped"><thead><tr><th>ID</th>date</th><th>time_in</th><th>name</th><th>designation</th><th>reason</th><th>intervention</th><th>disposition</th><th>time_out</th><th>clinic_staff_name<th>Actions</th></tr></thead><tbody></tbody></table>
<div class="modal fade" id="formModal"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h5>Clinic Admissions Form</h5></div><div class="modal-body"><form id="frm"><input type="hidden" name="id" id="id"><input type="hidden" name="module" value="admissions"><input type="hidden" name="action" value="save">
<div class="row g-2">
<div class='col-md-6'><label class='form-label'>date</label><input class='form-control' name='date' id='date' required></div>
<div class='col-md-6'><label class='form-label'>time in</label><input class='form-control' name='time_in' id='time_in' required></div>
<div class='col-md-6'><label class='form-label'>name</label><input class='form-control' name='name' id='name' required></div>
<div class='col-md-6'><label class='form-label'>designation</label><input class='form-control' name='designation' id='designation' required></div>
<div class='col-md-6'><label class='form-label'>reason</label><input class='form-control' name='reason' id='reason' required></div>
<div class='col-md-6'><label class='form-label'>intervention</label><input class='form-control' name='intervention' id='intervention' required></div>
<div class='col-md-6'><label class='form-label'>disposition</label><input class='form-control' name='disposition' id='disposition' required></div>
<div class='col-md-6'><label class='form-label'>time out</label><input class='form-control' name='time_out' id='time_out' required></div>
<div class='col-md-6'><label class='form-label'>clinic staff name</label><input class='form-control' name='clinic_staff_name' id='clinic_staff_name' required></div>
</div></form></div><div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" onclick="saveRow()">Save</button></div></div></div></div>
<script>
const moduleName = 'admissions'; let dt;
function load(){ $.getJSON('/app/api/crud.php',{module:moduleName,action:'list'},res=>{ dt.clear(); res.data.forEach(r=>{dt.row.add(renderRow(r));}); dt.draw();}); }
function renderRow(r){ const cols = Object.keys(r).filter(k=>!['deleted_at','updated_at','medical_note'].includes(k)); return [...cols.map(k=>r[k]??''), `<button class='btn btn-sm btn-info me-1' onclick='detail(${r.id})'>View</button><button class='btn btn-sm btn-warning me-1' onclick='editRow(${JSON.stringify(r)})'>Edit</button><button class='btn btn-sm btn-danger' onclick='del(${r.id})'>Delete</button>`];}
function saveRow(){ $.post('/app/api/crud.php',$('#frm').serialize(),()=>{bootstrap.Modal.getInstance(document.getElementById('formModal')).hide(); load();});}
function editRow(r=null){ $('#frm')[0].reset(); if(r){Object.keys(r).forEach(k=>$('#'+k).val(r[k]));} }
function del(id){ if(confirm('Delete record?')) $.post('/app/api/crud.php',{module:moduleName,action:'delete',id},load); }
function detail(id){ $.getJSON('/app/api/crud.php',{module:moduleName,action:'detail',id},r=>alert(JSON.stringify(r,null,2))); }
$(function(){dt=$('#tbl').DataTable(); load();});
</script>
<?php require_once __DIR__.'/../includes/footer.php'; ?>
