
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="keywords" content="HTML, CSS, JavaScript">
	<meta name="description"
		content="Web de Ejercicio 2 PHP 5">
	<meta name="author" content="Jose Miguel Mora Perez">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- frameworks predefinidos..-->
		<!-- estilo propio.-->
	<title>Ejercicio 2  PHP 5</title>
	<base href="./" target="_blank">
	
</head>

<body>
	<h1>Pasar kilometros a millas</h1>
	<?php
if (!empty($_POST['calcular'])){
    $kms = floatval ($_POST['kms']);
    
    $resultado = floatval( $kms * 0.621371) ;

}
?>
	
	<form method="POST" target="_self">
		<label> Distancia en Kms: </label>
		<input type="number" name="kms" value="<?= $kms ?? '' ?>"> 
		<br>
		<input type="submit" name="calcular" value="Calcular">
	</form>		
	
	<?= empty($resultado) ? '' : "<p>La distancia en millas es de $resultado.</p>"?>

</body>


</html>
