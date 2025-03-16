
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="keywords" content="HTML, CSS, JavaScript">
	<meta name="description"
		content="Web de Ejercicio 3 PHP 5">
	<meta name="author" content="Jose Miguel Mora Perez">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- frameworks predefinidos..-->
		<!-- estilo propio.-->
	<title>Ejercicio 3  PHP 5</title>
	<base href="./" target="_blank">
	
</head>

<body>
	<h1>Calcular area triangulo rectangulo</h1>
	<?php
if (!empty($_POST['calcular'])){
    $base = floatval ($_POST['base']);
    $altura = floatval ($_POST['altura']);
    
    $resultado = floatval(( $base * $altura) /2) ;

}
?>
	
	<form method="POST" target="_self">
		<label> Base triangulo: </label>
		<input type="number" name="base" value="<?= $base ?? '' ?>"> 
		<br>
		<label> Altura triangulo: </label>
		<input type="number" name="altura" value="<?= $altura ?? '' ?>"> 
		<br>
		<input type="submit" name="calcular" value="Calcular">
	</form>		
	
	<?= empty($resultado) ? '' : "<p>El area del triangulo rectangulo  es de $resultado.</p>"?>

</body>


</html>
