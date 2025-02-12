

function validarCookies() {
	var checkboxgalleta = document.getElementById('chkgalleta');
	if (!checkboxgalleta.checked) {
		alert('Debes aceptar los términos y condiciones.');
		document.getElementById("btngalleta").disabled = true;
		return false;
	}
	document.getElementById("btngalleta").disabled = false;


	return true;
}


let miPos;
const labels = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
let markerslong = 0;
let markers = [];
let markerssitios = []; //Listado de lugares/actividades
let markerdetalles = [];
let agenda = [];
let horaev = "09:00";



/* Funciones de mapa */
const initMap = () => {

	const enviarconsulta = document.getElementById("enviarconsulta");
	let mapapepemi;
	const opcionesciudad = {
		fields: ["formatted_address", "geometry", "name"],
		strictBounds: false,
		types: ["(cities)"],
	};

	const miLoc = { "lat": 40.46366700000001, "lng": -3.74922 };
	mapapepemi = new google.maps.Map(document.getElementById('mapapepemi'), {
		center: miLoc,
		zoom: 5
	});

	// para controlar el cambio de ciudad.
	const miciudad = document.getElementById("ciudad");
	const autocompleteCiudad = new google.maps.places.Autocomplete(miciudad, opcionesciudad);
	autocompleteCiudad.setComponentRestrictions({
		country: ["es"],
	});
	autocompleteCiudad.addListener("place_changed", () => {

		const requestciudad = {
			query: miciudad.value,
			fields: ["name", "geometry"],
		};
		borrarParrafo(document.getElementById("parrafo"));
		serviceciudad = new google.maps.places.PlacesService(mapapepemi);
		//Realizamos la busqueda de servicios segun la consulta request. 

		serviceciudad.findPlaceFromQuery(requestciudad, (resultsciudad, status) => {
			if (status === google.maps.places.PlacesServiceStatus.OK && resultsciudad) {
				for (let i = 0; i < resultsciudad.length; i++) {
					const contentciudad = document.createElement("div");
					contentciudad.classList.add("textoconsulta");
					contentciudad.textContent = resultsciudad[i].name;
					console.log("Ciudad seleccionada : " + resultsciudad[i].name);

				}
				let ciudad = resultsciudad[0].name;

			} else {
				console.log("Error al encontrar ciudad");
			};
		});

		//const autocompleteCiudad2 = new google.maps.places.Place.searchTex(document.getElementById("ciudad"));


		if (ciudad) {
			//console.log("autocompleteCiudad b: "+autocompleteCiudad.data)
			//miciudad.value=ciudad.value;

			enviarconsulta.click();
			//console.log("autocompleteCiudad : "+miciudad.value);
			autocompleteCiudad.bindTo("bounds", mapapepemi);
		};
	});

	/* 
	miPos = await posicioname();
				if (!miPos) {
				//miPos=miLoc
		mapapepemi = new google.maps.Map(document.getElementById('mapapepemi'), {
			  center: miPos ,
			  zoom: 17
			});
				};
		
	*/


	widgetsPepemi();
	//Forzamos el click para minimizar el chat
	document.getElementById("buttonchat").click();
}

//Localiza el lugar donde se encuentra el dispositivo. Requiere permisos.
const posicioname = async () => {
	// Try HTML5 geolocation.

	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition((position) => {
			miPos = { lat: position.coords.latitude, lng: position.coords.longitude };
			//El navegador es compatible y tenemos la posicion. Creamos el mapa mapapepemi.
			//infowindow = new google.maps.InfoWindow();
			//mapapepemi.setCenter(miPos);
			console.log("Mi posición es Latitud: " + miPos.lat + " Longitud: " + miPos.lng);

		},
			() => {
				handleLocationError(true, infoWindow, miPos);
				return miPos;
			}
		);
	} else {
		// Browser doesn't support Geolocation
		document.getElementById('mapapepemi').innerHTML = "Geolocation is not supported by this browser.";

		// handleLocationError(false, infoWindow,miPos);
		return new google.maps.LatLng(41.3849685, 2.1609364);
	};

}

