<?php
/**
* LibroController
* 
* Operaciones con los libros
* 
* @autor Jose Miguel Mora Perez ® CIFO Valles 2025®
*/

class LibroController extends Controller{
	
	/**
	 * Mérodo por defecto
	 * 
	 * Redirige al método list() de este mismo controlado.
	 * 
	 * @return ViewResponse
	 */
	public function index(){
		return $this->list();
	}
	
	/** 
	 * Listado de libros
	 * 
	 * @return ViewResponse
	 * 
	 */
	public function list(){
		$libros = Libro::orderBy();  //sale ordenado
	
		//	carga la vista que los muestra
		return view('libro/list',['libros'=>$libros]);
	}
	
	/**
	 * Muestra los detalles del un libro
	 * @param int $id identificador del libro a mostrar
	 * @return ViewResponse
	 */
	public function function_name($param) {
		
		//Comprueba que llega el ID
		if(!$id)
			throw new NothingToFindException ('No se indicó el libro a buscar');
		
		$libro = Libro::find($id); //busca el libro con ese ID
		
		//Comprueba que existe ese libro
		if(!$libro)throw new NotFoundException('No se enontró el libro indicado');
		
		// carga la vista y le pasa el libro recuperado
		return view ('libro/show',['libro'=>$libro]);
		
	}
	
	/**
	 * Muestra el formulario de nuevo libro
	 * @return ViewResponse
	 */
	public function create(){
		return view('libro/create');
	}
	 
}