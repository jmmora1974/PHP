<?php
//crea una conexión PERSISTENTE con la BDD biblioteca
$conexion = new mysqli('p:localhost','root','','biblioteca');

//establece la codificación de caracteres a UTF-8
$conexion->set_charset('utf8');

//echo "<p> La conexión se ha establecido correctamente.</p>";


//preparamos una consulta de borrado
$consulta = "DELETE FROM libros
		WHERE titulo='La historia interminable'";

//ejecuta la consuñta que acabamos de preparar
$conexion->query($consulta);

//Muestra resultado
echo "<p>Borrado de  $conexion->affected_rows filas OK</p>";




// $conexion->close();  se recomienda no cerrarla, que sea el mismo PHP que l ogestiones