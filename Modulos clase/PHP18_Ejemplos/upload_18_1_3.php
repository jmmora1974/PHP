	
	<?php 
	
	//EJEMPLO:
	//$_FILES ['fichero']['name'][0] --> nombre del fichero
	
	// - La primera clave es el nombre del input
	// - La segunda es el campo que queremos recuperar
	// - El tercer indice se corresponde con el fichero (0,1,2,3,...)
	
	foreach ($_FILES['fichero']['error'] as $indice => $error ) {
		if(!$error) { //si no hay error
			
			//Comprobaremos que el tamaño no sea superior a 500.000 bytes...
			$tamano = $_FILES['fichero']['size'][$indice];
			
			if ($tamano > 500000)
				throw new Exception ("El fichero supera el tamaño permitido.");
		
			//recupera el nombre original del fichero
			$nombreFichero= $_FILES['fichero']['name'][$indice];
			$extension = pathinfo($nombreFichero, PATHINFO_EXTENSION);
			
			$nuevoNombre = uniqid('img_').'.'.$extension; //genera el nombre unico
			
	
			//recupera la ruta que se le asigna al fichero en la carpeta temporal
			$rutaTemporal  = $_FILES['fichero']['tmp_name'][$indice];
			
			//FORMA ORIENTADA A OBJETOS
			
			$tipoMime= (new finfo(FILEINFO_MIME_TYPE))->file($rutaTemporal);  // recupera el tipo MIME
			
			
			
			// Comprobar si es de imagen (comienza por image/
			if( !preg_match("/^image/", $tipoMime) )
				throw new Exception ("El fichero no es de imagen");
				
						//ruta final donde ubucaremos el fichero, debe ser accesible
			$rutaFinal = "galeria/$nuevoNombre";
			
			
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
