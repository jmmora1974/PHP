
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="keywords" content="HTML, CSS, JavaScript">
	<meta name="description"
		content="Web deejemplo PHP">
	<meta name="author" content="Jose Miguel Mora Perez">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- frameworks predefinidos..-->
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- estilo propio.-->
	<link rel="stylesheet" href="./css/estilo.css">
	<title>Ejemplo PHP</title>
	<link rel="icon" type="image/x-icon" href="./images/favicon.ico">
	<base href="./" target="_blank">
	
</head>

<body>

	<header class="flex-container header">
		<figure id="logo" class="text-start  logo">
			<a href="index.html" class="flex1" target="_self"><img src="./images/logomitravel.png" alt="Logo Mitravel"
					style="width:100px;height:100px"></a>
		</figure>
		<hgroup class="flex1">
			<h1 class="text-center">Ejemplo 1</h1>
			
		</hgroup>
		<div class="search-container">
			<form action="/action_page.php">
				<input type="text" placeholder="Search.." name="search">
				<button type="submit"><i class="fa fa-search"></i></button>
			</form>
		</div>
		<form id="formlogin" class="flex1 text-end" action="/action_page.php">
			<fieldset>
				<input type="text" id="usuariologin" placeholder="Escribe tu usuario" name="usuario">
				<input type="password" id="pwdlogin" placeholder="Entra la contraseña" name="pswd">
			</fieldset>
			<fieldset>
				<label>
					<input type="checkbox" name="remember"> Remember me
				</label>
				<button type="submit" class="btn-login">Login</button>
				<p>Registrate <a href="register.html" target="_self">aquí</a></p>
			</fieldset>
		</form>
	</header>
	

	<main>
		<h1>Ejemplo imprimiendo</h1>
		<form action="accion.php" method="post">
 <p>Su nombre: <input type="text" name="nombre" /></p>
 <p>Su edad: <input type="text" name="edad" /></p>
 <p><input type="submit" /></p>
</form>
		</main>
	<div class="w3-container w3-teal">

		<details>

			<summary>
				<b>EjemplPHP ®</b>. Web para planificar tus aventuras.
				@author:Jose Miguel Mora Perez® CIFO 2024
				<i class="fa fa-copyright" aria-hidden="true"></i><i class="fa fa-envelope-o" aria-hidden="true"></i>

			</summary>

		</details>
	</div>
	
	Hola <?php echo htmlspecialchars($_POST['nombre']); ?>.
Usted tiene <?php echo (int)$_POST['edad']; ?> años.


</body>

</html>