<?php
    
/** UserController
 *
 * Gestiona la operación de usarios
 *
 * Última revisión: 09/01/2025
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * @autor Jose Miguel Mora <jmmora1974@gmail.com>
 */

class UserController extends Controller{
    
    
    /**
     * Carga la vista "home" para el usuario identificado
     * 
     * @return ViewResponse
     */
    public function home():Response{
        
    	Auth::check(); // autorización(solo usuarios identificados
		
    	//carga la vista home y le pasa el usuario idenntificado
    	// el usuario se puede recuperar mediante el metodo Login::user()
    	return view('user/home', ['user'=>Login::user()]);
    }
}


