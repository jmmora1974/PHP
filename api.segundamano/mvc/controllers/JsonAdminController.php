<?php

/** JsonAdminController
 *
 * Controlador para gestiones de adminstrador
 *
 * Última revisión: 16/03/2025
 *
 * @author Jose M Mora Perez<jmmora1974@gmail.com>
 */

class JsonAdminController extends Controller{
	
	/**
	 * Metodo para restaurar la  base de datos
	 * 
	 * @return JsonResponse
	 */
	public function delete(){
		
		//intenta llamar al procedimiento que restaura la BDD
		try{
			(DB_CLASS)::get()->query ("CALL restore()");
			return new JsonResponse([],"BDD restaurada",   200, "OK");
			//si se producen errores
		} catch (SQLException $e){
			return new JsonResponse([], "Se han producido errores",   200, "WITH ERRORS");
		}
	}
		
}


