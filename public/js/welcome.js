let selectedRole="";function openLogin(role){selectedRole=role;document.getElementById("login-role").value=role;document.getElementById("login-title").textContent="Login "+capitalize(role);const identityLabel=document.getElementById("identity-label");switch(role){case "admin":identityLabel.textContent="Email";break;case "mahasiswa":identityLabel.textContent="NIM";break;case "dosen":identityLabel.textContent="Email atau NIDN";break;default:identityLabel.textContent="Email"}
M.Modal.getInstance(document.getElementById("login-modal")).open()}
function validateLoginRole(){const role=document.getElementById("login-role").value;if(!role){M.toast({html:"Silakan pilih jenis login terlebih dahulu.",classes:"red darken-2 white-text",});return!1}
return!0}
function capitalize(str){return str.charAt(0).toUpperCase()+str.slice(1)}
function showPreloader(){document.getElementById('linear-preloader').style.display='block'}
function hidePreloader(){document.getElementById('linear-preloader').style.display='none'}
document.addEventListener('DOMContentLoaded',function(){showPreloader()});window.addEventListener('load',function(){hidePreloader()})