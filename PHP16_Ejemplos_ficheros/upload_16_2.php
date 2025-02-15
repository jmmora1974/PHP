<!DOCTYPE html>
<html lang="es">
	<head>
	<meta charset="UTF8-8">
	<title>Subida de varios ficheros </title>
	</head>
	<body>
	<h2>Datos del fichero reibido en el servidor:</h2>
	<pre>
	<?php 
	foreach ($_FILES as $fichero){    // para cada entrada e $_FILES
		
		if(!$error = $fichero['error']){
			$nombreFichero = $fichero['name'];  //Nombre del fichero
			$rutaTemporal = $fichero['tmp_name']; //ruta temporal
			$rutaFinal = "files/$nombreFichero"; //ruta final
			
			//mueve el fichero de la ruta temporal a la ruta finbal
			echo move_uploaded_file($rutaTemporal, $rutaFinal) ? 
				"<p>Fichero $nombreFichero movido correctamente.</p>" :
				"<p>Error al mover el fichero $nombreFichero.</p>" ;
						
		} else {
			echo "<p>ERROR con código $error.</p>";
		}
	}
	?>
	</pre>
	</body>
</html>
