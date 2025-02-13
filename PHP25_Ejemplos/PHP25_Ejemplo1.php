<?php
//crea una conexión con la BDD biblioteca
$conexion = new mysqli('localhost','root','','biblioteca');

//el usuario root sin password existe por defecto en xampp
//lo usaremos para desarrollo y pruebas
// en produccion nunca lo tendremos asi

//establece la codificación de caracteres a UTF-8
$conexion->set_charset('utf8');

echo "<p> La conexión se ha establecido correctamente.</p>";