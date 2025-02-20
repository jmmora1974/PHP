<?php
session_start();
require_once '../config/config.php';
require_once '../auoload.php';

try{
	//si llega el controlador por URL lo cargará 
	//en caso contrario, cargará por degfecto el indicado en config.php
	@require '../controllers/'.($_GET['controlador'] ?? DEFAULT_CONTROLLER).'.php';
	
	//si se produce un error
} catch(Throwable $e){
	$mensaje =$e->getMessage();
	require '../views/error.php';
}

 