<?php

/** AdminController
 *
 * Controlador para gestiones de adminstrador
 *
 * Última revisión: 16/03/2025
 *
 * @author Jose M Mora Perez<jmmora1974@gmail.com>
 */
#[AllowDynamicProperties] 
class AdminController extends Controller{
	
	/**
	 * Metodo para restaurar la  base de datos
	 * 
	 * @return RedirectResponse
	 */
	public function delete(){
		Auth::admin(); //Solo administradores
		//intenta llamar al procedimiento que restaura la BDD
		try{
			(DB_CLASS)::get()->query ("CALL restore()");
			Session::success("BDD restaurada");
			return redirect('/');
			//si se producen errores
		} catch (SQLException $e){
			Session::success("Se han producido errores");
			return redirect('/');
			
		}
	}
		
}


