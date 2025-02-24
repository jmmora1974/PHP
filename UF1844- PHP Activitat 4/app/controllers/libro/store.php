<?php

//Comprueba que llega el formulario
if(empty($_POST['guardar']))
	throw new FormException('No se recibió el formulario');

	//crea un nuevo libro y toma sus valores del POST
	$libro = new Libro();
	require '../libraries/filtrado.php'; //función de saneamiento básico
	
	$libro->isbn 		= filtrado($_POST['isbn']);
	$libro->titulo 		= filtrado($_POST['titulo']);
	$libro->editorial 		= filtrado($_POST['editorial']);
	$libro->autor 		= filtrado($_POST['autor']);
	$libro->idioma 		= filtrado($_POST['idioma']);
	$libro->edicion 		= intval($_POST['edicion']);
	$libro->edadrecomendada 		=intval($_POST['edadrecomendada']);
	
	
	$libro->save(); //guarda el libro
	
	//prepara un mensaje y carga la vista de exito
	$mensaje = "Guardado del libro $libro->titulo correcto.";
	require '../views/exito.php';
	