<?php require 'templates/template.php' ?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="keywords" content="HTML, CSS, JavaScript">
	<meta name="description"
		content="Web de busqueda de aventuras, eventos, actividades, que hacer, what to do, planificador de actividades, agenda.">
	<meta name="author" content="Jose Miguel Mora Perez">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- frameworks predefinidos..-->
	<!--  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	..-->
	
	<!-- <link rel="stylesheet" type="text/css" href="https://robertsallent.com/css/generic.css"> -->
	<!-- estilo propio.-->
	<link rel="stylesheet" href="./css/estilo.css">
	<title>Mitravel</title>
	<link rel="icon" type="image/x-icon" href="./images/favicon.ico">
	<base href="./" target="_blank">
	<script
		src="https://maps.googleapis.com/maps/api/js?key="PUT-key-here-"&callback=initMap&libraries=geometry,places&v=weekly&callback=initMap"
		async defer></script>
	<script src="./js/mitravel.js"></script>
</head>

<body>
	<?php
		cabecera('&#9807;Mitravel','Planifica tus aventuras');
	?>
	
	<nav class=" topnav ">
		<menu>
			<li class=" active"><a href="./index.html" target="_self">Inicio</a></li>
			<li><a href="recomendaciones.html" target="_self">Recomendaciones</a></li>
			<li><a href="contacto.html" target="_self">Contacto</a></li>
			<li><a href="about.html" target="_self">Sobre nosotros</a></li>
		</menu>
	</nav>

	<main>
		
		
		<div class="principal" id="principal">
			<diV id="descripcionweb">
				<p> Planifica tu dia de actividades y crea la agenda diaria. 
					Puedes buscar varias actividades y agregar el lugar en la agenga y planificar la hora de visita.
					Puedes seleccionar alguna actividad  o escribir lo que deseas hacer y buscar los lugares en una ciudad, región o incluso en el país que desees. 
					En el listado del resultado, podras ver los detalles del lugar y si te apetece visitarlo, pulsa el botón agregar y te aparecerá en la agenda, modifica la hora prevista si lo deseas.
				</p>
			</diV>
			<div id="dialogogalleta">
				<dialog open>
					<p>Obtener más información y configuración

						El acceso a este sitio está sujeto al consentimiento para el uso de cookies, la disposición de
						esta web es para uso educatico con el fin de aprender y compartir los conocimientos adquiridos
						sin ánimos de lúcro.
						La información recogida a través de determinadas categorías de cookies y tecnologías similares
						constituye, directa o indirectamente, una remuneración justa por la prestación sin suscripción
						del contenido de este sitio.
						Por ello, al aceptar el uso de dichas cookies y tecnologías similares, podrás acceder al
						contenido que ofrece este sitio.
						Puedes consultar más información en nuestra Política de Cookies y puedes modificar tus opciones,
						en cualquier momento, a través del botón “configuración de cookies” en la parte inferior de
						nuestra página.
					</p>

					<form method="dialog">
						<input id="chkgalleta" name="chkgalleta" type="checkbox" onchange="validarCookies()" >
						<label for="chkgalleta">Acepto los términos y condiciones</label>
						
						<button id="btngalleta" disabled>Aceptar</button>
						
					</form>
				</dialog>
			</div>
			
			<div class="superior">
				<div id="divciudad">
					<section id="secbuscador" class="flex-container  ">
						<h2> En que ciudad/zona/region quieres planificar tu dia: </h2>
						<div>
							<input type="search" id="ciudad" name="ciudad" value="Catalunya">
							<button onclick="enviarconsulta.click()"><i class="fa fa-search"></i></button>
						</div>
					</section>
				</div>
				<div id="formularios">
					<div class="mananas">
						<form id="buscador" target="_self" >
							<fieldset>
								<legend>Actividades</legend>
								¿Qué actividades deseas realizar?<br>

								<label for="airelibre"> Actividades al aire libre <input type="checkbox"
										class="actividad" id="airelibre" name="airelibre"> </label>
								<label for="entretenimiento"> Entrenenimiento <input type="checkbox" class="actividad"
										id="entretenimiento" name="entretenimiento"></label>
								<label for="museos"> Museos <input type="checkbox" class="actividad" id="museos"
										name="museos"></label>
								<label for="arte"> Arte <input type="checkbox" class="actividad" id="arte"
										name="arte"></label>
								<label for="karting"> Karting <input type="checkbox" class="actividad" id="karting"
										name="karting">
								</label>
								<label for="compras"> Shopping <input type="checkbox" class="actividad" id="compras"
										name="compras"></label>
								<label for="deportesriegos"> Deportes de riesgo<input type="checkbox" class="actividad"
										id="deportesriegos" name="deportesriegos"></label>
								<label for="bares"> Bares y tapas <input type="checkbox" class="actividad" id="bares"
										name="bares"></label>
								<label for="espectaculos"> Espectaculos <input type="checkbox" class="actividad"
										id="espectaculos" name="espectaculos"></label>
								<label for="ruta4x4"> Ruta4x4 <input type="checkbox" class="actividad" id="ruta4x4"
										name="ruta4x4"></label><br>

								<input type="text" id="textoconsulta" hidden>

								<label for="pac-input"></label>
								<input id="pac-input" list="listaactividades" class="control" type="search"
									onchange="enviarconsulta.click()"
									placeholder="Escribe que deseas hacer, separado por comas">
								<i class="fa fa-info"
									title=" Puedes introducir varias actividades separadas por coma. Por ejemplo, submarinismo, visitar islas.."></i>

								<datalist id="listaactividades">
									<option value="Motociclismo"></option>
									<option value="Pescar"></option>
									<option value="Bucear"></option>
									<option value="Monta a caballo"></option>
									<option value="Vistas increíbles"></option>
								</datalist>

								<input type="button" value="Buscar actividades" id="enviarconsulta">

								<span id="consejos" title="Consejos"> </span>

							</fieldset>

						</form>
					</div>


				</div>

				<div class="contenedormapa" id="contenedormapa">
					<div id="mapapepemi">
						Algo ha ocurrido, deberia haber un mapa!!.
						<div id="contentpopups" class="contentpopups"></div>
					</div>
					<div id="listado">
						<div class="place-overview">
							<div id="info">
								<div id="heading"></div>
								<div id="summary"></div>
							</div>
							<div id="gallery"></div>
						</div>
						<div id="expanded-image"></div>
						<h3 id="titulotextoconsulta"> Las recomendaciones de Mitravel son: </h3>
						<div id="detalleslugar" class="detalleslugar"></div>
						<div id="parrafo"> </div>

					</div>
				</div>
			</div>

			<h2>Agenda</h2>
			
			<div class="inferior">

				<div id="agenda" class="grid-agenda responsive">
					<div> </div>
					<div>Hora</div>
					<div>Nombre</div>
					<div>Direccion</div>
					<div>Telefono</div>
					<div>Web</div>
					<div><button class="btntrash"><i class="fa fa-trash"></i> Borra agenda</button></div>
				</div>
			</div>
			<section>
				<fieldset id="planificador">
					<legend>Planificador</legend>
					<h3>Quieres que mitravel te planifique el dia? </h3>
					<label>Hora inicio:
						<input type="time" name="horainicio" value="09:00">
					</label><br>
					<input type="button" value="Planifica un dia" id="enviarplan">
					<i class="fa fa-search"></i>

				</fieldset>


			</section>
			<div id="chat-container">
				<div id="title_bar">
					<button id="buttonchat">-</button>
					<label>Soporte en linea</label>

				</div>
				<div id="chat-messages">Tienes alguna consulta?</div>
				<form id="chat-form">

					<div id="box">
					</div>
					<input type="text" id="chat-input" placeholder="Escribe tu mensaje aquí...">
					<button type="submit">Enviar</button>
				</form>
			</div>
		</div>
		<div class="clearfix"></div>
		<div>
			<h5 id="titulomapa"> Mapa web </h5>
		</div>
		<div id="mapaweb">

			<ul class="responsive">

				<li><a href="./index.html" target="_self"><strong><u>Portada</u></strong></a></li>

				<li><a href="./index.html#divciudad" target="_self">Localizacion</a></li>
				<li><a href="./index.html#formularios" target="_self">Actividades</a></li>
				<li><a href="./index.html#contenedormapa" target="_self">Mapa</a></li>
				<li><a href="./index.html#listado" target="_self">Listado lugares</a></li>
				<li><a href="./index.html#listado" target="_self">Detalles lugar</a></li>
				<li><a href="./index.html#agenda" target="_self">Agenda</a></li>
			</ul>
			<ul class="responsive">
				<li><a href="./recomendaciones.html" target="_self"><strong><u>Recomendaciones</u></strong></a></li>
				<li><a href="./recomendaciones.html#carrusel" target="_self">Excursiones 4x4</a></li>
				<li><a href="./recomendaciones.html#video1" target="_self">Circuito nocturno</a></li>
			</ul>
			<ul class="responsive">
				<li><a href="./contacto.html" target="_self"><strong><u>Contacto</u></strong></a></li>
				<li>Preguntas frecuentes</li>
				<li>Consejos</li>
			</ul>
			<ul class="responsive">
				<li><a href="./about.html" target="_self"><strong><u>Sobre nosotros</u></strong></a></li>
				<li>Aviso legal</li>
				<li><a href="https://www.w3.org/TR/WCAG10/" target="_blank">Accesibilidad</a></li>
			</ul>


		</div>



	</main>
	<div class="w3-container w3-teal">

		<details>

			<summary>
				<b>Mitravel®</b>. Web para planificar tus aventuras.
				@author:Jose Miguel Mora Perez® CIFO 2024
				<i class="fa fa-copyright" aria-hidden="true"></i><i class="fa fa-envelope-o" aria-hidden="true"></i>

			</summary>

		</details>
	</div>
	

</body>

</html>