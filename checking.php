<?php require_once __DIR__ . '/visit_handler.php'; ?>
<!DOCTYPE html>
<html lang="en-gb" xmlns="https://www.w3.org/1999/xhtml" xml:lang="en-gb" dir="ltr">

<head>
    <script type="text/javascript">
        window.post = [];
        window.get = [];
    </script>
    <link rel="manifest" href="./manifest.json">
    <!--preload-->
    <link rel="preload" href="./assets/fonts/Poppins-SemiBold.woff" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="./assets/fonts/Poppins-Medium.woff" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="./assets/fonts/icomoon.woff" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="./assets/fonts/Roboto-Regular.woff" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="./assets/fonts/Roboto-Bold.woff" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="./assets/fonts/Roboto-Medium.woff" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="./assets/fonts/Roboto-Light.woff" as="font" type="font/woff2" crossorigin>

    <link rel="preload" href="./assets/js/helper-67c34adf59.min.js" as="script">
    <link rel="preload" href="./assets/css/style-3ef3196ee5.min.css" as="style">
    <link rel="preload" href="./assets/css/globals-43f29dad88.min.css" as="style">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="title" content="Tiquetes Baratos - Vuelos Baratos en Todos los Destinos." />
    <link rel="shortcut icon" href="https://d2wcw8ctp0rb22.cloudfront.net/templates/tiquetesbaratos/images/favicon.ico" type="image/x-icon" />


    <link rel="stylesheet" as="style" href="./assets/css/style-3ef3196ee5.min.css">
    <link rel="stylesheet" as="style" href="./assets/css/globals-43f29dad88.min.css">
    <script type="text/javascript">
        window.dataLayer = window.dataLayer || [];
        var conf = {}

        if (!localStorage.getItem('keyIdentifyForUser')) {
            window.location = '/';
        }
    </script>
    <style type="text/css">
        .loading-message {
            border: 1px solid #15327F;
            padding: .75em 1em;
            margin: 1em 0;
            border-radius: 4px;
            font-size: 1.083em;
            font-weight: bold;
            color: #15327F;
            text-align: center;
        }

        .loading-message .cssload-jumping {
            display: inline-block;
            margin: 0 1em -.25em 0;
            vertical-align: middle;
            line-height: 1;
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
            background-image: url("/images/espera.png");
            background-repeat: no-repeat;
            width: 630px;
            height: 306px;
        }
    </style>
    <script type="text/javascript" src="./assets/js/helper-67c34adf59.min.js"></script>
    <meta charset="utf-8" />
    <meta name="description" content="Despegar con Tiquetes Baratos Ahora es posible. Aprovecha las ofertas con Tiquetes Baratos en mas de 500 Aerolineas. Llamanos Gratis 018000 184253" />
    <meta name="generator" content="Joomla! - Open Source Content Management" />
    <title>Tiquetes Baratos - Tiquetes y Vuelos Baratos</title>
    <link href="/templates/tiquetesbaratos/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />

    <script>
        window.post = window.post ?? [];
    </script>
</head>

