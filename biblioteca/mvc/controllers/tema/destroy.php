<?php
//comprueba que llega el formulario de confirmación de borrado
if(empty($_POST['confirmarborrado']))
	throw new FormException("No se recibió la confirmación.");

	//recupera el tema a partir del ID (OJO va po POST)
	$tema = Tema::findOrFail(intval($_POST['id']),"No se encontró el tema");
	
	//comprueba si el tema tiene ejemplares o no
	if($tema->hasAny('TemaLibro'))
		throw new Exception('No se puede borrar un tema si existen libros de ese tema.');
	
	//borra el tema
	$tema->deleteObject();
	
	//prepara el mensaje y muestra la vista de exito
	$mensaje = "Borrado del tema $tema->tema  correcto.";
	require '../views/exito.php'; //Mostrar éxito