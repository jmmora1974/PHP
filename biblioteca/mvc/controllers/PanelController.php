<?php
/**
* PanelController
* 
* Panel de operaciones del bibliotecario 
* 
* @autor Jose Miguel Mora Perez ® CIFO Valles 2025®
*/

class PanelController extends Controller{
	
	/**
	 * Mérodo por defecto
	 * 
	 * Redirige al método panel() de este mismo controlado.
	 * 
	 * @return ViewResponse
	 */
	public function index(){
		return $this->panel();
	}
	
	
	/**
	 * Panel de bibliotecario
	 *Retorna la vista con las operaciones del bibliotecario
	 *
	 * @return ViewResponse
	 *
	 */
	public function panel(){
		
		//	carga la vista que los muestra
		return view('panel/panel',[]);
		
	}
}