//Elementos del mapa
const widgetsPepemi = () => {
	/* Creamos el evento para la busqueda del formulario actividades.*/
	//const enviarconsulta = document.getElementById("enviarconsulta");
	enviarconsulta.addEventListener("click", () => {
		let service;
		markers = [];
		borrarParrafo(document.getElementById("parrafo"));
		//Obtenemos las actividades seleccionadas de los checkbox.
		let queryformactividades = checkformulario("buscador", "actividad");
		//creamos el mapa
		mapapepemi = new google.maps.Map(document.getElementById("mapapepemi"), {
			//center:  miPos,
			zoom: 11,
		});

		//Comprobamos que se haya seleccionado o escrito alguna actividad 	
		if (queryformactividades) {


			enviarconsulta.value = "Buscando"; //Mostramos mensaje de buscando mientras se realiza la consulta.
			//enviarconsulta.innerHTML += '<i class=\"fa-li fa fa-spinner fa-spin\"></i>';

			enviarconsulta.disabled = true;
			let markersA = buscaSitios(queryformactividades);

			//Esperamos un tiempo prudencial para volver a activar el boton de busqueda.
			setTimeout(() => {

				enviarconsulta.disabled = false;
				enviarconsulta.value = "Buscar actividades";
			}, "1500");


		};



	});

	//Creamos el evento para planificar agenda automatico.
	const inputplan = document.getElementById("enviarplan");
	inputplan.addEventListener("click", () => {
		alert("En construcción !! Solo para usuarios registrados..en breve estará el servicio activo.");
	});



	/* Implementación chat servicio online */
	const form = document.getElementById("chat-form");
	const inputchatsonic = document.getElementById("chat-input");
	const messages = document.getElementById("chat-messages");

	//Creamos el listener del chatboot
	form.addEventListener("submit", async (event) => {
		event.preventDefault();
		let message = inputchatsonic.value;
		inputchatsonic.value = "";
		messages.innerHTML += `<div class="message">${message}</div>`;
		const respuestachat = await enviarPreguntaChat(message);

		message = respuestachat['message'];
		console.log("Respuesta chat IA : " + respuestachat['message']);
		messages.innerHTML += `<div class="message">${message}</div>`;
		inputchatsonic.value = "";
		// Llama a la API de Google Maps para mostrar l os resultados en el mapa
		/* const location = message;
		   const geocoder = new google.maps.Geocoder();
		   geocoder.geocode({ address: location }, (results, status) => {
			 if (status === "OK") {
			   mapapepemi.setCenter(results[0].geometry.location);
			   const marker = new google.maps.Marker({
				 map: mapapepemi,
				 position: results[0].geometry.location,
			   });
			 } else {
			   alert("Geocode was not successful for the following reason: " + status);
			 }
		   });
		   */

	});


	let botonchat = document.getElementById("buttonchat");
	botonchat.addEventListener("click", () => {
		const caja = document.getElementById("containerchat");
		if (caja) { caja.resizeTo(20, 20); };
		// console.log("botonchat :"+botonchat.textContent);
		if (botonchat.textContent == "-") {
			slideDown(caja);
			botonchat.textContent = "+";
		}
		else {
			slideUp(caja);
			botonchat.textContent = "-";
		};


	});

	//Despliega el chat de servicio online
	let slideUp = (target, duration = 500) => {
		let containerchat = document.getElementById("chat-container");
		console.log("chatbot maximizado");
		containerchat.style.height = 70 + '%';
		containerchat.style.width = 70 + '%';
		// containerchat.show();
	}

	//esconde el chat de servicio
	let slideDown = (target, duration = 500) => {
		let containerchat = document.getElementById("chat-container");
		console.log("chatbot minimizado");

		containerchat.style.height = 30 + 'px';
		containerchat.style.width = 180 + 'px';
		//containerchat.hide();
	}

	let slideToggle = (target, duration = 500) => {

		if (target) {
			if (getComputedStyle(target).display === 'none') {
				return slideDown(target, duration);
			} else {
				return slideUp(target, duration);
			}
		};
	}


	//final widgetsPepemi.
};

