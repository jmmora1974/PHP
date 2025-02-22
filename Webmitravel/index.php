<?php
	require 'templates/template.php';
	//session_start();  // inicia o reaunda la sesión
		
?>
<!DOCTYPE html>
<html lang="es">
<?php head();?>
<body>
	<?php
		
		cabecera('&#9807;Mitravel','Planifica tus aventuras');
		menu('ini');
		if(empty($_COOKIE['consentimiento']))
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
				<ul><h3> Pasos:</h3>
					<li>Pulsa en la pestaña "Planificador". 
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