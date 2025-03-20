<?php
//adjunta una nueva cookie a la respuesta 
//esta cookie caducara a lo 5 min
setcookie('centro','CIFO Sabadell', time()+300);
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF 8">
		<title>consideraciones  una cookie</title>
	</head>
	<body>
	<h2>La cookie curso</h2>
	
	<p>Cuando se crea la cookie se envia y aun no esta creada hasta que actualizamos y llega la respusta del servidor. </p>
	
	
	<?=$_COOKIE['centro'] ?? '<p> La cookie aun no ha llegado</p>' ?>
	</body>
</html>
