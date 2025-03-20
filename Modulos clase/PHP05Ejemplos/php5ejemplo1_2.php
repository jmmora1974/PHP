
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="keywords" content="HTML, CSS, JavaScript">
	<meta name="description"
		content="Web de ejemplo PHP 5 ej 1">
	<meta name="author" content="Jose Miguel Mora Perez">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- frameworks predefinidos..-->
		<!-- estilo propio.-->
	<title>Ejemplo1  PHP 5</title>
	<base href="./" target="_blank">
	
</head>

<body>
	<h1>Calculadora de notas</h1>
	
	<form method="POST">
		<label> Teoria: </label>
		<input type="number" name="teoria">
		<br>
		<label> Práctica: </label>
		<input type="number" name="practica">
		<br>
		<input type="submit" name="calcular" value="Calcular">
	</form>		
<?php
if (!empty($_POST['calcular'])){
    $teoria = floatval ($_POST['teoria']);
    $practica= floatval ($_POST['practica']);
    $resultado = $teoria * 0.3+$practica*0.7;
    echo "<p> Tu nota es : $resultado </p>";
}
?>
</body>


</html>
