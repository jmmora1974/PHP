<?php
/**
* PanelController
* 
* Panel de operaciones del administrador 
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
		// autorización(solo bibliotecarios
		if( Login::role('ROLE_ADMIN')) { 
			return $this->panel();
		}
		//En caso de no se bibliotecario, redirige al inicio
		return redirect('/');
		
	}
	
	
	/**
	 * Panel de bibliotecario
	 *Retorna la vista con las operaciones del bibliotecario
	 *
	 * @return ViewResponse
	 *
	 */
	public function panel(){
		// autorización(solo bibliotecarios
		if( Login::role('ROLE_LIBRARIAN')) { 
			//	carga la vista que los muestra
			return view('panel/panel',[]);
		}
		//En caso de no se bibliotecario, redirige al inicio
		return redirect('/');
	}
	/**
	 * Panel de administrador
	 *Retorna la vista con las operaciones del administrador
	 *
	 * @return ViewResponse
	 *
	 */
	public function admin(){
		Auth::admin(); 
			//Solo administradores
		
		//	carga la vista que los muestra
		return view('panel/admin',[]);
		
		
	}
}