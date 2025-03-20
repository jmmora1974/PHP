<?php
//adjunta una nueva cookie a la respuesta 
//esta cookie caducara a lo 5 min
setcookie('curso','aplicacionees web', time()+300);
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF 8">
		<title>Enviando una cookie</title>
	</head>
	<body>
	<p>Cookie "curso" enviada.
	</body>
</html>