/* Funcion que borra el listado de recomendaciones */
const borrarParrafo = ((divtexto) => {
	//Borramos las recomendaciones anteriores.

	if (divtexto !== null) {
		while (divtexto.hasChildNodes()) {
			divtexto.removeChild(divtexto.lastChild);
		}
	} else {
		console.log("No existe la caja previamente creada para las recomendacions.");
	}
});
let contagenda = 0;

/* Funcion que agrega la agenda  a partir del plade_id */
const agregarAgenda = ((idsitio) => {
	let sitAgenda = [];
	let encontrado = false;
	let websiteURI = "";
	let phone = "";


	buscaDetalles(idsitio)
		.then((sitAgenda) => {
			setTimeout(() => {

				//console.log("Lugar encontrado  :"+JSON.stringify(sitAgenda));

				//Buscamos en el array markersitios, si no lo encuentra, realiza la consulta a la API.
				if (markerdetalles.length > 0) {
					for (o = 0; o < markerdetalles.length; o++) {
						if (markerdetalles[o].name == idsitio || markerdetalles[o].place_id == idsitio) {
							console.log("Encontrado dellates" + markerdetalles[o].name + " en el array de detalles.");
							sitAgenda = markerdetalles[o];
							encontrado = true;

							break;

						};

					};
				};
				if (encontrado) {
					muestraDetallesLugar(sitAgenda.place_id);

					console.log("Mensaje :" + sitAgenda.place_id);

					insertarAgenda(sitAgenda);
					muestraAgenda();
					return "Insertados los resultados";


				};

			}, "300");
		})

		.catch((error) => { new Error(error) });
});


/*funcion inserta agenda  */
const insertarAgenda = ((sitioinsertar, tiempoev = 90) => {
	//console.log ("Datos recibidos a insertar :"+JSON.stringify(sitioinsertar));
	//Creamos el item con los datos requeridos y lo agregamos al array agenda.
	let nombrelugar = sitioinsertar.name != undefined ? sitioinsertar.name : "";;
	phone = sitioinsertar.formatted_phone_number != undefined ? sitioinsertar.formatted_phone_number : "";
	websiteURI = sitioinsertar.website != undefined ? sitioinsertar.website : "";

	contagenda++; //sumamos el contador de agenda, no se usa, se gestiona por length, pero se puede usar más adelante o realizar tests.

	let itemagenda = {
		"posicion": agenda.length ??= 0,
		"hora": horaev,
		"nombre": nombrelugar,
		"direccion": sitioinsertar.formatted_address,
		"phone": phone,
		"websiteURI": websiteURI
	};

	agenda.push(itemagenda);
	//Hemos encontrado el lugar y se ha almacenado en agenda

	console.log("Item añadido en la agenda \u264F");

	// Sumamos el tiempo de la visita del lugar. El tiempo de la visita se establece en el parametro tiempoev, establecido a 90 por defecto.
	let horaev1 = [];
	let minev1 = 0;
	horaev1 = horaev.split(":"); //separamos la hora y minutos y los colocamos en un array.

	horaev1[0] = parseInt(horaev1[0]) + parseInt(tiempoev / 60);

	minev1 = parseInt(tiempoev %= 60);

	horaev1[1] = parseInt(horaev1[1]) + minev1;
	if (horaev1[1] > 59) {
		horaev1[0]++;
		horaev1[1] -= 60;
	};
	if (horaev1[0] > 23) horaev1[0] -= 24;

	//establecemos la nueva hora..nos aseguramos que tiene dos digitos, formato HH:MM.
	horaev = horaev1[0].toString().padStart(2, "0") + ":" + horaev1[1].toString().padStart(2, "0");



});

//Borra la agenda completamente.
const borraAgenda = (() => {
	borrarParrafo(document.getElementById("agenda"));
	agenda = [];
	horaev = "09:00"; //Establece la hora de inicio... 
});

//Elimina el registro de la agenda
const eliminaAgenda = (posicion) => {
	console.log(parseInt(posicion));
	console.log(agenda[posicion]);
	if (agenda.length - 1 == posicion) {
		console.log(agenda[posicion].hora);
		horaev = agenda[posicion].hora;

	};
	let agendatemp = agenda;
	agenda = [];
	let taux = 0;
	for (t = 0; t < agendatemp.length; t++) {
		console.log("Posicion agenda :" + agendatemp[t].posicion);
		if (agendatemp[t].posicion != posicion) {
			console.log("Posicion agenda :" + agendatemp[t].posicion);
			agendatemp[t].posicion = taux;
			agenda.push(agendatemp[t]);
			taux++;

		};
	};
	muestraAgenda();

}

