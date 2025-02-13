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
	
	
	<!-- <link rel="stylesheet" type="text/css" href="https://robertsallent.com/css/generic.css"> -->
	<!-- estilo propio.-->
	<link rel="stylesheet" href="./css/estilo.css">
	<title>Mitravel</title>
	<link rel="icon" type="image/x-icon" href="./images/favicon.ico">
	<base href="./" target="https://mitravel.atwebpages.com/">
	
	<script src="./js/mitravel.js"></script>
</head>

<body>
	<?php
		
		cabecera('&#9807;Mitravel','Planifica tus aventuras');
		menu('ini');
		aceptarCookies();
	?>
		

	<main>
		
		<div class="principal" id="principal">
			<diV id="descripcionweb">
				<p> Planifica tu dia de actividades y crea la agenda diaria. 
					Puedes buscar varias actividades y agregar el lugar en la agenga y planificar la hora de visita.
					Puedes seleccionar alguna actividad  o escribir lo que deseas hacer y buscar los lugares en una ciudad, región o incluso en el país que desees. 
					En el listado del resultado, podras ver los detalles del lugar y si te apetece visitarlo, pulsa el botón agregar y te aparecerá en la agenda, modifica la hora prevista si lo deseas.
				</p>
			</diV>
			
			
			<div class="superior">
				<ul> Pasos: 
					<li> Selecciona la ciudad o región donde quieres planificar el dia.</li>
					<li> Selecciona las actividad/es deseadas. </li>
					<figure>
						<img src="./images/mitravel_ejemplo1.png" width="400vw" >	
						<figcaption>Buscador</figcaption>
					</figure>
					<li> Revisa el listado de los lugares deseadas. <info>Con doble-click podrás tener más información del lugar</info></li>
					<li> Pulsa en "Agregar" del lugar deseado y se añadirá en la agenda. </li>
					<li> Verifica que el lugar está en la agenda y la hora es la que te conviene. </li>
					<li> Repite los pasos para completar la agenda. </li>
					<figure>
						<img src="./images/mitravel_ejemplo2.png" width="400px" >	
						<figcaption>Agenda</figcaption>
					</figure>
					<li> Deseo que sea de una buena utilidad </li>
					
				</ul>
				
			</div>

			
			
			<div class="inferior">

				<!-- <?php chatservice() ?>*/ desactivado chat- -->  
		</div>
		<div class="clearfix"></div>
		
		

	<?php mapaweb()?>

	</main>
	
	
		<?php piedepagina ('Jose Miguel Mora Perez')?>
		
	
	

</body>

</html>