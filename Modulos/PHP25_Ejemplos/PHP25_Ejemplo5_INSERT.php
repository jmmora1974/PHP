<?php
//crea una conexión PERSISTENTE con la BDD biblioteca
$conexion = new mysqli('p:localhost','root','','biblioteca');

//establece la codificación de caracteres a UTF-8
$conexion->set_charset('utf8');

echo "<p> La conexión se ha establecido correctamente.</p>";


//prepara una consulta de inserción en un string (recomendado)
//es util se tennemos que depurar porque podremo hacer echo $consulta para
// visualiza los errores, incluso podremos copiear y pegar enm el workbech
$consulta = "INSERT INTO libros(
		isbn, titulo, editorial, idioma, 
		autor, edicion, edadrecomendada
	)VALUES(
		'123456','Neverending Story','Alfaguara','English',
		'Michael Ende', 5, 3)";

//ejecuta la consuñta que acabamos de preparar
$conexion->query($consulta);

//Muestra resultado
echo "<p>Todo OK, el ID del registro es $conexion->insert_id.</p>";




// $conexion->close();  se recomienda no cerrarla, que sea el mismo PHP que l ogestiones