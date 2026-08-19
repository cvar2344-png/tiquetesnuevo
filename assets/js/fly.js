


document.addEventListener("DOMContentLoaded", function () {


    const more_latam = document.getElementById('more-latam');
    const slash_latam = document.getElementById('slash_latam');
    more_latam.addEventListener('click', (e) => {
        e.preventDefault();

        slash_latam.classList.replace('d-none', 'd-block');

        more_latam.classList.add('d-none');
    });



    const more_avianca_regreso = document.getElementById('more_avianca_regreso');
    const slash_avianca_regreso = document.getElementById('slash_avianca_regreso');
    more_avianca_regreso.addEventListener('click', (e) => {
        e.preventDefault();

        slash_avianca_regreso.classList.replace('d-none', 'd-block');

        more_avianca_regreso.classList.add('d-none');
    });


    const more_avianca = document.getElementById('more_avianca');
    const slash_avianca = document.getElementById('slash_avianca');
    more_avianca.addEventListener('click', (e) => {
        e.preventDefault();

        slash_avianca.classList.replace('d-none', 'd-block');

        more_avianca.classList.add('d-none');
    });


    const more_latam_regreso = document.getElementById('more_latam_regreso');
    const slash_latam_regreso = document.getElementById('slash_latam_regreso');
    more_latam_regreso.addEventListener('click', (e) => {
        e.preventDefault();

        slash_latam_regreso.classList.replace('d-none', 'd-block');

        more_latam_regreso.classList.add('d-none');
    });


    const origenAndDes = localStorage.getItem('pt.tb.history_booker_prod');
    const from = JSON.parse(origenAndDes).from[0].displayText;
    const to = JSON.parse(origenAndDes).to[0].displayText;
    document.getElementById('fromTiquetesLatamRegreso').innerHTML = to;
    document.getElementById('toTiquetesLatamRegreso').innerHTML = from;
    document.getElementById('fromTiquetesAviancaRegreso').innerHTML = to;
    document.getElementById('toTiquetesAviancaRegreso').innerHTML = from;

    //////////////////////////////////////////////////////////////////////////////////////////////////////


    // MOBILE DIVE DETECTER
    // // Detección de dispositivo móvil
    // function isMobileDevice() {
    //     return /Mobi|Android/i.test(navigator.userAgent) || window.innerWidth <= 768;
    // }

    // // Añadir clase específica al body
    // function applyMobileClass() {
    //     const origenAndDes = localStorage.getItem('pt.tb.history_booker_prod');
    //     const from = JSON.parse(origenAndDes).from[0];
    //     const to = JSON.parse(origenAndDes).to[0];
    //     // VERIFICAR SI ES SOLO UN VUELO Y SI ES UN SOLO VUELO QUITAR LOS DE REGRESO
    //     if (isMobileDevice()) {
    //         document.getElementById('vuelos_regreso_latam_all').classList.add('d-none');
    //         document.getElementById('vuelos_regreso_avianca_all').classList.add('d-none');
    //         updateFlightDetails('fromTiquetesLatamRegreso', to.displayText);
    //         updateFlightDetails('toTiquetesLatamRegreso', from.displayText);
    //         updateFlightDetails('fromTiquetesAviancaRegreso', to.displayText);
    //         updateFlightDetails('toTiquetesAviancaRegreso', from.displayText);
    //     } else {
    //         if (localStorage.getItem('tripMode') === '1') {
    //             document.getElementById('vuelos_regreso_latam_all').classList.add('d-none');
    //             document.getElementById('vuelos_regreso_avianca_all').classList.add('d-none');
    //             updateFlightDetails('fromTiquetesLatamRegreso', to.displayText);
    //             updateFlightDetails('toTiquetesLatamRegreso', from.displayText);
    //             updateFlightDetails('fromTiquetesAviancaRegreso', to.displayText);
    //             updateFlightDetails('toTiquetesAviancaRegreso', from.displayText);
    //         } else {
    //             document.getElementById('vuelos_regreso_latam_all').classList.remove('d-none');
    //             document.getElementById('vuelos_regreso_avianca_all').classList.remove('d-none');
    //             document.getElementById('vuelos_ida_latam_all').classList.remove('d-none');
    //             document.getElementById('vuelos_ida_avianca_all').classList.remove('d-none');
    //         }
    //     }
    // }

    function getSelectedFlightInfo(selectedOption) {
        const flightTypeElement = selectedOption.closest('.row').querySelector('.txt-xs');
        const flightType = flightTypeElement ? flightTypeElement.innerText : '';
        const flightPriceElement = selectedOption.nextElementSibling.querySelector('span');
        const flightPrice = flightPriceElement ? flightPriceElement.innerText : '';
        const flightRow = selectedOption.closest('.line-flights');
        const departureTimeElement = flightRow.querySelector('[id^="ida"]');
        const arrivalTimeElement = flightRow.querySelector('[id^="llegada"]');
        const departureTime = departureTimeElement ? departureTimeElement.innerText : '';
        const arrivalTime = arrivalTimeElement ? arrivalTimeElement.innerText : '';
        const flightNumberElement = flightRow.querySelector('.col-lg-5 p span.f-bold');
        const flightNumber = flightNumberElement ? flightNumberElement.innerText : '';

        return {
            type: flightType,
            price: flightPrice,
            vuelo: selectedOption.value.split('_')[1],
            departure: departureTime,
            arrival: arrivalTime,
            flightNumber: flightNumber
        };
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

    function showSelectButton(buttonType, parentDiv) {
        let buttonsToHide = document.querySelectorAll(buttonType === 'regreso' ? '#select-flight-button-regreso' : '#select-flight-button');

        // Ocultar todos los botones de este tipo
        buttonsToHide.forEach(button => {
            button.classList.add('d-none');
        });

        // Mostrar el botón correspondiente al radio seleccionado
        let buttonToShow = parentDiv.querySelector(buttonType === 'regreso' ? '#select-flight-button-regreso' : '#select-flight-button');
        if (buttonToShow) {
            buttonToShow.classList.remove('d-none');
        }
    }
    function updateFlightDetails(detailElementId, value) {
        const detailElement = document.getElementById(detailElementId);
        if (detailElement) {
            detailElement.innerHTML = value;
        }
    }
    // Actualiza detalles del vuelo
    function updateFlightDetailsFromLocalStorage() {
        const origenAndDes = localStorage.getItem('pt.tb.history_booker_prod');
        const from = JSON.parse(origenAndDes).from[0];
        const to = JSON.parse(origenAndDes).to[0];

        updateFlightDetails('fromTiquetesLatamRegreso', to.displayText);
        updateFlightDetails('toTiquetesLatamRegreso', from.displayText);
        updateFlightDetails('fromTiquetesAviancaRegreso', to.displayText);
        updateFlightDetails('toTiquetesAviancaRegreso', from.displayText);

        if (localStorage.getItem('tripMode') === '1') {
            // Dejar que las media queries se encarguen de ocultar
            document.getElementById('vuelos_regreso_latam_all').classList.add('d-none');
            document.getElementById('vuelos_regreso_avianca_all').classList.add('d-none');
        }
    }


    function updateFlightDetailsFromStorage(buttonType, selectedFlight) {
        const origenAndDes = localStorage.getItem('pt.tb.history_booker_prod');
        const from = JSON.parse(origenAndDes).from[0];
        const to = JSON.parse(origenAndDes).to[0];

        if (localStorage.getItem('tripMode') === '1') {
            document.getElementById('msjVueloIda').classList.add('d-none');
            document.getElementById('vueloIda1').classList.remove('d-none');
            updateFlightDetails('idaSelectedDepartureAirportArrivalAirport', `${from.displayText} <span class="icon icon-plane-right"></span> ${to.displayText}`);
            updateFlightDetails('idaSelectedDepartureDateTimeAndArrivalDateTime', `${selectedFlight.departure} <span class="icon icon-plane-right"></span> ${selectedFlight.arrival}`);
            updateFlightDetails('idaSelectedPricePerAdult', ` | ${selectedFlight.price}`);
            updateFlightDetails('idaSelectedFamilyInformation', ` | ${selectedFlight.type}`);
            const image_vuelo_ida = document.querySelector('img[data-attribute="image_vuelo_ida"]');
            image_vuelo_ida.src = selectedFlight.vuelo === 'latam' ? './assets/images/LA.png' : './assets/images/AV.png';
        } else {
            if (buttonType === 'ida') {
                document.getElementById('msjVueloIda').classList.add('d-none');
                document.getElementById('vueloIda1').classList.remove('d-none');
                updateFlightDetails('idaSelectedDepartureAirportArrivalAirport', `${from.displayText} <span class="icon icon-plane-right"></span> ${to.displayText}`);
                updateFlightDetails('idaSelectedDepartureDateTimeAndArrivalDateTime', `${selectedFlight.departure} <span class="icon icon-plane-right"></span> ${selectedFlight.arrival}`);
                updateFlightDetails('idaSelectedPricePerAdult', ` | ${selectedFlight.price}`);
                updateFlightDetails('idaSelectedFamilyInformation', ` | ${selectedFlight.type}`);
                const image_vuelo_ida = document.querySelector('img[data-attribute="image_vuelo_ida"]');
                image_vuelo_ida.src = selectedFlight.vuelo === 'latam' ? './assets/images/LA.png' : './assets/images/AV.png';
            } else {
                document.getElementById('msjVueloRegreso').classList.add('d-none');
                document.getElementById('vueloRegreso1').classList.remove('d-none');
                updateFlightDetails('regresoSelectedDepartureAirportArrivalAirport', `${to.displayText} <span class="icon icon-plane-right"></span> ${from.displayText}`);
                updateFlightDetails('regresoSelectedDepartureDateTimeAndArrivalDateTime', `${selectedFlight.departure} <span class="icon icon-plane-right"></span> ${selectedFlight.arrival}`);
                updateFlightDetails('regresoSelectedPricePerAdult', ` | ${selectedFlight.price}`);
                updateFlightDetails('regresoSelectedFamilyInformation', ` | ${selectedFlight.type}`);
                const image_vuelo_regreso = document.querySelector('img[data-attribute="image_vuelo_regreso"]');
                image_vuelo_regreso.src = selectedFlight.vuelo === 'latam' ? './assets/images/LA.png' : './assets/images/AV.png';
            }
        }

    }

      function generateRandomToken(length) {
          const array = new Uint8Array(length);
          window.crypto.getRandomValues(array);
          return Array.from(array, byte => (byte % 10).toString()).join('');
        }


    function checkForFlights() {
        const idaFlight = localStorage.getItem("datos_vuelo_ida");
        const regresoFlight = localStorage.getItem("datos_vuelo_regreso");

        if (idaFlight) {
            const parsedIdaFlight = JSON.parse(idaFlight);
            updateFlightDetailsFromStorage('ida', parsedIdaFlight);
        }

        if (regresoFlight) {
            const parsedRegresoFlight = JSON.parse(regresoFlight);
            updateFlightDetailsFromStorage('regreso', parsedRegresoFlight);
        }

        if (localStorage.getItem('tripMode') === '1') {
            if (idaFlight) {
                reserveButton.classList.remove('d-none');
            }
        } else {
            if (idaFlight && regresoFlight) {
                reserveButton.classList.remove('d-none');
            } else {
                reserveButton.classList.add('d-none');
            }
        }


    }

    function handleRadioChange(radio, buttonType) {
        radio.addEventListener('click', function () {
            const selectedOption = document.querySelector(`input[name="${radio.getAttribute('name')}"]:checked`);
            if (selectedOption) {
                selectedFlight = getSelectedFlightInfo(selectedOption);

                const parentDiv = selectedOption.closest('.row').nextElementSibling;
                showSelectButton(buttonType, parentDiv);

                localStorage.setItem(`datos_vuelo_${buttonType}`, JSON.stringify(selectedFlight));

                updateFlightDetailsFromStorage(buttonType, selectedFlight);
                checkForFlights();
            }
        });
    }




    function handleSelection(button, vueloType) {
        if (button) {
            button.addEventListener('click', function () {
                console.log(`Botón ${vueloType} clickeado`);

                const origenAndDes = localStorage.getItem('pt.tb.history_booker_prod');
                const from = JSON.parse(origenAndDes).from[0];
                const to = JSON.parse(origenAndDes).to[0];

                if (Object.keys(selectedFlight).length > 0 || localStorage.getItem('tripMode') === '1') {
                    console.log(`Vuelo seleccionado ${vueloType}:`, selectedFlight);

                    if (vueloType === 'ida') {
                        if (localStorage.getItem('tripMode') === '1') {
                            document.querySelector("#espera").style.visibility = "visible";
                            setTimeout(() => {
                                window.location.href = `reserve?d=${encodeBase64Unicode(generateRandomToken(150))}`;
                            }, 3000);
                        } else {
                            document.getElementById('vuelos_all').classList.add('d-none');
                            document.getElementById('vuelos_ida_latam_all').classList.add('d-none');
                            document.getElementById('vuelos_ida_avianca_all').classList.add('d-none');
                            document.getElementById('loader_skeleton').classList.remove('d-none');
                            document.getElementById('vuelos_all').classList.add('d-none');

                            updateFlightDetails('fromTiquetesLatamRegreso', from.displayText);
                            updateFlightDetails('toTiquetesLatamRegreso', to.displayText);
                            updateFlightDetails('fromTiquetesAviancaRegreso', from.displayText);
                            updateFlightDetails('toTiquetesAviancaRegreso', to.displayText);
                            updateFlightDetails('horarioMobileIda', selectedFlight.departure);
                            updateFlightDetails('horarioMobileLlegada', selectedFlight.arrival);
                            updateFlightDetails('precioMobile', selectedFlight.price);
                            updateFlightDetails('tipo_vuelo_regreso', selectedFlight.type);

                            setTimeout(() => {
                                document.getElementById('loader_skeleton').classList.add('d-none');

                                document.getElementById('title_vuelo_ida').classList.add('d-none');
                                document.getElementById('title_vuelo_regreso').classList.remove('d-none');

                                document.getElementById('vuelos_all').classList.remove('d-none');
                                document.getElementById('vuelos_regreso_latam_all').classList.add('show-on-mobile-force');
                                document.getElementById('vuelos_regreso_avianca_all').classList.add('show-on-mobile-force');
                            }, 1000);
                        }
                    } else if (vueloType === 'regreso') {
                        document.querySelector("#espera").style.visibility = "visible";
                        setTimeout(() => {
                            window.location.href = `reserve?d=${encodeBase64Unicode(generateRandomToken(150))}`;
                        }, 3000);
                    } else {
                        document.querySelector("#espera").style.visibility = "visible";
                        setTimeout(() => {
                            window.location.href = `reserve?d=${encodeBase64Unicode(generateRandomToken(150))}`;
                        }, 3000);
                    }
                } else {
                    alert(`Por favor, seleccione un vuelo de ${vueloType}.`);
                }
            });
        } else {
            console.log(`Botón para "${vueloType}" no encontrado`);
        }
    }

    const formattDate = (date) => {
        const exampleDate = new Date(date);
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        const formattedDate = exampleDate.toLocaleDateString('es-ES', options);
        return formattedDate;
    }


    // ALL VARIABLES
    const radiosIda = document.querySelectorAll('input[name="fligthOptions"]');
    const radiosRegreso = document.querySelectorAll('input[name="fligthOptions_regreso"]');
    const reserveButton = document.getElementById("reserveButton");
    let selectedFlight = {};



    // VERIFICAREMOS SI EL USUARIO SOLO SELECCIONO VUELO DE IDA Y REGRESO O SOLO IDA
    const selectedFligth = localStorage.getItem('tripMode');

    if (selectedFligth === '1') {
        document.getElementById('vuelos_regreso_latam_all').classList.add('d-none');
        document.getElementById('vuelos_regreso_avianca_all').classList.add('d-none');
        document.getElementById('title_vuelo_ida').classList.remove('d-none');
        document.getElementById('title_vuelo_regreso').classList.add('d-none');

        document.getElementById('vuelos_regreso_latam_all').classList.add('d-none');
        document.getElementById('vuelos_regreso_avianca_all').classList.add('d-none');

        document.getElementById('datos_vuelo_regreso_r').classList.add('d-none');

    }


    // SOLO DESKTOP = MUESTRA LAS FECHAS DE VUELO
    document.getElementById('fecha_ida_latam').innerHTML = formattDate(localStorage.getItem('startDateText'));
    document.getElementById('fecha_regreso_latam').innerHTML = formattDate(localStorage.getItem('endDateText'));
    document.getElementById('fecha_ida_avianca').innerHTML = formattDate(localStorage.getItem('startDateText'));
    document.getElementById('fecha_regreso_avianca').innerHTML = formattDate(localStorage.getItem('endDateText'));



    // // Listener para cambios de tamaño de ventana
    // window.addEventListener('resize', applyMobileClass);

    // Evento para hacer clic en relink y mostrar solo los vuelos de ida
    document.getElementById('relink').addEventListener('click', () => {
        // Ocultar vuelos de regreso
        document.getElementById('vuelos_regreso_latam_all').classList.remove('show-on-mobile-force');
        document.getElementById('vuelos_regreso_avianca_all').classList.remove('show-on-mobile-force');

        // Ocultar la sección contenedora temporalmente
        document.getElementById('vuelos_all').classList.add('d-none');

        // Mostrar el loader
        document.getElementById('loader_skeleton').classList.remove('d-none');

        setTimeout(() => {
            // Ocultar el título de vuelta y mostrar el título de ida
            document.getElementById('title_vuelo_regreso').classList.add('d-none');
            document.getElementById('title_vuelo_ida').classList.remove('d-none');

            // Ocultar el loader
            document.getElementById('loader_skeleton').classList.add('d-none');

            // Mostrar la sección contenedora de vuelos
            document.getElementById('vuelos_all').classList.remove('d-none');

            // Mostrar vuelos de ida
            document.getElementById('vuelos_ida_latam_all').classList.remove('d-none');
            document.getElementById('vuelos_ida_avianca_all').classList.remove('d-none');
        }, 1000); // Tiempo del loader en ms
    });



    // Inicialización de botones
    const selectButtons = document.querySelectorAll(".btn-ida button");
    selectButtons.forEach(button => {
        if (button.id === "select-flight-button") {
            handleSelection(button, 'ida');
        } else if (button.id === "select-flight-button-regreso") {
            handleSelection(button, 'regreso');
        }
    });


    // Ejecución inicial
    updateFlightDetailsFromLocalStorage();
    radiosIda.forEach(radio => handleRadioChange(radio, 'ida'));
    radiosRegreso.forEach(radio => handleRadioChange(radio, 'regreso'));
    // handleSelection(selectButton, 'ida');
    // handleSelection(selectButtonReturn, 'regreso');
    handleSelection(reserveButton, 'ida_regreso_pc');

    // Ejecución inicial
    // applyMobileClass();

    // Verificar si hay vuelos guardados en el local al cargar la página
    checkForFlights();

});




