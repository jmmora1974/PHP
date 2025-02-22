<?php
//Comprueba que llega el formulario
if(empty($_POST['actualizar']))
	throw new FormException('No se recibió el formulario');

	//recuèra el libro a partir del ID POST
	$libro = Libro::findOrFail(intval($_POST['id']),'No se ha enconttrado el libro.');
	
	require '../libraries/filtrado.php'; //función de saneamiento básico
	//actualiza los campos de libro con los datos del formulario	
	$libro->isbn 		= filtrado($_POST['isbn']);
	$libro->titulo 		= filtrado($_POST['titulo']);
	$libro->editorial 		= filtrado($_POST['editorial']);
	$libro->autor 		= filtrado($_POST['autor']);
	$libro->idioma 		= filtrado($_POST['idioma']);
	$libro->edicion 		= intval($_POST['edicion']);
	$libro->edadrecomendada 		=intval($_POST['edadrecomendada']);
	
	
	$libro->update(); //actualiza el libro en la BDD
	
	//prepara un mensaje y carga la vista de exito
	$mensaje = "Actualización del libro $libro->titulo correcto.";
	require '../views/libro/exito.php';
	