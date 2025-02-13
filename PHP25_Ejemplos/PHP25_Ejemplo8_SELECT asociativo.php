<?php
//crea una conexión PERSISTENTE con la BDD biblioteca
$conexion = new mysqli('p:localhost','root','','biblioteca');

//establece la codificación de caracteres a UTF-8
$conexion->set_charset('utf8');

//echo "<p> La conexión se ha establecido correctamente.</p>";


//preparamos y lanzamos la consulta de seleccion
$consulta = "SELECT * FROM libros WHERE id=1";
$resultado=$conexion->query($consulta);

//si hay resultado
if($resultado->num_rows){
	
	//recuperamos el resultado a modo de array asociativo
	$libro = $resultado->fetch_assoc();
	$resultado->free();  //libera la memoria  IMPORTANTE
	
	//muestra la estructura de $libro
	echo "<pre>";
	var_dump($libro);
	echo "</pre>";
} else{
	echo "NO se encontró el libro deseado.";
}



// $conexion->close();  se recomienda no cerrarla, que sea el mismo PHP que l ogestiones