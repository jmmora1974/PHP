
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="keywords" content="HTML, CSS, JavaScript">
	<meta name="description"
		content="Web de Ejercicio 1 PHP 5">
	<meta name="author" content="Jose Miguel Mora Perez">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- frameworks predefinidos..-->
		<!-- estilo propio.-->
	<title>Ejercicio 1  PHP 5</title>
	<base href="./" target="_blank">
	
</head>

<body>
	<h1>Pasar grados a Frarenheit</h1>
	<?php
if (!empty($_POST['calcular'])){
    $grados = floatval ($_POST['grados']);
    
    $resultado = $grados * 9 / 5 + 32 ;

}
?>
	
	<form method="POST">
		<label> Grados centigrados: </label>
		<input type="number" name="grados" value="<?= grados ?? ''?>">> 
		<br>
		<input type="submit" name="calcular" value="Calcular">
	</form>		
	
	<?= isset($resultado) ? '' : "<p>La temperatura en Farenheit es $resultado.>/p>"?>

</body>


</html>
