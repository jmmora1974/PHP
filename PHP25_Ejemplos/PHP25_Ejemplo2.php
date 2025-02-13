<?php

//este ejemplo es para versiones PH anteriores a la 8.1

//crea una conexión con la BDD biblioteca
$conexion = @new mysqli('localhost','root','','biblioteca');

//si no se pudo conectar ...
if($conexion->connect_errno)
	throw new Exception("ERROR al conectar: ".$conexion->connect_errno);

	
//establece la codificación de caracteres a UTF-8
$conexion->set_charset('utf8');

echo "<p> La conexión se ha establecido correctamente.</p>";