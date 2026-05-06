<?php require_once __DIR__.'/../includes/header.php'; require_once __DIR__.'/../includes/sidebar.php'; ?>
<div class="d-flex justify-content-between mb-3"><h4>Medicines Inventory</h4><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formModal" onclick="editRow()">Add Record</button></div>
<table id="tbl" class="table table-striped"><thead><tr><th>ID</th>medicine_name</th><th>brand</th><th>dosage</th><th>form</th><th>expiry_date</th><th>quantity</th><th>low_stock_threshold<th>Actions</th></tr></thead><tbody></tbody></table>
<div class="modal fade" id="formModal"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h5>Medicines Inventory Form</h5></div><div class="modal-body"><form id="frm"><input type="hidden" name="id" id="id"><input type="hidden" name="module" value="medicines"><input type="hidden" name="action" value="save">
<div class="row g-2">
<div class='col-md-6'><label class='form-label'>medicine name</label><input class='form-control' name='medicine_name' id='medicine_name' required></div>
<div class='col-md-6'><label class='form-label'>brand</label><input class='form-control' name='brand' id='brand' required></div>
<div class='col-md-6'><label class='form-label'>dosage</label><input class='form-control' name='dosage' id='dosage' required></div>
<div class='col-md-6'><label class='form-label'>form</label><input class='form-control' name='form' id='form' required></div>
<div class='col-md-6'><label class='form-label'>expiry date</label><input class='form-control' name='expiry_date' id='expiry_date' required></div>
<div class='col-md-6'><label class='form-label'>quantity</label><input class='form-control' name='quantity' id='quantity' required></div>
<div class='col-md-6'><label class='form-label'>low stock threshold</label><input class='form-control' name='low_stock_threshold' id='low_stock_threshold' required></div>
</div></form></div><div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" onclick="saveRow()">Save</button></div></div></div></div>
<script>
const moduleName = 'medicines'; let dt;
function load(){ $.getJSON('/app/api/crud.php',{module:moduleName,action:'list'},res=>{ dt.clear(); res.data.forEach(r=>{dt.row.add(renderRow(r));}); dt.draw();}); }
function renderRow(r){ const cols = Object.keys(r).filter(k=>!['deleted_at','updated_at','medical_note'].includes(k)); return [...cols.map(k=>r[k]??''), `<button class='btn btn-sm btn-info me-1' onclick='detail(${r.id})'>View</button><button class='btn btn-sm btn-warning me-1' onclick='editRow(${JSON.stringify(r)})'>Edit</button><button class='btn btn-sm btn-danger' onclick='del(${r.id})'>Delete</button>`];}
function saveRow(){ $.post('/app/api/crud.php',$('#frm').serialize(),()=>{bootstrap.Modal.getInstance(document.getElementById('formModal')).hide(); load();});}
function editRow(r=null){ $('#frm')[0].reset(); if(r){Object.keys(r).forEach(k=>$('#'+k).val(r[k]));} }
function del(id){ if(confirm('Delete record?')) $.post('/app/api/crud.php',{module:moduleName,action:'delete',id},load); }
function detail(id){ $.getJSON('/app/api/crud.php',{module:moduleName,action:'detail',id},r=>alert(JSON.stringify(r,null,2))); }
$(function(){dt=$('#tbl').DataTable(); load();});
</script>
<?php require_once __DIR__.'/../includes/footer.php'; ?>
