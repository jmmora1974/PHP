	
	<?php 
	
	//EJEMPLO:
	//$_FILES ['fichero']['name'][0] --> nombre del fichero
	
	// - La primera clave es el nombre del input
	// - La segunda es el campo que queremos recuperar
	// - El tercer indice se corresponde con el fichero (0,1,2,3,...)
	
	foreach ($_FILES['fichero']['error'] as $indice => $error ) {
		if(!$error) { //si no hay error
		
			//recupera el nombre original del fichero
			$nombreFichero= $_FILES['fichero']['name'][$indice];
		
	
			//recupera la ruta que se le asigna al fichero en la carpeta temporal
			$rutaTemporal  = $_FILES['fichero']['tmp_name'][$indice];
			
			
			//ruta final donde ubucaremos el fichero, debe ser accesible
			$rutaFinal = "imagenes/$nombreFichero";
						
			//mueve el fichero de la ruta temporal a la ruta finbal
			echo move_uploaded_file($rutaTemporal, $rutaFinal) ?
			"<p>Fichero $nombreFichero movido correctamente.</p>" :
			"<p>Error al mover el fichero $nombreFichero.</p>" ;
			
		}
		else {
			echo "<p>ERROR con código $error.>/p>";
			
		}
	
		
	}
	
	
	?>
