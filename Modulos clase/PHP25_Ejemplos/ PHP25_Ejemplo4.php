<?php
//crea una conexión PERSISTENTE con la BDD biblioteca
$conexion = new mysqli('p:localhost','root','','biblioteca');

//establece la codificación de caracteres a UTF-8
$conexion->set_charset('utf8');

echo "<p> La conexión se ha establecido correctamente.</p>";

//una vez conectado, hacemos consultas a la bdd
//....
// cerrar la conexión (opcional, solo es necesario en conexiones persistentes=
$conexion->close();