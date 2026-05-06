<?php require_once __DIR__.'/../includes/header.php'; require_once __DIR__.'/../includes/sidebar.php'; ?>
<div class="d-flex justify-content-between mb-3"><h4>Doctor Consultations</h4><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formModal" onclick="editRow()">Add Record</button></div>
<table id="tbl" class="table table-striped"><thead><tr><th>ID</th>date</th><th>name</th><th>designation</th><th>reason</th><th>diagnosis</th><th>follow_up_checkup</th><th>follow_up_lab</th><th>remarks</th><th>physician_name<th>Actions</th></tr></thead><tbody></tbody></table>
<div class="modal fade" id="formModal"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h5>Doctor Consultations Form</h5></div><div class="modal-body"><form id="frm"><input type="hidden" name="id" id="id"><input type="hidden" name="module" value="consultations"><input type="hidden" name="action" value="save">
<div class="row g-2">
<div class='col-md-6'><label class='form-label'>date</label><input class='form-control' name='date' id='date' required></div>
<div class='col-md-6'><label class='form-label'>name</label><input class='form-control' name='name' id='name' required></div>
<div class='col-md-6'><label class='form-label'>designation</label><input class='form-control' name='designation' id='designation' required></div>
<div class='col-md-6'><label class='form-label'>reason</label><input class='form-control' name='reason' id='reason' required></div>
<div class='col-md-6'><label class='form-label'>diagnosis</label><input class='form-control' name='diagnosis' id='diagnosis' required></div>
<div class='col-md-6'><label class='form-label'>follow up checkup</label><input class='form-control' name='follow_up_checkup' id='follow_up_checkup' required></div>
<div class='col-md-6'><label class='form-label'>follow up lab</label><input class='form-control' name='follow_up_lab' id='follow_up_lab' required></div>
<div class='col-md-6'><label class='form-label'>remarks</label><input class='form-control' name='remarks' id='remarks' required></div>
<div class='col-md-6'><label class='form-label'>physician name</label><input class='form-control' name='physician_name' id='physician_name' required></div>
</div></form></div><div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" onclick="saveRow()">Save</button></div></div></div></div>
<script>
const moduleName = 'consultations'; let dt;
function load(){ $.getJSON('/app/api/crud.php',{module:moduleName,action:'list'},res=>{ dt.clear(); res.data.forEach(r=>{dt.row.add(renderRow(r));}); dt.draw();}); }
function renderRow(r){ const cols = Object.keys(r).filter(k=>!['deleted_at','updated_at','medical_note'].includes(k)); return [...cols.map(k=>r[k]??''), `<button class='btn btn-sm btn-info me-1' onclick='detail(${r.id})'>View</button><button class='btn btn-sm btn-warning me-1' onclick='editRow(${JSON.stringify(r)})'>Edit</button><button class='btn btn-sm btn-danger' onclick='del(${r.id})'>Delete</button>`];}
function saveRow(){ $.post('/app/api/crud.php',$('#frm').serialize(),()=>{bootstrap.Modal.getInstance(document.getElementById('formModal')).hide(); load();});}
function editRow(r=null){ $('#frm')[0].reset(); if(r){Object.keys(r).forEach(k=>$('#'+k).val(r[k]));} }
function del(id){ if(confirm('Delete record?')) $.post('/app/api/crud.php',{module:moduleName,action:'delete',id},load); }
function detail(id){ $.getJSON('/app/api/crud.php',{module:moduleName,action:'detail',id},r=>alert(JSON.stringify(r,null,2))); }
$(function(){dt=$('#tbl').DataTable(); load();});
</script>
<?php require_once __DIR__.'/../includes/footer.php'; ?>
