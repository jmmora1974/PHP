<?php
//Comprueba que llega el formulario
if(empty($_POST['guardar']))
	throw new FormException('No se recibió el formulario');

	//crea un nuevo socio y toma sus valores del POST
	$socio = new Socio();
	
	$socio->nombre 		= $_POST['nombre'];
	$socio->apellidos 		= $_POST['apellidos'];
	$socio->dni 		= $_POST['dni'];
	$socio->nacimiento 		= $_POST['nacimiento'];
	$socio->email 		= $_POST['email'];
	$socio->direccion 		= $_POST['direccion'];
	$socio->cp 		= $_POST['cp'];
	$socio->poblacion 		= $_POST['poblacion'];
	$socio->provincia 		= $_POST['provincia'];
	$socio->telefono 		=intval($_POST['telefono']);
	$socio->foto 		=  $_POST['foto'];
	$socio->conformidad 		= $_POST['conformidad'];

	
	
	
	$socio->save(); //guarda el socio
	
	//prepara un mensaje y carga la vista de exito
	$mensaje = "Guardado del socio $socio->nombre  $socio->apellidos  correcto.";
	require '../views/socio/exito.php';
	