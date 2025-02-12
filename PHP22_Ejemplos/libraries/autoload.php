<?php
//funcion usada para buscar clases
function load (String $clase){
	
	//Para cada doirectorio de la lista
	foreach (AUTOLOAD_DIRECTORIES as $directorio){
		$ruta = "$directorio/$clase.php";   //calcula la ruta
		
		if (is_readable($ruta)){
			require_once $ruta;
			break;
		}
	}
}

//registrar la funcion autoload anterior
spl_autoload_register('load');