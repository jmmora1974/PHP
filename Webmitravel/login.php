<?php
try
{
	session_start();
	
	//setcookie("isLogged",false,time()+5000);
	if (!empty($_POST['login'])){
		setcookie("isLogged",false,time()-5000);
		//header("Location: login.php", true, 301);
		// Obtenemos los datos por POST, saneamos los datos y comprobamos.
		//TO-DO implementar la seguridad, esta con usuario de pruebas test
		require './libraries/filtrado.php';
		$usuario=filtrado($_POST['usuario']);
		$contrasena=filtrado($_POST['contrasena']);
		
		//Verificamos usuario y contraseña-
		if($usuario&&$usuario=="test"&&$contrasena=="1234"){
			if(empty($_COOKIE['isLogged'])){
				echo "<script>alert( 'Bienvenido $usuario.');</script>";
				
				setcookie("isLogged",true,time()+5000); //Establecemos la COOKIE para la variable de si esta loginado.
				header("Location: login.php", true, 301);
				//redirect("index.php");
				
			}
			
		}else {
			
			setcookie("isLogged",false,time()-5000);
			
			echo "<script>alert( 'El usuario y/o la contraseña no coinciden.');</script>";
			//unset($_COOKIE['isLogged']);
			throw new Exception (" Intento fallido usuario $usuario !");
		}
	}
} catch (Exception $e) {
	//Devuelvela hora actual en formato Y-m-d H:i:s
	function ahora2():string {
		$hora=new DateTime('now');
		return $hora1=$hora->format('Y-m-d H:i:s');
	}
	error_log(ahora2().' - '.$e->getMessage(). PHP_EOL, 3, "error.log");
}
require './templates/template.php';  ?>
<!DOCTYPE html>
<html lang="es">
<?php head(); 
if(empty($_COOKIE['consentimiento']))
	aceptarCookies();
	
cabecera('&#9807;Mitravel','Planifica tus aventuras');?>

		<body>
	 	<?php
	 	
	 	
	 	//Si llega a esta página es porque no está loginado, nos aseguramos de que la cookie está desactivada.
	 	//setcookie("isLogged",false,time()-5000);
	 	menu ("Login");
	 	
		?>
		
		<h2>Pantalla de Login...</h2>
		<form method="POST" target="_self">
			<label for="usuario">Usuario:</label>
			<input type="text" name="usuario" min=4>
			<br>
			<label for="contrasena">Contraseña:</label>
			<input type="password" name="contrasena" min=4>
			<br>
			<input type="submit" value="login" name="login">
			<p>Si aún no estás registrado..<a href="register.php">Pulsa aquí</a>
		</form>
	
</body>


</html>