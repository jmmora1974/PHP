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
define('DB_HOST','localhost');  //host
define('DB_USER','root');  		//usuario
define('DB_PASS','');			//password
define('DB_NAME','biblioteca');  //base de datos
define('DB_PORT', 3306);		//puerto
define('DB_CHARSET','utf8');	//codificacion

//Clase DB que usará nuestro ORM (dependera del curso)
define('DB_CLASS', 'DBMysqli'); //puede ser DB o DBPDO
define('SGDB', 'mysql'); //driver de PDO (solo para DBPDO)

//OTROS PARAMETROS
define('DEBUG', true);  //para la depuración