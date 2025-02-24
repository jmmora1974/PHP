<?php 
//PARAMETROS DE CONFIGURACION DE AUTOLOAD
define('AUTOLOAD_DIRECTORIES', [
		'../models',
		'../exceptions',
		'../libraries',
		'../controllers'
]);

//CONTROLADOR POR DEFECTO
define ('DEFAULT_CONTROLLER','welcome');

//PARAMETROS DE CONFIGURACION DE LA BDD
define('DB_HOST','fdb1028.awardspace.net');  //host
define('DB_USER','4557637_bibliotecajm');  		//usuario
define('DB_PASS','toor2025');			//password
define('DB_NAME','4557637_bibliotecajm');  //base de datos
define('DB_PORT', 3306);		//puerto
define('DB_CHARSET','utf8');	//codificacion

//Clase DB que usará nuestro ORM (dependera del curso)
define('DB_CLASS', 'DBMysqli'); //puede ser DB o DBPDO
define('SGDB', 'mysql'); //driver de PDO (solo para DBPDO)

//OTROS PARAMETROS
define('DEBUG', false);  //para la depuración