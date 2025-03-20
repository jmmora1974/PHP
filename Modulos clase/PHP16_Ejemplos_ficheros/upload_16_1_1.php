<!DOCTYPE html>
<html lang="es">
	<head>
	<meta charset="UTF8-8">
	<title>File upload </title>
	</head>
	<body>
	<h2>Datos del fichero reibido en el servidor:</h2>
	<pre>
	<?php 
	//si se produce error
	if($codigo = $_FILES['fichero']['error'])
		throw new Exception ('ERROR, con codigo: '.$codigo);
	//recupera la ruta que se le asigna al fichero en la carpeta temporal
	$rutaTemporal  = $_FILES['fichero']['tmp_name'];
	
	//recupera el nombre original del fichero
	$nombreFichero= $_FILES['fichero']['name'];
	
	//ruta final donde ubucaremos el fichero, debe ser accesible
	$rutaFinal = "imagenes/$nombreFichero";
	
	//mueve el fichero de la ruta temporal a la ruta final
	if (!move_uploaded_file($rutaTemporal, $rutaFinal))
		throw new Exception('Error al mover el fichero');
	echo 'El fichero se movió correctamente'; //todo OK
	var_dump($_FILES);
	
	?>
	
	</pre>
	</body>
</html>
