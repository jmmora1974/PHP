<?php

//Comprueba que llega el formulario
if(empty($_POST['guardar']))
	throw new FormException('No se recibió el formulario');

	//crea un nuevo tema y toma sus valores del POST
	$tema = new Tema();
	require '../libraries/filtrado.php'; //función de saneamiento básico
	
	$tema->tema 		= filtrado($_POST['tema']);
	$tema->descripcion 		= filtrado($_POST['descripcion']);
		
	
	$tema->save(); //guarda el tema
	
	//prepara un mensaje y carga la vista de exito
	$mensaje = "Guardado del tema $tema->tema correcto.";
	require '../views/exito.php';
	