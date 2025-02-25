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
}