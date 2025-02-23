<?php
require 'templates/template.php';
require 'libraries/Email.php';
require 'exceptions/EmailException.php';
?>
<!DOCTYPE html>
<html lang="es">
<?php head();?>
<body>
	<?php
	cabecera ( '&#9807;Mitravel', 'Planifica tus aventuras' );
	menu ( 'contacto' );
	migas ( [ 
			"Inicio" => "index.php",
			"Contacto" => "contacto.php"
	] );

	if (empty ( $_COOKIE ['consentimiento'] ))
		aceptarCookies ();

	// Si nos llega el formulario por POST
	if (! empty ( $_POST ['enviocomentario'] )) {
		
			// cargamos la funcion para sanear datos.
			require 'libraries/filtrado.php';
			// Preparacion de los parametros a pasarle a la funcion mail()
			$to = "support@mitravel.com"; // receptor
			$from = filtrado ( $_POST ['mail'] );
			$name = filtrado ( $_POST ['nombre'] ) . filtrado ( $_POST ['apellidos'] );
			$subject = filtrado ( $_POST ['asunto'] );
			$pais = filtrado ( $_POST ['country'] );
			$comentario = filtrado ( $_POST ['comentario'] );
			$asunto= filtrado ( $_POST ['asunto'] );
			//mensaje 	en HTML (uso sintaxis HEREDOC 	que es mas sencilla para  esto)
			$message='<HTML lang="es">
				<head>
					<title>'.$asunto.'</title>
				</head>
				<body>
				 	<h3>'.$asunto.'</h3>
				 	<p>El usuario: '.$name.' mail: '.$from.' de '.$pais.', comenta: <br>'.$comentario.' </p>
				 	
				 </body>
								
			</html>';
						
			try {
			// crea el nuevo mail y lo envia
			$email = new Email ( $to, $from, $name, $subject, $message );
			$email->send ();
			echo "Mensaje enviado correctamente !";
			// En caso de error de envío de email..
		} catch ( EmailException $e ) {
			echo "Mensaje no enviado: " . $e->getMessage ();
		}
	}
	

	?>
  


	<main>
		<div class="containerContacto">
			<form id="formContacto" method="POST">

				<label for="fnombre">Nombre</label> <input type="text" id="fnombre"
					name="nombre" class="textContact" placeholder="Escriba su nombre.."
					required> <label for="fapellidos">Apellidos</label> <input
					type="text" id="fapellidos" name="apellidos" class="textContact"
					placeholder="Escriba sus apellidos.." required> <label for="fmail">Mail</label>
				<input type="email" id="fmail" name="mail" class="textContact"
					placeholder="Escriba su mail.." required> <label for="country">Pais</label>
				<select id="country" name="country">
					<option value="España">España</option>
					<option value="Catalunya">Catalunya</option>
					<option value="Andorra">Andorra</option>
					<option value="Portugal">Portugal</option>
				</select> <label>Asunto:</label> <input type="text" name="asunto"
					list="listaAsuntos" class="textContact">
				<datalist id="listaAsuntos" required>
					<option value="Problema de login.">
					
					
					<option value="Problema con el perfil.">
					
					
					<option value="Problema general de la aplicación.">
					
					
					<option value="Dudas de funcionamiento.">
					
					
					<option value="Incidencia con las fotos">
					
					
					<option value="Recomendación de mejora.">
				
				</datalist>
				<br> <label for="subject">Comentario</label>
				<div class="flex-container">

					<textarea id="subject" name="comentario" class="flex3"
						placeholder="Escriba un comentario.." style="height: 200px"></textarea>

					<div class="mapswrapper">
						<iframe width="250" height="200" loading="lazy" allowfullscreen
							src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8&q=terrassa&zoom=10&maptype=roadmap">

						</iframe>
					</div>
				</div>
				<input type="submit" value="Submit" name="enviocomentario"> <input
					id="btnResetReg" type="submit" class="btn btn-reset"
					onclick="formContacto.reset()" value="Reset">
			</form>
		</div>
    <?php mapaweb();?>
  </main>
  <?php piedepagina ('Jose Miguel Mora Perez')?>
</body>

</html>