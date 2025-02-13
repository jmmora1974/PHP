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
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- estilo propio.-->
	<link rel="stylesheet" href="./css/estilo.css">
	<title>Mitravel</title>
	<link rel="icon" type="image/x-icon" href="./images/favicon.ico">
	<base href="./" target="_blank">
</head>

<body>

  <?php
		cabecera('&#9807;Mitravel','Planifica tus aventuras');
		menu('contacto');
	?>
  


	<main >
    <div class="containerContacto">
      <form id="formContacto" action="action_page.php">
    
        <label for="fnombre">Nombre</label>
        <input type="text" id="fnombre" name="nombre" class="textContact" placeholder="Escriba su nombre.." required>
    
        <label for="fapellidos">Apellido</label>
        <input type="text" id="fapellidos" name="apellidos" class="textContact" placeholder="Escriba sus apellidos..">
    
        <label for="fmail">Mail</label>
        <input type="email" id="fmail" name="mail" class="textContact" placeholder="Escriba su mail.." required>
    
        <label for="country">Pais</label>
        <select id="country" name="country">
          <option value="España">España</option>
          <option value="Catalunya">Catalunya</option>
          <option value="Andorra">Andorra</option>
          <option value="Portugal">Portugal</option>
        </select>
        <label for="subject">Comentario</label>
        <div class="flex-container">
        
        <textarea id="subject" name="subject" class="flex3"  placeholder="Escriba un comentario.." style="height:200px"></textarea>
     
        <div class="mapswrapper">
          <iframe width="250" height="200" loading="lazy" allowfullscreen src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8&q=terrassa&zoom=10&maptype=roadmap">

          </iframe>
          </div>
      </div>
      <input type="submit" value="Submit">
      <input id="btnResetReg" type="submit" class="btn btn-reset" onclick="formContacto.reset()" value="Reset">
      </form>
    </div>
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
  <?php piedepagina ('Jose Miguel Mora Perez')?>
</body>

</html>