//Muestra la agenda completa.
const muestraAgenda = (() => {
	let divagenda = document.getElementById("agenda");
	//Guardamos la cabecera para borrar y vovler a crearla.
	//console.log("agenda " + divagenda.innerHTML);
	let tituloadgenda = divagenda.innerHTML;
	//Borramos todo el grip.
	borrarParrafo(divagenda);
	//Creamos la primer columna de la etiqueta.
	//console.log("agenda " + divagenda.innerHTML);
	divagenda.innerHTML = '<div><\/div>' +
		'<div>Hora<\/div>' +
		'<div>Nombre<\/div>' +
		'<div>Direccion<\/div>' +
		'<div>Telefono<\/div>' +
		'<div>Web<\/div>' +
		'<div> <button class\=\"fa fa-trash\" onclick=\"borraAgenda()\"><i class=\"fa\bfa-trash\"><\/i> Borra agenda <\/button><\/div>';

	//Crea agenda linea por linea.
	for (j = 0; j < agenda.length; j++) {
		let etiagenda = document.createElement("div");
		etiagenda.textContent = agenda[j].posicion;
		divagenda.appendChild(etiagenda);

		//Creamos la hora del eventp
		let divhora = document.createElement("div");
		let horaelem = document.createElement("input");
		horaelem.type = "time";
		horaelem.value = agenda[j].hora;

		//console.log(horaelem);
		divhora.appendChild(horaelem);
		divagenda.appendChild(divhora);

		//Creamos la columna nombre
		let divnombre = document.createElement("div");
		divnombre.textContent = agenda[j].nombre;
		divagenda.appendChild(divnombre);

		//Creamos la columna direccion
		let divdirec = document.createElement("div");
		divdirec.textContent = agenda[j].direccion;
		divagenda.appendChild(divdirec);

		//Creamos la columna telefono
		let divtelf = document.createElement("div");
		divtelf.textContent = agenda[j].phone;
		divagenda.appendChild(divtelf);

		//Creamos la columna web
		let divurl = document.createElement("div");
		divurl.textContent = agenda[j].websiteURI;
		divagenda.appendChild(divurl);

		//Creamos el boton de emininar.
		let divtrash = document.createElement("div");
		let botonelimina = document.createElement("button");
		//botonelimina.classList.add("btntrash");
		//botonelimina.textContent="Elimina";
		let iconoelimina = document.createElement("i");
		//let claseico='<i class=\"fa fa-trash\">'+'</i>Elimina';
		//console.log(claseico);
		//botonelimina.innerHTML+=claseico;
		botonelimina.textContent = "Elimina ";
		iconoelimina.classList.add('fa');
		iconoelimina.classList.add('fa-trash');
		//console.log(iconoelimina);
		botonelimina.appendChild(iconoelimina);
		botonelimina.addEventListener("click", () => { eliminaAgenda(etiagenda.textContent) });

		divtrash.appendChild(botonelimina);
		divagenda.appendChild(divtrash);
	};
});

//Funcion que agrega texto al listado de recomendaciones.
const agregaTexto = ((divtexto, texto) => {

	//Agregamos las recomendaciones encotradas al parrafo.			  
	const consultaPlace = document.createElement("div");
	consultaPlace.innerHTML = (texto);
	//consultaPlace.classList.add("textoconsulta");
	//consultaPlace.textContent=texto;

	if (divtexto) {

		divtexto.appendChild(consultaPlace);

	};
});

