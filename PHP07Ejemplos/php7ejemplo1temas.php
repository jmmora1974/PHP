
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="keywords" content="HTML, CSS, JavaScript">
	<meta name="description"
		content="Web de Ejemplo 1 PHP 7 Guardar Tema">
	<meta name="author" content="Jose Miguel Mora Perez">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- frameworks predefinidos..-->
		<!-- estilo propio.-->
	<title>Web de Ejemplo 1 PHP 7 Guardar Tema</title>
	<base href="./" target="_blank">
	
</head>

<body>
	<h1>Web de Ejemplo 1 PHP 7 Guardar Tema</h1>
	<p>Formulario que permite guardar tema en la tabla temas de la base de datos biblioteca.</p>
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
		<label> No: </label>
		<input type="text" name="tema" required>  
		<br>
		<label> Descripcion: </label>
		<input type="text" name="descripcion" required> 
		<br>
		<input type="submit" class="buttom" name="guardar" value="Guardar tema">
	</form>		
	<?php
if (!empty($_POST['guardar'])){ //Si llegan datos del formulario...
    
    //Creamoas la conexión con la BDD.
    $conexion = new mysqli('localhost','root','','biblioteca');
    $conexion ->set_charset('utf8');
    
    //Recupera los datos que vienen por post
    $tema= $_POST['tema'];
    $descripcion = $_POST['descripcion'];
    
    //Preparando la consulta 
    $consulta = "INSERT INTO temas(tema, descripcion) 
                 VALUES ('$tema','$descripcion')";
    
    //Se ejecuta la consulta en la bdd
    echo $conexion->query($consulta)? 'Tema guardado OK':'No se pudo guardar el tema.';
}
?> 


</body>


</html>
