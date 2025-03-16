<?php
//Comprueba que llega el formulario
if(empty($_POST['guardar']))
	throw new FormException('No se recibió el formulario');

	//crea un nuevo libro y toma sus valores del POST
	$libro = new Libro();
	
	$libro->isbn 		= $_POST['isbn'];
	$libro->titulo 		= $_POST['titulo'];
	$libro->editorial 		= $_POST['editorial'];
	$libro->autor 		= $_POST['autor'];
	$libro->idioma 		= $_POST['idioma'];
	$libro->edicion 		= intval($_POST['edicion']);
	$libro->edadrecomendada 		=intval($_POST['edadrecomendada']);
	
	
	$libro->save(); //guarda el libro
	
	//prepara un mensaje y carga la vista de exito
	$mensaje = "Guardado del libro $libro->titulo correcto.";
	require '../views/libro/exito.php';
	