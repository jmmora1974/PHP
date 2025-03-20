<?php
//comprueba que llega el formulario de confirmación de borrado
if(empty($_POST['confirmarborrado']))
	throw new FormException("No se recibió la confirmación.");

	//recupera el libro a partir del ID (OJO va po POST)
	$libro = Libro::findOrFail(intval($_POST['id']),"No se encontró el libro");
	
	//borra el libro
	$libro->deleteObject();
	
	//prepara el mensaje y muestra la vista de exito
	$mensaje = "Borrado del libro $libro->titulo, de $libro->autor correcto.";
	require '../views/libro/exito.php'; //Mostrar éxito