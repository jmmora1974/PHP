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
	public function show(int $id=0) {
		
		
		$libro = Libro::findOrFail($id, 'No se enontró el libro indicado');
		
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
	
	/**
	 * Guarda los datos que llegan del formulario en la bdd
	 * 
	 * @ redirect Viewresponse
	 */
	public function store(){
		//Comprueba que la petición venga del formulario
		if(!request()->has('guardar'))
			thro
	}
	 
}