//Devuelve un array con los checks activos de una sección "idForm" y los inputs de la clase "claseForm".
//Crea un nuevo [object HTMLInputElement] oculto para usar en la busqueda de lugares o actividades.
const checkformulario = (idForm, claseForm) => {

	//console.log ('En la promesa del chequeo de formulario');
	let arraform = [];
	let queryform = document.getElementById(idForm).getElementsByClassName(claseForm);
	//console.log ("formulario  array: "+queryform.length);
	if (queryform != null || queryform != "") {
		//console.log ("elementos en formulario :"+queryform.length);
		let x = 0;
		while (x < queryform.length) {
			//Comprobamos que este chequeado.
			if (queryform[x].checked) {

				//inputform.value=+ queryform[x].parentNode.textContent ;
				arraform.push(queryform[x].parentNode.textContent);

			};
			x++;
		};
		//console.log ("Formulario total" + formulario.textContent ? formulario.textContent : formulario.innerText);
		let consultaact = document.getElementById("pac-input").value;
		console.log('texto pacinput', consultaact);

		if (consultaact.trim() != "") {
			arraform.push(consultaact);
		};
		if (document.getElementById("ciudad").value != "") {
			arraform.push(document.getElementById("ciudad").value);
		} else {
			if (arraform.length > 0) {
				//console.log ("ciudad vacia "+ document.getElementById("ciudad").value + " arrafor : "+arraform);
				//arraform.push("Cerca de mi.");
			};
		};
		//console.log  ("arraform :"+arraform);
		if (arraform.length > 0) {
			//console.log ("Se devuelve la cadena de checks activos : "+ arraform);
			// Se devuelve la cadena de checks activos
			return arraform;

		} else {
			console.log("No hay actividades seleccionadas.");
			return "No hay actividades seleccionadas.";
		};
	};



};

/*--Busca sitios a partir de una cadena de texto (consultasitios). 
	Los resultados los muestra en el mapa y en el listado de recomendaciones. 
	Retorna el listado de lugares como resultado ordenado por ratting.*/

const buscaSitios = ((consultasitios) => {
	markerssitios = [];  //lista de lugares donde almacenara los resultados de la busqueda.
	service = [];  //variable para el placeservice de google.

	//configuramos el query para realizar la consulta a google y recibir los campos deseados.
	const request = {
		query: JSON.stringify(consultasitios),
		fields: ["id", "name", "formattedAddress", "internationalPhoneNumber", "isOpen", "location", "nationalPhoneNumber", "photos", "priceLevel", "rating", "reviews", "userRatingsCount", "viewport", "websiteURI"]
	};

	markerslong = 0;
	// coge  icon, name and location de cada lugar (place)
	const bounds = new google.maps.LatLngBounds();
	service = new google.maps.places.PlacesService(mapapepemi);

	//Realizamos la busqueda de servicios segun la consulta request. 

	service.textSearch(request, async (results, status) => {
		//console.log ("service "+JSON.stringify(results));
		if (status === google.maps.places.PlacesServiceStatus.OK && await results) {
			//console.log ("Recibidos los resultados :" + JSON.stringify(results));

			//Ordenamos la busqueda según el rating.
			if (results[0].rating != null) {
				results.sort((a, b) => b.rating - a.rating);
			};
			//console.log("result dordenados : "+  JSON.stringify(results));

			//Separamos los detalles de cada lugar.
			servicedetalle = service;
			for (let i = 0; i < results.length; i++) {
				let placedetalle = [];
				if (results[i].rating == null) { results[i].rating = " " };

				//Creamos los elementos del mapa.
				const content1 = document.createElement("div");
				content1.classList.add("popup-bubble");

				content1.textContent = labels[markerslong];
				content1.style.display = "inline";
				content1.style.title = " - " + results[i].name;
				content1.style.margin = "auto";
				content1.style.textAlign = "center";

				const contentinfo = document.createElement("p");
				contentinfo.classList.add("infowindow-content");
				contentinfo.textContent = " - " + results[i].name;
				contentinfo.style.display = "none";
				contentinfo.style.textAlign = "center";

				//Creamos y agregamos el lugar en el mapa.
				content1.appendChild(contentinfo);
				createMarker(results[i], content1);

				markerslong++;  //augmentamos el numero de lugares

				//Reajustamos la vista del mapa a los resultados.
				if (results[i].geometry.viewport) {
					// Only geocodes have viewport.
					bounds.union(results[i].geometry.viewport);
					mapapepemi.fitBounds(bounds, 16);

				} else {
					console.log("Lugar sin viewport");
				};
			};
			setTimeout(() => {
				return markerssitios;
			}, "900");
		} else {
			alert("No se han encontrado resultados para la búsqueda. Intente de nuevo.");
			return Promise.reject("Ha fallado la busqueda");
		};

	});
});

