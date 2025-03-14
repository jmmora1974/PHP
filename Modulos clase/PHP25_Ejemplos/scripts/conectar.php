<?php
try{
	//conecta y establece el charsett en funcion de los
	//parametros indicados en el fichero de configuración.
	$conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
	//establece el charset
	$conexion->set_charset('utf8');
	
}catch(Exception $e){
	// si se produce error al conectar...
	die('Error al conectar con la BDD.');
}