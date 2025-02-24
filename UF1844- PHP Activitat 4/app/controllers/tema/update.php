<?php
//Comprueba que llega el formulario
if(empty($_POST['actualizar']))
	throw new FormException('No se recibió el formulario');

	//recuèra el tema a partir del ID POST
	$tema = Tema::findOrFail(intval($_POST['id']),'No se ha enconttrado el tema.');
	
	require '../libraries/filtrado.php'; //función de saneamiento básico
	//actualiza los campos de tema con los datos del formulario	
	$tema->tema 		= filtrado($_POST['tema']);
	$tema->descripcion 		= filtrado($_POST['descripcion']);

	
	
	$tema->update(); //actualiza el tema en la BDD
	
	//prepara un mensaje y carga la vista de exito
	$mensaje = "Actualización del tema $tema->tema correcto.";
	require '../views/exito.php';
	