function appToast(msg){const t=document.getElementById('appToast');t.querySelector('.toast-body').textContent=msg;bootstrap.Toast.getOrCreateInstance(t).show();}
function withLoading(btn,fn){const prev=btn.innerHTML;btn.disabled=true;btn.innerHTML='Saving...';Promise.resolve(fn()).finally(()=>{btn.disabled=false;btn.innerHTML=prev;});}
