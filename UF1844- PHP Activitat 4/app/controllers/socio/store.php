<?php
//Comprueba que llega el formulario
if(empty($_POST['guardar']))
	throw new FormException('No se recibió el formulario');

	//crea un nuevo socio y toma sus valores del POST
	$socio = new Socio();
	
	require '../libraries/filtrado.php'; //función de saneamiento básico
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
	$socio->foto 		=  filtrado($_POST['foto']);
	$socio->conformidad 		= filtrado($_POST['conformidad']);

	
	
	
	$socio->save(); //guarda el socio
	
	//prepara un mensaje y carga la vista de exito
	$mensaje = "Guardado del socio $socio->nombre  $socio->apellidos  correcto.";
	require '../views/exito.php';
	