/* Busca los detalles de un lugar  (el lugar debe tener un place_id válido).			
   Muestra los detalles del lugar en el listado de recomendaciones.
   Retorna promesa si lo encuentra o no. */

async function buscaDetalles(place_id) {
	//servicedetalle=[];
	console.log("En busca de detalles para :" + place_id);

	//Buscamos en el array markersitios, si no lo encuentra, realiza la consulta a la API.
	if (markerdetalles) {
		for (o = 0; o < markerdetalles.length; o++) {
			if (markerdetalles[o].name == place_id || markerdetalles[o].place_id == place_id) {

				console.log("Encontrado " + markerdetalles[o].name + " en el array de detalles.");
				return await markerdetalles[o];
			};
		};
	};

	const requestdetalles = {
		placeId: place_id,
		fields: ["ALL"],
	};

	servicedetalle.getDetails(requestdetalles, async (placedetalle, status) => {
		//console.log ("Recibidos los resultados al detalle :" + JSON.stringify(placedetalle));
		if (status === google.maps.places.PlacesServiceStatus.OK && await placedetalle) {
			markerdetalles.push(placedetalle);
			//Muestra los detalles de cada lugar y retorna que ha encontrado l
			muestraDetallesLugar(placedetalle.place_id);
			return Promise.resolve("Encontrados los detalles de lugar");
			/*									new Promise((resolve, reject) => {
													if (placedetalle) {
														console.log ("placedetalle resolve: "+markerslong + placedetalle.name );
														return "de buscadetalles";
														//return Promise.resolve (placedetalle);
													} else {
														return reject(new Error('Failed to arrive'));
													}
												});*/
		};
		if (status != google.maps.places.PlacesServiceStatus.OK) { console.log("Error al obtener detalles. " + status); };
		return Promise.resolve("Fallo al buscar detalles.");

	});


	//let respuesta = await servicedetalle;
	//	if (respuesta){console.log(respuesta)};
	//return Promise.resolve(respuesta);
}

