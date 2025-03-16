<?php
//adjunta una nueva cookie a la respuesta 
//esta cookie caducara a lo 5 min
setcookie('curso','', time()+5000);
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF 8">
		<title>Eliminando una cookie</title>
	</head>
	<body>
	<p>Comprueba que ya no este </p>
	</body>
</html>
