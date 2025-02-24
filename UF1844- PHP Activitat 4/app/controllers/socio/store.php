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
	$socio->conformidad 		= filtrado($_POST['conformidad']);

	
	require_once '../libraries/Upload.php';
	
	// Establecemos la ruta donde guardar la foto de perdil.
	//Quedan almacenadas en una carpeta privada fuera de la public. 
	//Preferiblemente se podrían clasificar por carpetas para cada socio.
	//Comprobamos si existe la carpeta actividad, si no la crea nueva.
	$rutadestino="../imagenes/prf/";  
	
	
	//OJO ... es inseguro por el momento para la practica es válido,
	// pero se ha de sanear y securizar
	if(!file_exists($rutadestino)){
		mkdir($rutadestino, 0764);
	}
	
	//Sube el fichero, hace las omprobaciones y retorna la ruta
	$ruta = Upload::save(
				'fichero',   // clave de $_FILES(nombre del input)
				$rutadestino, //carpeta destino
				true,       //generar nombre único
				500000,     //tamaño maximo
				'image/*',   //tipo MIME(* es el comodin)
				'img_',    //prefijo para el nombre generado
				true        //retornar la ruta completa
	);
				
	
	$socio->foto 	=  filtrado($ruta);
	
	
	$socio->save(); //guarda el socio
	
	//prepara un mensaje y carga la vista de exito
	$mensaje = "Guardado del socio $socio->nombre  $socio->apellidos  correcto.";
	require '../views/exito.php';
	