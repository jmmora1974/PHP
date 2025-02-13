<?php
//crea una conexión PERSISTENTE con la BDD biblioteca
$conexion = new mysqli('p:localhost','root','','biblioteca');

//establece la codificación de caracteres a UTF-8
$conexion->set_charset('utf8');

//echo "<p> La conexión se ha establecido correctamente.</p>";


//prepara una consulta de inserción en un string (recomendado)
//es util se tennemos que depurar porque podremo hacer echo $consulta para
// visualiza los errores, incluso podremos copiear y pegar enm el workbech
$consulta = "UPDATE libros
		SET titulo='La historia interminable'
		WHERE titulo='Neverending Story'";

//ejecuta la consuñta que acabamos de preparar
$conexion->query($consulta);

//Muestra resultado
echo "<p>La actualización de  $conexion->affected_rows filas OK</p>";




// $conexion->close();  se recomienda no cerrarla, que sea el mismo PHP que l ogestiones