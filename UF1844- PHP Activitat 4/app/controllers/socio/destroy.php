<?php
//comprueba que llega el formulario de confirmación de borrado
if(empty($_POST['confirmarborrado']))
	throw new FormException("No se recibió la confirmación.");
	
	//recupera el socio a partir del ID (OJO va po POST)
	$socio = Socio::findOrFail(intval($_POST['id']),"No se encontró el socio.");
	
	//comprueba si el libro tiene ejemplares o no
	if($socio->hasAny('Prestamo'))
		throw new Exception('No se puede borrar un socio si tiene prestamos.');
		
	
	//borra el socio
	$socio->deleteObject();
	
	//prepara el mensaje y muestra la vista de exito
	$mensaje = "Borrado del socio $socio->id,  $socio->nombre correcto.";
	require '../views/exito.php'; //Mostrar éxito