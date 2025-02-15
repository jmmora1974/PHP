
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="keywords" content="HTML, CSS, JavaScript">
	<meta name="description"
		content="Web de Ejemplo 1 PHP 7 Guardar Socio">
	<meta name="author" content="Jose Miguel Mora Perez">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- frameworks predefinidos..-->
		<!-- estilo propio.-->
	<title>Web de Ejemplo 1 PHP 7 Guardar Socio</title>
	<base href="./" target="_blank">
	<link rel="stylesheet" type="text/css" href="https://robertsallent.com/css/generic.css">
	
</head>

<body>
	<h1>Web de Ejemplo 1 PHP 7 Guardar Socio</h1>
	<p>Formulario que permite guardar socio en la tabla socios de la base de datos biblioteca.</p>
	<?php
if (!empty($_POST['calcular'])){
    $diametro = floatval ($_POST['diametro']);
    $perimetro = floatval ($_POST['perimetro']);
    $area = floatval ($_POST['area']);
    $radio = floatval ($_POST['radio']);
    
    
    $resultado = floatval(( $base * $altura) /2) ;

}
?>

	<form method="POST" target="_self" autocomplete="off">
		<label> Nombre: </label>
		<input type="text" name="nombre" required>  
		<br>
		<label> Apellidos: </label>
		<input type="text" name="apellidos" required> 
		<br>
		<label> DNI: </label>
		<input type="text" name="dni" required> 
		<br>
		<label> Nacimiento: </label>
		<input type="date" name="nacimiento" required> 
		<br>
		<label> Email: </label>
		<input type="text" name="email" required> 
		<br>
		<label> Direccion: </label>
		<input type="text" name="direccion" required> 
		<br>
		<label> CP: </label>
		<input type="text" name="cp" required> 
		<br>
		<label> Poblacion: </label>
		<input type="text" name="poblacion" required> 
		<br>
		<label> Provincia: </label>
		<input type="text" name="provincia" required> 
		<br>
		<label> Telefono: </label>
		<input type="text" name="telefono" required> 
		<br>
		<label> Foto: </label>
		<input type="text" name="foto"  > 
		<br>
		<label> conformidad: </label>
		<input type="text" name="conformidad" > 
		<br>
		<input type="submit" class="buttom" name="guardar" value="Guardar socio">
	</form>		
	<?php
if (!empty($_POST['guardar'])){ //Si llegan datos del formulario...
    
    //Creamoas la conexión con la BDD.
    $conexion = new mysqli('localhost','root','','biblioteca');
    $conexion ->set_charset('utf8');
    
    //Recupera los datos que vienen por post
    $nombre= $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $dni = $_POST['dni'];
    $nacimiento = $_POST['nacimiento'];
    $email  = $_POST['email'];
    $direccion = $_POST['direccion'];
    $cp = $_POST['cp'];
    $poblacion = $_POST['poblacion'];
    $provincia = $_POST['provincia'];
    $telefono = $_POST['telefono'];
    $foto = $_POST['foto']?? '';
    $conformidad = $_POST['conformidad'] ?? '';
    
    
    //Preparando la consulta 
    $consulta = "INSERT INTO socios (nombre, apellidos ,dni,
                nacimiento ,email, direccion,cp,poblacion,
provincia,telefono,foto,conformidad)
                 VALUES ('$nombre','$apellidos','$dni',
                '$nacimiento','$email', '$direccion','$cp','$poblacion',
'$provincia','$telefono','$foto','$conformidad' )";
    
    //Se ejecuta la consulta en la bdd
    echo $conexion->query($consulta)? 'Socio guardado OK':'No se pudo guardar el socio.';
}
?> 


</body>


</html>
