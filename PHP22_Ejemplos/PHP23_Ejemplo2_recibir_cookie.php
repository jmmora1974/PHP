
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF 8">
		<title>Recuperando una cookie</title>
	</head>
	<body>
	<h2>La cookie curso</h2>
	
	<p>Si has solicitado antes el fichero "enviar.php", tendrás 
	la cookie "curso", en caso contrario no la tendras. </p>
	
	<p> Si la tienes, en actualzia varias veces la pagina para comprobar que la sigues teniendo. Luego borra la cookie y refrescas.</p>
	
	
	<?=$_COOKIE['curso'] ?? '<p> La cookie no existe</p>' ?>
	</body>
</html>
