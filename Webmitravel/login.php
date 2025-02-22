<?php
require './templates/template.php';
?>
<!DOCTYPE html>
<html lang="es">
<?php head(); 
cabecera('&#9807;Mitravel','Planifica tus aventuras');?>
		<body>
		<?php menu ("Portada")?>
		<h2>Pantalla de Login...</h2>
		<form method="POST" action="index.php?controlador=acceso">
			<label for="usuario">Usuario:</label>
			<input type="text" name="usuario" min=4>
			<br>
			<label for="contrasena">Contraseña:</label>
			<input type="password" name="contrasena" min=4>
			<br>
			<input type="submit" value="login">
		</form>
	
</body>


</html>