//Muestra los datos detallados de los lugares a .
const muestraDetallesLugar = async (nombreidlugar) => {
	//Borramos la información del anterior lugar.
	let divdetalles = document.getElementById("detalleslugar");
	if (divdetalles !== null) {
		while (divdetalles.hasChildNodes()) {
			divdetalles.removeChild(divdetalles.lastChild);
		}
	} else {
		console.log("No existe la caja previamente creada para los detalles de lugar.");
	};


	let lugardetalle = [];

	let encontradolugar = false;

	//Buscamos en el array markersitios, si no lo encuentra, realiza la consulta a la API.
	if (markerdetalles.length > 0) {
		for (o = 0; o < markerdetalles.length; o++) {
			if (markerdetalles[o].name == nombreidlugar || markerdetalles[o].place_id == nombreidlugar) {
				console.log("Encontrado dellates" + markerdetalles[o].name + " en el array de detalles.");
				lugardetalle = await markerdetalles[o];
				encontradolugar = true;
				break;

			};

		}
		//Comprobamos que los valores necesarios están definidos.
		let nombrelugar = await lugardetalle.name;
		let phone = await lugardetalle.formatted_phone_number != undefined ? lugardetalle.formatted_phone_number : "";
		let websiteURI = await lugardetalle.website != undefined ? lugardetalle.website : "";
		let horario = "";
		let abierto = "";
		if (lugardetalle.opening_hours) {
			horario = lugardetalle.opening_hours.weekday_text === undefined ? "" : lugardetalle.opening_hours.weekday_text;
			abierto = lugardetalle.opening_hours != undefined ? lugardetalle.opening_hours : "";
		};
		//console.log ("Encontrado detalle "+encontradolugar);
		if (!encontradolugar) {
			buscaDetalles(nombreidlugar).then((mss) => {
				//console.log("Ppp "+mss+nombreidlugar);

			}).then(() => {
				//muestraDetallesLugar (nombreidlugar);
			});
		};
		if (lugardetalle != [] || lugardetalle != undefined) {
			//console.log("Maekrs buscar :"+markerdetalles.length);
			//	console.log("EN lugardetalle "+JSON.stringify(lugardetalle));
			//Creamos el div y el titulo
			let divlugar1 = document.createElement("div");
			let namelugar = document.createElement("h3");
			divlugar1.style.height = "100%";
			divlugar1.style.width = "100%";
			//divlugar1.style.border="4px solid red";
			namelugar.style.float = "inline";
			namelugar.style.fonts = "40px";
			namelugar.innerHTML = lugardetalle.name;

			let datoslugar = document.createElement("div");
			datoslugar.innerHTML = lugardetalle.formatted_address + '<br/>' +
				'Telefono : ' + phone + '<br/>' +
				'Web :' + '<a href=\"' + websiteURI + '\" target=_blank>' + websiteURI + '</a>' + '<br/>' +
				'<p>' + 'Puntuación: ' + await lugardetalle.rating + ' - con ' + await lugardetalle.user_ratings_total + ' votos.' + '</p>' +
				'<strong>' + 'Horario: ' + '</strong>' + '<br/>' + horario + '<br/>';
			//datoslugar.style.maxnWidth="300px";
			datoslugar.style.width = "30%";


			divlugar1.appendChild(namelugar);
			divlugar1.appendChild(datoslugar);



			let divlugar2 = document.createElement("div");
			divlugar2.style.height = "100%";
			//divlugar2.style.border="4px solid pink";
			divlugar2.style.float = "inline";

			//console.log ("horario : "+horario);
			divlugar2.innerHTML = "";

			divlugar1.innerHTML += divlugar2.innerHTML;
			detalleslugar.appendChild(divlugar1);
			//return Promise.resolve(lugardetalle);
			return lugardetalle;
		};
	} else {
		console.log("voy a buscar detalles");
		lugardetalle = await buscaDetalles(nombreidlugar);
	};
	//	lugardetalle.then((pp)=>{console.log("muestraDetallesLugar = "+stringify(lugardetalle+pp))});



}

