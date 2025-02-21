<?php
//comprueba que llega el formulario de confirmación de borrado
if(empty($_POST['confirmarborrado']))
	throw new FormException("No se recibió la confirmación.");
	
	//recupera el socio a partir del ID (OJO va po POST)
	$socio = Socio::findOrFail(intval($_POST['id']),"No se encontró el socio");
	
	//borra el socio
	$socio->deleteObject();
	
	//prepara el mensaje y muestra la vista de exito
	$mensaje = "Borrado del socio $socio->id,  $socio->nombre correcto.";
	require '../views/socio/exito.php'; //Mostrar éxito