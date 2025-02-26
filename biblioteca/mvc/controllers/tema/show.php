<?php
	//Recupera el tema a partir del ID.
	// si no llega ID o si no se envuentra lanza una excepcion
	$tema = Tema::findOrFail(intval($_GET['id']),'No se envontró el tema');
	
		
// carga la vista de detealles del tema
require '../views/tema/detalles.php';