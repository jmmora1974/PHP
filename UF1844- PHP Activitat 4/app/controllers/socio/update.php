<?php
//Comprueba que llega el formulario
if(empty($_POST['actualizar']))
	throw new FormException('No se recibió el formulario');

	//recupera el sociio a partir del ID POST
	$socio = Socio::findOrFail(intval($_POST['id']),'No se ha enconttrado el libro.');
	
	require '../libraries/filtrado.php'; //función de saneamiento básico
	//actualiza los campos de socio con los datos del formulario	
	
	$socio->nombre 		= filtrado($_POST['nombre']);
	$socio->apellidos 		= filtrado($_POST['apellidos']);
	$socio->dni 		= filtrado($_POST['dni']);
	$socio->nacimiento 		= filtrado($_POST['nacimiento']);
	$socio->email 		= filtrado($_POST['email']);
	$socio->direccion 		= filtrado($_POST['direccion']);
	$socio->cp 		= filtrado($_POST['cp']);
	$socio->poblacion 		= filtrado($_POST['poblacion']);
	$socio->provincia 		= filtrado($_POST['provincia']);
	$socio->telefono 		=intval($_POST['telefono']);
	$socio->conformidad 		= filtrado($_POST['conformidad']);
	
	$socio->update(); //actualiza el libro en la BDD
	
	//prepara un mensaje y carga la vista de exito
	$mensaje = "Actualización del socio $socio->nombre  $socio->apellidos correcto.";
	require '../views/exito.php';
	