//Crear el marcador como un objeto clase.
const createMarker = (place, content1) => {

	/*  Creamos la clase para  los popups de los establecimientos o lugares. */
	//console.log("En crmk: "+place.name);
	class Popup extends google.maps.OverlayView {
		position;
		containerDiv;
		lugar;
		//containerDivContent;
		constructor(position, content, lugar) {
			super();
			this.position = position;
			this.lugar = lugar;
			this.content = content;
			if (this.content == null) {
				this.content = document.createElement("div");
				this.content.classList.add("popup-bubble");
				this.content.textContent = content;
				document.getElementById("contentpopups").appendChild(content);
				console.log("content vacio")
			}
			//console.log("popup en creacion: "+this.lugar.name);

			content.classList.add("popup-bubble");

			//  console.log("Marker : "+this.lugar.name);
			// This zero-height div is positioned at the bottom of the bubble.
			const bubbleAnchor = document.createElement("div");
			bubbleAnchor.classList.add("popup-bubble-anchor");

			bubbleAnchor.appendChild(content);
			this.containerDivContent = document.createElement("div");
			//this.containerDivContent.classList.add("infowindow-content");

			bubbleAnchor.addEventListener("click", (e) => {
				//Borramos la información del anterior lugar.
				let divdetalles = document.getElementById("detalleslugar");
				if (divdetalles !== null) {
					while (divdetalles.hasChildNodes()) {
						divdetalles.removeChild(divdetalles.lastChild);
					}
				} else {
					console.log("No existe la caja previamente creada para los detalles de lugar.");
				};

				if (

					lugar &&
					lugar.geometry &&
					lugar.geometry.location
				) {
					console.log("buscando datos de lugar");
					muestraDetallesLugar(lugar.place_id);
					//alert(divlugar.textContent);

				}


			});
			const divtexto = document.getElementById("parrafo");
			let textoparrafo = '<div class="textoconsulta" onclick\=\"muestraDetallesLugar\(\'' + lugar.place_id + '\'\)\">' +
				'<div name=\'' + lugar.name + ' place_id=\'' + lugar.place_id + '\' >' +

				'<button  title=\"Agregar a la agenda\" onclick=\"agregarAgenda(\'' + lugar.place_id + '\')\"/>Agrega' +
				'</div>' +
				'<strong>' + '<p id="etiqueta" class="firstHeading">' + content.textContent + ' - ' + '<span id="name">' + lugar.name + '</span>' + '</p>' + '</strong>' +
				'<div id="bodyContent">' +
				'<p>Puntuación: ' + lugar.rating + ' - con ' + lugar.user_ratings_total + ' votos.' + '<br/>' +
				lugar.formatted_address + '</p>' +

				'</div>' +
				'</div>';


			//Agregamos el marcador a la lista de recomendaciones.
			agregaTexto(divtexto, textoparrafo);

			let infowindowA = new google.maps.InfoWindow({
				content: lugar.name,
				position: this.position,

			});
			//MOUSE OVER  OUT 
			content.addEventListener("mouseover", () => {
				// console.log ("Contenido content infowindowA : "+lugar.name);
				this.content.style.backgroundColor = "rgb(106, 179, 122)";
				this.content.style.minWidth = "150px";
				this.content.style.maxnWidth = "250px";
				this.content.lastChild.style.display = "flex";
				this.content.style.zIndex = "969";

			});
			content.addEventListener("mouseout", () => {
				//infowindowA.close(mapapepemi);
				this.content.style.backgroundColor = "lightgrey";
				this.content.style.minWidth = "initial";
				this.content.style.maxnWidth = "initial";
				this.content.lastChild.style.display = "none";
			});



			// This zero-height div is positioned at the bottom of the tip.
			this.containerDiv = document.createElement("div");
			this.containerDiv.classList.add("popup-container");
			this.containerDiv.appendChild(bubbleAnchor);
			// Optionally stop clicks, etc., from bubbling up to the map.
			Popup.preventMapHitsAndGesturesFrom(this.containerDiv);


		};

		/** Called when the popup is added to the map. */
		onAdd() {

			this.getPanes().floatPane.appendChild(this.containerDiv);
			// console.log("Popup creado por metodo Add");
		}
		/** Called when the popup is removed from the map. */
		onRemove() {

			this.containerDiv.parentElement.removeChild(this.containerDiv);
			console.log("Popup eliminado por metodo remove");

		}
		/** Called each frame when the popup needs to draw itself. */
		draw() {
			const divPosition = this.getProjection().fromLatLngToDivPixel(
				this.position
			);
			// Hide the popup when it is far out of view.
			const display =
				Math.abs(divPosition.x) < 4000 && Math.abs(divPosition.y) < 4000
					? "block"
					: "none";

			if (display === "block") {
				this.containerDiv.style.left = divPosition.x + "px";
				this.containerDiv.style.top = divPosition.y + "px";
				//console.log("Creado bloque popup en pos x "+divPosition.x +" y pos y : "+divPosition.y);
			}

			if (this.containerDiv.style.display !== display) {
				this.containerDiv.style.display = display;


			}

		}
	}

	//Comprobamos que el lugar tiene datos geograficos, 
	if (!place.geometry || !place.geometry.location) {
		console.log("No hay datos geográficos");

		return Promise.reject("No hay datos geográficos");;
	};
	markerssitios.push(place);
	popup = new Popup(
		place.geometry.location,
		content1,
		place

	);

	popup.setMap(mapapepemi);
	return popup;
}

//Envia a la pagina de contacto si el usuario pulta Shift+Q;
document.addEventListener ("keydown", (e) =>{
	
	if (e.shiftKey && e.key == 'Q') {

		window.location.href="contacto.html";

	}
});



	function handleLocationError(browserHasGeolocation, infoWindow, pos) {
		infoWindow.setPosition(pos);
		infoWindow.setContent(
			browserHasGeolocation
				? "Error: The Geolocation service failed."
				: "Error: Your browser doesn't support geolocation."
		);
		infoWindow.open(map);
	}


	window.initMap = initMap;




