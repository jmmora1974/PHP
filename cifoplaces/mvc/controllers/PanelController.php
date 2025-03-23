<?php
/**
* PanelController
* 
* Panel de operaciones del administrador 
* 
* @autor Jose Miguel Mora Perez ® CIFO Valles 2025®
*/
#[AllowDynamicProperties] 
class PanelController extends Controller{
	
	/**
	 * Mérodo por defecto
	 * 
	 * Redirige al método panel() de este mismo controlado.
	 * 
	 * @return ViewResponse
	 */
	public function index(){
		// autorización(solo Moderadores)
		if( Login::role('ROLE_MODERADOR')) { 
			return $this->panel();
		}
		// autorización(solo Administradores)
		if( Login::role('ROLE_ADMIN')) {
			return $this->admin();
		}
		//En caso de no se bibliotecario, redirige al inicio
		return redirect('/');
		
	}
	
	
	/**
	 * Panel de moderador
	 *Retorna la vista con las operaciones del moderador
	 *
	 * @return ViewResponse
	 *
	 */
	public function panel(){
		return view('panel/panel',[]);
		// autorización(solo moderadores
		if( Login::role('ROLE_MODERADOR')) { 
			//	carga la vista que los muestra
			return view('/panel/panel',[]);
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