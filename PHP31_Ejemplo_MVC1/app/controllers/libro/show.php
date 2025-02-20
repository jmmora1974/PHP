<?php



  //VERSION A
  /*
// comprueba si llega el ID del libro por la URL
if(empty($_GET['id']))
	throw new NothingToFindException("Falta el id del libro,");

	$id=intval($_GET['id']); //toma el id 
	
	//recupera el libro y comprueba que existe
	if (empty($libro= Libro::find($id)))
		throw new NotFoundException("No existe el libro $id.");
	
	todo esto se resumen en la linea siguietne
	*/
	

	 //VERSION B
	 
	//Recupera el libro a partir del ID.
	// si no llega ID o si no se envuentra lanza una excepcion
	$libro = Libro::findOrFail(intval($_GET['id']),'No se envontró el libro');
	
		
// carga la vista de detealles del libro
require '../views/libro/detalles.php';