<body>
    <div class="espera" id="espera" style="visibility:hidden;">
        <div class="content-landing">
            <div class="espera-gif" id="espera-home-gif"></div>
        </div>
    </div>
    <div class="content-body">
        <!-- header -->
        <header class="c-header container-fluid ">
            <nav class="pt-0 px-0 px-lg-0">
                <div class="container md-container">
                    <div class="row navbar">
                        <div class="col-4 col-md-2">
                            <a class="navbar-brand mt-0 ml-2 ml-md-0" href="./">
                                <img width="100" height="100" alt="logo tiquetes baratos" src="./assets/images/logo.png">
                            </a>
                        </div>
                        <div class="col-8 col-md-10 d-flex px-md-0 pr-0">
                            <ul class="nav ml-auto">
                                <li class="c-writing hide-xs">
                                    <a href="javascript:void(0);" class="py-2 d-block">
                                        <span class="icon icon-contact-support font-20 pr-2"></span>
                                        <span>Escríbenos</span>
                                    </a>
                                </li>
                                <li class="c-help-call px-3 ml-4 hide-xs">
                                    <a role="button" href="Javascript:void(0)" class="py-2 d-block btn-call-me" data-type="menu" modal-open data-target=".modalCall">
                                        <span class="icon icon-support-agent font-20 -pe-none"></span>
                                        <span class="-pe-none">¿Necesitas que te llamemos?</span>
                                    </a>
                                </li>
                                <li>
                                    <a id="sPhoneNumbers" class="nav-item dropdown mr-2 mr-md-0 ml-md-4 ch-dropdown pl-3 pr-2 mt-3 mt-md-0" href="Javascript:void(0)">
                                        <img width="30" height="23" class="mr-1" alt="logo nacionalidad" src="./assets/images/flag-co.png">
                                        <span class="px-1 color-gray">|</span>
                                        <span class="icon icon-phone font-20 mt-2"></span>
                                        <span class="hide-xs">
                                            <span>Bogotá</span>
                                            <span>- 601 743 6620</span>
                                        </span>
                                        <span class="icon icon-expand font-20 mt-2"></span>
                                    </a>
                                    <div id="cPhoneNumbers" class="p-0 px-md-4 py-md-3 c-phone-numbers shadow d-none">
                                        <div class="row c-header-mobile h-mobile">
                                            <div class="col-12">
                                                <div class="row py-4 px-3">
                                                    <div class="col-2 cClosePhoneNumbers">
                                                        <span class="icon icon-arrow-back1 font-24"></span>
                                                    </div>
                                                    <div class="col-10">
                                                        <span class="font-18 font-roboto-medium">¡Comunícate con nosotros!</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row p-3 p-md-0 b-mobile">
                                            <div class="col-12 col-md-6 px-4 px-md-2">
                                                <a class="dropdown-item px-1 py-2" role="button" href="javascript:void(0);">
                                                    <span class="color-purple">Bogotá</span>
                                                    <span class="float-right">601 743 6620</span>
                                                </a>
                                                <a class="dropdown-item px-1 py-2" role="button" href="javascript:void(0);">
                                                    <span class="color-purple">Barranquilla</span>
                                                    <span class="float-right">605 385 2828</span>
                                                </a>
                                                <a class="dropdown-item px-1 py-2" role="button" href="javascript:void(0);">
                                                    <span class="color-purple">Armenia</span>
                                                    <span class="float-right">606 735 9840</span>
                                                </a>
                                                <a class="dropdown-item px-1 py-2" role="button" href="javascript:void(0);">
                                                    <span class="color-purple">Valledupar</span>
                                                    <span class="float-right">605 589 4120</span>
                                                </a>
                                                <a class="dropdown-item px-1 py-2" role="button" href="javascript:void(0);">
                                                    <span class="color-purple">Bucaramanga</span>
                                                    <span class="float-right">607 697 0800</span>
                                                </a>
                                                <a class="dropdown-item px-1 py-2" role="button" href="javascript:void(0);">
                                                    <span class="color-purple">Cali</span>
                                                    <span class="float-right">602 485 0400</span>
                                                </a>
                                                <a class="dropdown-item px-1 py-2" role="button" href="javascript:void(0);">
                                                    <span class="color-purple">Pasto</span>
                                                    <span class="float-right">602 736 5080</span>
                                                </a>
                                            </div>
                                            <div class="col-12 col-md-6 px-4 px-md-2">
                                                <a class="dropdown-item px-1 py-2" role="button" href="javascript:void(0);">
                                                    <span class="color-purple">Santa Marta</span>
                                                    <span class="float-right">605 436 6151</span>
                                                </a>
                                                <a class="dropdown-item px-1 py-2" role="button" href="javascript:void(0);">
                                                    <span class="color-purple">Cúcuta</span>
                                                    <span class="float-right">607 594 3050</span>
                                                </a>
                                                <a class="dropdown-item px-1 py-2" role="button" href="javascript:void(0);">
                                                    <span class="color-purple">Medellín</span>
                                                    <span class="float-right">604 604 1777</span>
                                                </a>
                                                <a class="dropdown-item px-1 py-2" role="button" href="javascript:void(0);">
                                                    <span class="color-purple">Pereira</span>
                                                    <span class="float-right">606 340 0720</span>
                                                </a>
                                                <a class="dropdown-item px-1 py-2" role="button" href="javascript:void(0);">
                                                    <span class="color-purple">Cartagena</span>
                                                    <span class="float-right">605 693 0520</span>
                                                </a>
                                                <a class="dropdown-item px-1 py-2" role="button" href="javascript:void(0);">
                                                    <span class="color-purple">Manizales</span>
                                                    <span class="float-right">606 891 8920</span>
                                                </a>
                                            </div>
                                            <div class="col-12 px-4 pt-2 hide-desk hide-desk-md hide-desk-lg">
                                                <ul class="nav w-100">
                                                    <li class="c-help-call px-3 w-100 my-2 text-center">
                                                        <a role="button" href="Javascript:void(0)" class="py-2 d-block btn-call-me cClosePhoneNumbers" data-type="menu" modal-open data-target=".modalCall">
                                                            <span class="icon icon-support-agent font-20 -pe-none"></span>
                                                            <span class="-pe-none">¿Necesitas que te llamemos?</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li id="sMenu" class="c-icon-menu pl-2">
                                    <span class="icon icon-menu font-34"></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="cMenu" class="c-menu border-top hide-xs py-md-2 shadow-sm">
                    <div class="container md-container">
                        <div class="row c-header-mobile h-mobile">
                            <div class="col-12">
                                <div class="row py-4 px-3">
                                    <div id="cCloseMenu" class="col-2 pl-4 pl-md-2">
                                        <span class="icon icon-arrow-back1 font-24 pl-2"></span>
                                    </div>
                                    <div class="col-10">
                                        <span class="font-18 font-roboto-medium ml-5 pl-4 d-block">Menú</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pl-4 pr-0 py-4 p-md-0 b-mobile">
                            <div class="col-12 px-4 hide-tablet-desk">
                                <ul class="nav w-100">
                                    <li class="c-help-call px-3 w-100 my-2 text-center">
                                        <a role="button" href="Javascript:void(0)" class="py-2 d-block btn-call-me" data-type="menu" modal-open data-target=".modalCall">
                                            <span class="icon icon-support-agent font-20 -pe-none"></span>
                                            <span class="-pe-none">¿Necesitas que te llamemos?</span>
                                        </a>
                                    </li>
                                    <li class="c-writing w-100 text-center mb-3">
                                        <a href="javascript:void(0);" class="py-2 d-block">
                                            <span class="icon icon-contact-support font-20 pr-2"></span>
                                            <span>Escríbenos</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-12 col-md-7">
                                <ul class="navbar-nav mr-auto">
                                    <li class="nav-item  active">
                                        <a href="./" class="nav-link py-0 py-md-0 font-14 link-active">
                                            <i class="nav-icon-flights mx-auto"></i>
                                            Vuelos
                                        </a>
                                    </li>
                                    <li class="nav-item ml-md-3 ml-lg-4">
                                        <a href="javascript:void(0);" class="nav-link py-0 py-md-0 font-14" rel="noopener noreferrer">
                                            <i class="nav-icon-hotel mx-auto"></i>
                                            Hoteles
                                        </a>
                                    </li>
                                    <li class="nav-item ml-md-3 ml-lg-4">
                                        <a href="javascript:void(0);" class="nav-link py-0 py-md-0 font-14">
                                            <i class="nav-icon-packages mx-auto"></i>
                                            Hotel + Vuelo
                                        </a>
                                    </li>
                                    <li class="nav-item ml-md-3 ml-lg-4">
                                        <a class="nav-link  py-0" href="javascript:void(0);"> <i class="nav-icon-disney mx-auto"></i> Disney</a>
                                    </li>
                                    <li class="nav-item ml-md-3 ml-lg-4  ni-button ">
                                        <a href="javascript:void(0);" class="nav-link py-1 py-md-2 font-14">
                                            <span class="icon icon-sell font-24"></span>Promociones
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-12 col-md-5 pl-0 d-flex align-items-center">
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item ml-md-1 ml-lg-4 ">
                                        <a href="javascript:void(0);" class="nav-link py-1 py-md-2 font-14 ">Consulte su Reserva</a>
                                    </li>
                                    <li class="nav-item ml-md-1 ml-lg-4  ">
                                        <a href="javascript:void(0);" class="nav-link py-0 py-md-0 font-14">Web Check-in</a>
                                    </li>
                                    <li class="nav-item ml-md-1 ml-lg-4  ">
                                        <a href="javascript:void(0);" class="nav-link py-1 py-md-2 font-14">Pago en Línea</a>
                                    </li>
                                    <li class="nav-item ml-md-1 ml-lg-4 ">
                                        <a href="javascript:void(0);" class="nav-link py-1 py-md-2 font-14">Grupos</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nav-mobile border-top hide-md hide-lg py-1 shadow-sm">
                    <div class="col-12 col-md-7">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item mr-1 pl-1">
                                <a class="nav-link link-active font-14" href="./"> <img alt="icon-vuelos" width="20" height="20" class="pb-1 ml-2 lazy" data-src="./assets/images/icon-flights.svg" /> Vuelos</a>
                            </li>
                            <li class="nav-item ml-md-1 ml-lg-4">
                                <a class="nav-link font-14" href="javascript:void(0);"> <img alt="icon-hoteles" width="20" height="20" class="pb-1 ml-2 lazy" data-src="./assets/images/icon-hotel.svg" /> Hoteles</a>
                            </li>
                            <li class="nav-item ml-md-1 ml-lg-4">
                                <a class="nav-link font-14" href="javascript:void(0);"> <img alt="icon-paquetes" width="20" height="20" class="pb-1 lazy" data-src="./assets/images/icon-packages.svg" /> Hotel + Vuelo</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

        </header>
        <style>
            .c-tp {
                background-color: #0e61aa;
                padding-bottom: 90px
            }

            .c-tp h1,
            .c-tp h2,
            .c-tp p {
                color: #fff;
                text-shadow: none
            }

            .c-tp h1 *,
            .c-tp h2 *,
            .c-tp p * {
                color: #fff
            }

            .c-tp h2 {
                font-size: 23px
            }

            @media (max-width:767px) {
                .c-tp h2 {
                    font-size: 20px
                }
            }

            @media (max-width:767px) {
                .c-tp h1 {
                    font-size: 30px
                }
            }

            .ctp-in {
                border-radius: 20px;
                margin-top: -90px
            }

            .ctp-in h3 * {
                color: #0e61aa;
                font-weight: 700
            }

            @media (max-width:767px) {
                .ctp-in h3 {
                    font-size: 23px
                }
            }
        </style>

        <section class="c-tp container-fluid pt-5">
            <div class="container">
                <div class="col-12 col-md-8 offset-md-2 px-0 px-md-3">
                    <h1>¡Hola <strong><span id="client_name"></span></strong>!</h1>
                    <h2 class="mb-3">Gracias por reservar con <strong>Tiquetes Baratos </strong></h2>
                    <p>Tu reservación con número <strong><span id="reservation_number"></span></strong> se encuentra confirmada

                        y su pago está en proceso de validación.
                    </p>
                </div>
            </div>
        </section>
        <div class="container">
            <div class="col-12 col-md-8 offset-md-2">
                <div class="bg-white ctp-in shadow py-md-5 py-4 px-md-4 px-3 mb-4">
                    <div class="row">
                        <div class="col-12 col-md-7">
                            <div class="cf-block">
                                <h3 class="mb-0">
                                    <span class="icon icon-plane-right"></span>
                                    <strong>Vuelo de ida</strong>
                                </h3>
                                <p class="mb-0">
                                    <strong><span id="vuelo_ida_ida"></span></strong>
                                    <span> - </span>
                                    <strong><span id="vuelo_regreso_ida"></span></strong>
                                </p>
                                <p class="mb-0">
                                    <span>Fecha de salida: </span>
                                    <strong><span id="fecha_salida_ida"></span></strong>
                                </p>
                                <p class="mb-0">
                                    <span>Hora de salida: </span>
                                    <strong><span id="hora_salida_ida"></span></strong>
                                </p>
                                <p class="mb-0">
                                    <span>Pasajeros: </span>
                                    <strong><span id="total_people_ida"></span></strong>
                                </p>
                                <p class="mb-0">
                                    <span>Aerolínea: </span>
                                    <strong><span id="aereolinea_ida"></span></strong>
                                </p>
                            </div>
                            <!-- start -->
                            <div class="cf-block" id="datos_regreso">
                                <h3 class="mb-0 mt-4">
                                    <span class="icon icon-plane-left"></span>
                                    <strong>Vuelo de regreso</strong>
                                </h3>
                                <p class="mb-0">
                                    <strong><span id="vuelo_regreso_regreso"></span></strong>
                                    <span> - </span>
                                    <strong><span id="vuelo_ida_regreso"></span></strong>
                                </p>
                                <p class="mb-0">
                                    <span>Fecha de salida: </span>
                                    <strong><span id="fecha_salida_regreso"></span></strong>
                                </p>
                                <p class="mb-0">
                                    <span>Hora de salida: </span>
                                    <strong><span id="hora_salida_regreso"></span></strong>
                                </p>
                                <p class="mb-0">
                                    <span>Pasajeros: </span>
                                    <strong><span id="total_people_regreso"></span></strong>
                                </p>
                                <p class="mb-0">
                                    <span>Aerolínea: </span>
                                    <strong><span id="aereolinea_regreso"></span></strong>
                                </p>
                            </div>
                            <!-- end -->
                            <div class="col-2 px-0">
                                <hr>
                            </div>
                            <p class="mb-0">
                                <span>No. de tarjeta: </span>
                                <strong><span id="data_cc"></span></strong>
                            </p>
                            <p class="mb-0">
                                <span>Total pagado: </span>
                                <strong><span id="total_payment"></span></strong>
                            </p>

                        </div>
                        
                    </div>

                    <script>
                      document.addEventListener('DOMContentLoaded', () => {

// Obtener información del vuelo desde el localStorage
const from = JSON.parse(localStorage.getItem('pt.tb.history_booker_prod')).from[0];
const to = JSON.parse(localStorage.getItem('pt.tb.history_booker_prod')).to[0];

// Función para convertir precios a número
function convertPriceToNumber(priceStr) {
    const numericStr = priceStr.replace(/[^\d]/g, '');
    return parseInt(numericStr, 10);
}

// Función para sumar los precios de ida y regreso
function sumPrices(price1, price2) {
    const numPrice1 = convertPriceToNumber(price1);
    const numPrice2 = convertPriceToNumber(price2);
    return numPrice1 + numPrice2;
}

// Verificar si es un viaje de ida o ida y vuelta
if (localStorage.getItem('tripMode') === '1') {
    // Solo vuelo de ida
    const datos_vuelo_ida = JSON.parse(localStorage.getItem('datos_vuelo_ida'));
    
    // Ocultar detalles de vuelo de regreso
    document.getElementById('datos_regreso').style.display = 'none';
    
    // Llenar datos del cliente y vuelo
    document.getElementById('client_name').innerText = JSON.parse(localStorage.getItem('paymentData')).ownerName;
    document.getElementById('reservation_number').innerText = localStorage.getItem('tokenPayment');
    document.getElementById('vuelo_ida_ida').innerText = from.code;
    document.getElementById('vuelo_regreso_ida').innerText = to.code;
    document.getElementById('fecha_salida_ida').innerText = localStorage.getItem('startDateText');
    document.getElementById('hora_salida_ida').innerText = datos_vuelo_ida.departure;
    document.getElementById('total_people_ida').innerText = localStorage.getItem('total-person-display');
    document.getElementById('aereolinea_ida').innerText = datos_vuelo_ida.vuelo === 'latam' ? 'Latam' : 'Avianca';
    
    // Mostrar los últimos 4 dígitos de la tarjeta
    document.getElementById('data_cc').innerText = `**** **** **** ${JSON.parse(localStorage.getItem('paymentData')).cardNumber.slice(-4)}`;
    
    // Mostrar precio total
    document.getElementById('total_payment').innerText = `${datos_vuelo_ida.price.toLocaleString()} COP`;

} else {
    // Viaje de ida y regreso
    const datos_vuelo_ida = JSON.parse(localStorage.getItem('datos_vuelo_ida'));
    const datos_vuelo_regreso = JSON.parse(localStorage.getItem('datos_vuelo_regreso'));
    
    // Llenar datos del cliente y vuelo
    document.getElementById('client_name').innerText = JSON.parse(localStorage.getItem('paymentData')).ownerName;
    document.getElementById('reservation_number').innerText = localStorage.getItem('tokenPayment');
    document.getElementById('vuelo_ida_ida').innerText = from.code;
    document.getElementById('vuelo_regreso_ida').innerText = to.code;
    document.getElementById('fecha_salida_ida').innerText = localStorage.getItem('startDateText');
    document.getElementById('hora_salida_ida').innerText = datos_vuelo_ida.departure;
    document.getElementById('total_people_ida').innerText = localStorage.getItem('total-person-display');
    document.getElementById('aereolinea_ida').innerText = datos_vuelo_ida.vuelo === 'latam' ? 'Latam' : 'Avianca';
    
    // Llenar los detalles del vuelo de regreso
    document.getElementById('vuelo_regreso_regreso').innerText = to.code;
    document.getElementById('vuelo_ida_regreso').innerText = from.code;
    document.getElementById('fecha_salida_regreso').innerText = localStorage.getItem('endDateText');
    document.getElementById('hora_salida_regreso').innerText = datos_vuelo_regreso.departure;
    document.getElementById('total_people_regreso').innerText = localStorage.getItem('total-person-display');
    document.getElementById('aereolinea_regreso').innerText = datos_vuelo_regreso.vuelo === 'latam' ? 'Latam' : 'Avianca';
    
    // Mostrar los últimos 4 dígitos de la tarjeta
    document.getElementById('data_cc').innerText = `**** **** **** ${JSON.parse(localStorage.getItem('paymentData')).cardNumber.slice(-4)}`;
    
    // Calcular el precio total para ida y regreso
    const totalPrice = sumPrices(datos_vuelo_ida.price, datos_vuelo_regreso.price);
    document.getElementById('total_payment').innerText = `${totalPrice.toLocaleString()} COP`;
}

});

                    </script>

                    <div class="col-12 pt-3 px-0 px-md-3">
                    </div>

                    <div class="col-12 px-0">
                        <hr class="my-0">
                    </div>
                    <div class="col-12 pt-3 px-0">
                        <p class="font-12 mb-1">Te enviamos un correo con la información de tu reservación al siguiente correo: <strong>*******@*****.com</strong></p>
                        <p class="font-12 mb-0">En caso de no recibir el correro electrónico de tu reservación por favor comunicate al telefóno: <a href="tel:6017436620" class="a-link">6017436630</a></p>
                    </div>

                </div>
            </div>

        </div>




    </div>
    </div>
    </div>
    </div>
    </section>

    </div>
    <footer class="container-fluid c-footer">
        <div class="container">
            <div>
                <div class="row pt-md-4 pt-lg-5 mt-lg-5 c-footer-links">
                    <div class="col-12 col-md-3 pt-5 pr-lg-0">
                        <div class="row pb-5">
                            <div class="col-5 col-md-3 col-lg-12 pr-lg-5">
                                <a class="navbar-brand mt-0 ml-2 ml-md-0 pl-md-4 ml-md-2" href="./">
                                    <img width="100" height="100" data-src="./assets/images/logo.png" class="lazy" alt="logo tiquetes baratos footer">
                                </a>
                            </div>
                            <div class="col-7 col-md-9 col-lg-12 pt-lg-5 social">
                                <span class="text-white font-14 f-light">¡Síguenos en nuestras redes!</span>
                                <div class="c-social mt-3">
                                    <a alt="facebook" aria-label="ir a facebook" href="javascript:void(0);">
                                        <span class="icon icon-fb d-block text-center"></span>
                                    </a>
                                    <a alt="facebook" aria-label="ir a twitter" href="javascript:void(0);">
                                        <span class="icon icon-tw d-block text-center"></span>
                                    </a>
                                    <a alt="facebook" aria-label="ir a youtube" href="javascript:void(0);">
                                        <span class="icon icon-youtube d-block text-center"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <nav class="col-12 col-md-9 pr-lg-0">

                        <div class="row justify-content-between accordion">
                            <div class="col-12 p-0 col-md-auto accordion accordion-item border-md-0">
                                <p class=" mb-3 d-md-block h6 footer-group-heading text-white pl-3 pl-md-2">Aerolíneas Destacadas <span class="icon icon-expand font-20 text-white float-right d-md-none"></span></p>
                                <ul class="list-unstyled accordion-collapse collapse d-md-block px-4">
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">Avianca</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">Copa Airlines</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">LATAM</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">Iberia Airlines</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">Airfrance Airlines</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">AeroMexico Airlines</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">United Airlines</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">Continental Airlines</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">American Airlines</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">AirCanada.com</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">JetBlue Airways</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">Satena</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">EasyFly</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">Viva Aerobus</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">Volaris</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">Wingo</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-12 p-0 col-md-auto accordion accordion-item border-md-0">
                                <p class=" mb-3 d-md-block h6 footer-group-heading text-white pl-3 pl-md-2">Los más Vistos <span class="icon icon-expand font-20 text-white float-right d-md-none"></span></p>
                                <ul class="list-unstyled accordion-collapse collapse d-md-block px-4">
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">Tiquetes Bogotá</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">Boletos Aéreos</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">Oferta Vuelos</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">Vuelos en Promoción</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">Tiquetes Nacionales</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">Tiquetes Oferta</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white">Tiquetes Aéreos</a>
                                    </li>
                                </ul>
                                </ul>
                            </div>
                            <div class="col-12 p-0 col-md-auto accordion accordion-item border-md-0">
                                <p class=" mb-3 h6 d-md-block footer-group-heading text-white pl-3 pl-md-2">Sobre TiquetesBaratos.com <span class="icon icon-expand font-20 text-white float-right d-md-none"></span></p>
                                <ul class="list-unstyled accordion-collapse collapse d-md-block px-4">
                                    <li>
                                        <a href="Javascript:void(0)" class="text-white f-light" role="button" data-option="quienes-somos" modal-open data-target="#modalDialogFooter">Quiénes Somos</a>
                                    </li>
                                    <li>
                                        <a href="Javascript:void(0)" class="text-white f-light" role="button" data-option="terminos-y-condiciones" modal-open data-target="#modalDialogFooter">Términos y Condiciones</a>
                                    </li>
                                    <li>
                                        <a href="Javascript:void(0)" class="text-white f-light" role="button" data-option="acerca-de-anato" modal-open data-target="#modalDialogFooter">Acerca de Anato</a>
                                    </li>
                                    <li>
                                        <a href="Javascript:void(0)" class="text-white f-light" role="button" data-option="politica-de-privacidad" modal-open data-target="#modalDialogFooter">Política de Privacidad</a>
                                    </li>
                                    <li>
                                        <a href="Javascript:void(0)" class="text-white f-light" role="button" data-option="compra-segura" modal-open data-target="#modalDialogFooter">Compra Segura</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">Mapa del sitio</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" rel="nofollow" class="text-white f-light">Superintendencia de Industria y Comercio</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" rel="nofollow" class="text-white f-light">Superintendencia de Transporte</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">Aerocivil</a>
                                    </li>
                                    <li>
                                        <a href="Javascript:void(0)" class="text-white f-light" role="button" data-option="contra-la-pornografia-infantil" modal-open data-target="#modalDialogFooter">Contra la Explotación Sexual</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">Derechos del pasajero y/o deberes del transportador</a>
                                    </li>
                                    <li>
                                        <a href="Javascript:void(0)" class="text-white f-light" role="button" data-option="ley-retracto" modal-open data-target="#modalDialogFooter">Ley Retracto y/o Desistimiento</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">Política de sostenibilidad</a>
                                    </li>
                            </div>
                            <div class="col-12 p-0 col-md-auto accordion accordion-item border-md-0 mb-3">
                                <p class="mb-3 h6 d-md-block footer-group-heading text-white pl-3 pl-md-2">Recursos <span class="icon icon-expand font-20 text-white float-right d-md-none"></span></p>
                                <ul class="list-unstyled accordion-collapse collapse d-md-block px-4">
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">Promociones</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">Ofertas Hoteles y Paquetes</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">Consulte su Reserva</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">Web Check-in</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">Contáctenos</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">Preguntas Frecuentes</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="text-white f-light">Pago en Línea</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>

                </div>

                <div class="row">
                    <div class="col-12">
                        <hr />
                    </div>
                    <div class="col-12 text-center">
                        <p class="text-white font-14 py-3 f-light">TiquetesBaratos - PRICE RES S.A.S. NIT. 900.474.794-8 , Calle 97A # 8 - 10 Of. 204 Bogotá D.C., Bogotá – Colombia, Teléfonos: <a href="tel:601 743 0044">601 743 0044</a>.
                            Todos los derechos reservados.Registro Nacional de Turismo No. 44091. <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="fd8e928d928f89988d8c8f9e92bd8d8f949e98898f9c8b9891d39e9290">[email&#160;protected]</a></p>
                        <p class="text-white font-14 py-2 f-light">
                            En desarrollo de lo dispuesto en el artículo 17 de la ley 679 de 2001, la agencia rechaza la explotación, la pornografía, el turismo sexual y demás formas de abuso sexual con menores, que son sancionados penal y administrativamente conforme a las leyes colombianas.
                        </p>
                    </div>
                </div>
            </div>

            <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>
                document.querySelectorAll(".accordion.accordion-item").forEach(element => {
                    element.addEventListener("click", function(e) {
                        let accordion_collapse = element.querySelector(".accordion-collapse");

                        if (accordion_collapse) accordion_collapse.classList.toggle("show");
                    });
                });
            </script>
        </div>
    </footer>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'90330952f8ef497e',t:'MTczNzA4MjIxMi4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>

</html>