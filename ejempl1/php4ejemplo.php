
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="keywords" content="HTML, CSS, JavaScript">
	<meta name="description"
		content="Web de ejemplo PHP">
	<meta name="author" content="Jose Miguel Mora Perez">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- frameworks predefinidos..-->
		<!-- estilo propio.-->
	<title>Ejemplo PHP</title>
	<base href="./" target="_blank">
	
</head>

<body>
	<h1>La variable superglobal %_SERVER</h1>
	
	<p>$_SERVER contine la información del servidor y datos d l cliente	</p>

		
<?php
    //Navregador cliente 
    echo "Tu navegador : ".$_SERVER['HTTP_USER_AGENT']."<br>";
    
    //IP
    echo "Tu IP : " .$_SERVER['REMOTE_ADDR']."<br>";
    
    //software del servidor 
    echo "Software del servidor : " .$_SERVER['SERVER_SOFTWARE']."<br>";
    
    echo "<PRE>";
    var_dump($_SERVER);
    echo "</PRE>";
?>
</body>


</html>
