document.getElementById("loginForm").addEventListener("submit", function (e) {
  e.preventDefault();
  const role = document.getElementById("role").value;
  if (role === "admin") {
    window.location.href = "dashboard-admin.html";
  } else if (role === "mahasiswa") {
    window.location.href = "dashboard-mahasiswa.html";
  } else if (role === "dosen") {
    window.location.href = "dashboard-dosen.html";
  }
});