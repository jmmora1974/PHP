<?php
/*
* LibroController
* 
* Operaciones con los linros
* 
* @author Jose Miguel Mora Perez
*/
class LibroController extends Controller{
	
	/**
	 * Método por defecto
	 * 
	 * Redirige al método list() de este mismo controlador.
	 * 
	 * @return viewResponse
	 */
	public function index(){
		return $this->list();
	}
	
	/**
	 * Listado de libros
	 * 
	 */
	public function list(){
		$libros = Libro::orderBy(); //recupera todos los linros
		//carga lavista que lso muestra
		return view('libro/list',[$libros=>$libros]);
		
	}

	/**
	 * Muestra los detalles de un libro
	 *  @param int $id identificador del libro a mostrar
	 *  @return ViewResponse
	 */
	public function show(int $id=0){
		
		$libro = Libro::findOrFail($id, "No se encontró el libro indicado.");
		
		//carga la vista y le pasa el libro
		return view('libro/show'.['libro'=>$libro]);
	}
	
	/**
	 * Muestra el formulario de nuevo libro
	 * @return View('libro/create');
	 */
	
	public function create (){
		return view(libro/create);
	}
}
