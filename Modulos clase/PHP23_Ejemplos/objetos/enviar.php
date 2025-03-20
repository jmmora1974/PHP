<?php
include 'Producto.php';

$objetos=[];
$objetos[] = new Producto ('Cafe',2.75);
$objetos[] = new Producto ('Gallestas',2);
$objetos[] = new Producto ('Leche',0.85);

//adjunta la cookie
setcookie('carro', serializable($objetos), time()+300);

?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF 8">
		<title>Enviando una cookie</title>
	</head>
	<body>
	<p>Cookie "carro" enviada.
	</body>
</html>
