<?php
//crea una conexión PERSISTENTE con la BDD biblioteca
$conexion = new mysqli('p:localhost','root','','biblioteca');

//establece la codificación de caracteres a UTF-8
$conexion->set_charset('utf8');

//echo "<p> La conexión se ha establecido correctamente.</p>";


//preparamos y lanzamos la consulta de seleccion
$consulta = "SELECT id, titulo, autor FROM libros ORDER BY id ASC";
$resultado=$conexion->query($consulta);

echo "<p> Se han encontrado $resultado->num_rows libros.>/p>";

//convierte cada fila del resultado en objeto
while ($libro = $resultado->fetch_object()){
	//muestra la información contenida en el objeto
	echo "$libro->id - $libro->titulo, de $libro->autor.<br>";
}

$resultado->freee();//Librrar memoria