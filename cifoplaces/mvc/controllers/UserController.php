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
#[AllowDynamicProperties] 
class UserController extends Controller{
    
    
    /**
     * Carga la vista "home" para el usuario identificado
     * 
     * @return ViewResponse
     */
    public function home():Response{
        
    	Auth::check(); // autorización, solo usuarios identificados
		$lugares=Lugar::getFiltered('iduser',user()->id);
    	//carga la vista home y le pasa el usuario idenntificado
    	// el usuario se puede recuperar mediante el metodo Login::user()
    	return view('user/home', ['user'=>Login::user(),'lugares'=>$lugares]);
    }
    
    /**
     * Mérodo por defecto
     *
     * Redirige al método list() de este mismo controlado.
     *
     * @return ViewResponse
     */
    public function index(){
   		
    	//Auth::admin(); // autorización(solo administradores)
    	return $this->list();
    }
    
    /**
     * Listado de usuarios
     *
     * @return ViewResponse
     *
     */
    public function list(int $page=1){
    	try{
    		Auth::check(); // autorización(solo usuarios propietario o administradores
    		if   (!Login::role ('ROLE_ADMIN'))     		
    		throw new AuthException("Transación no autorizada!.");
    		    	
    	}catch (AuthException $e){
    		if(DEBUG)
    			throw new Exception($e->getMessage());
    		//Session::error(("Transación no autorizada!. "));
    		return redirect ('/');
    	}
    	//analiza si hay filtros, pone uno nuevo o quit el existente
    	$filtro = Filter::apply('usuarios');
    	
    	$limit = RESULTS_PER_PAGE; //Numer de resultados por pagina
    	
    	//si hay filtro
    	if($filtro){
    		//recupera el total de usuarios que cumplen los criterios del filtro
    		$total = User::filteredResults($filtro);
    		
    		//crea el objeto paginador
    		$paginator = new Paginator('/User/list', $page, $limit, $total,'es');
    		
    		//recupera los usuarios que cumplen los criteros del filtro
    		$user= User::filter($filtro, $limit, $paginator->getOffset());
    		// recupera los usuarios junto la información extra 
    	} else {
    		
    		$total = User::total(); //total del usuarios
    		
    		//crea el objeto paginador
    		$paginator = new Paginator('/User/list', $page, $limit, $total,'es');
    		
    		
    		$users= User::orderBy('displayname', 'ASC', $limit, $paginator->getOffset()); // recupera los usuairos junto la información extra
    		
    		
    	}
    	
    	
    	
    	//	carga la vista que los muestra
    	return view('user/list',['users'=>$users,'paginator'=>$paginator,'filtro' => $filtro]);
    }
    /**
     * Muestra los detalles del un usuario
     * @param int $id identificador del usuario a mostrar
     * @return ViewResponse
     */
    public function show(int $id=0) {
    	
    	try{
    		// autorización(solo usuarios propietario o administradores
    		if (Login::guest() || (!Login::role ('ROLE_ADMIN')&& user()->id!=$id)) {
    			
    			throw new AuthException("Transación no autorizada!.
							Intento ver los detalles del usuario $id por el usuario".(isset(user()->id)?user()->id:' invitado'));
    			
    		}
    	}catch (AuthException $e){
    		
    		if(DEBUG)
    			throw new Exception($e->getMessage());
    		//Session::error(("Transación no autorizada!. "));
    		return redirect ('/');
    	}
    	
    	$user = User::findOrFail($id, 'No se encontró el usuairo indicado'); //tb comprueba si no le ha llegado el ID
    	
    
    	// carga la vista y le pasa el socio recuperado
    	return view ('user/show',['user'=>$user]);
    	
    }
    
    /**
     * Muestra el formulario de "nuevo usuario"
     * 
     * @return ViewResponse
     */
    public function create(){
    	
    	//Operacion solamente para el administrador
    	//equivale a Auth::role('ROLE_ADMIN') pero es mas corto
    //	Auth::admin();
    	
    	return view ('user/create');
    }
    
    /** 
     * Guarda el usario en la bss
     * 
     * @ return RedirectResponse
     */
    public function store(){
    	
    	try{
    	
    	//Comprueba  que llega el formulario
    	if(!request()->has("guardar"))
    		throw new FormException ("No se recibió el formulario");
    		
    			
    		$user = new User(); //crea el nuevo usuario
    		
    		//recupera el password y lo encriptaa
    		//en este caso no lo cogemos de la Request, poruqe el saneamiento
    		//podria provocar que el password cambiara(y el usuario no podria  hacer login)
    		//no es peligroso porque el encriptarlo no afectarán los caracteres especiales
    		$pass = $_POST['password'];
    		if ( strlen($pass)<1)
    			throw new ValidationException ("<br>Password obligatorio</br>");
    			
    		$user->password =md5($pass);
    		$repeat =md5($_POST['repeatpassword']);
    		
    		//Comprueba que los dos passwords coinciden
    		if ( $user->password != $repeat )
    			throw new ValidationException ("Las claves no coinciden o no es correcta.");
    		
    		//toma el resto de los valores del formulario
    			$user->displayname = request()->post('displayname');
    			//$user->nombre = request()->post('nombre');
    			//$user->apellidos = request()->post('apellidos');  //No incluiodos en la tabla ...
    			$user->email = request()->post('email');
    			$user->phone = request()->post('telefono');
    			$user->poblacion = request()->post('poblacion');
    			$user->cp = request()->post('cp');
    		
    			//Esta operación solamente la puede hacer el administrador
    			Login::isAdmin() ?
    			//añade ROLE_USER y el rol que venga del formulario, no pasa nada si 
    			//se repite "ROLE_USER", el metodo addRole() elimina las repeticiones.
    			$user->addRole('ROLE_USER', request()->post('roles')):
    			$user->addRole('ROLE_USER');  //si no es admin solo agrega el rol user
    			
    			
    				$user->saneate(); //sanea las entradas.  no necesario, si se realiza en la clase Model::create
    				if ($errores=$user->validate()){
    					throw new ValidationException (
    							"<br>".arrayToString($errores,false, false,".<br>")
    							);
    				}
    				$user->save();  // Guarda el usuario
    				
    				$file = request()->file(  //recupera la foto
    						'picture',	// nombre del input
    						8000000, 	//tamaño maximo del fichero
    						['image/png','image/jpeg','image/gif','image/webp'] //tipos aceptados
    				);
    				//si hay fichero, lo guardamos y actualziamos eel campo 'picture'
    				if($file){
    					$user->picture = $file->store('../public/'.USER_IMAGE_FOLDER,'user_');
    					//$user->saneate(); //sanea las entradas.
    					$user->update();  //actualiza el usuario en la BDD para añadir la foto
    				}
    				Session::success("Nuevo usuario $user->displayname creado con éxito");
    				//Auth::check(); // si se ha creado nuevo, lo redirige a login para que acceder
    				//si estaba autenticado(caso adeministradores) le redirige  a los detalles
    				return redirect ("/login");
    				
    				//si sproduce un error de validación
    			}catch (ValidationException $e){
    				if(DEBUG)
    					throw new ValidationException($e->getMessage());
    					
    				Session::error($e->getMessage());
    				return redirect ("/User/create");
    			} catch (SQLException $e){
    				
    				Session::error ("Se produjo un error al guardar el usuario $user->displayname");
    				
    				if(DEBUG)
    					throw new Exception($e->getMessage());
    					
    					return redirect("User/create");
    			//si se produce un error en la subida de ficheros
    			}catch (UploadException $e){
    				
    				Session::error ("El usuario $user->displayname se guardó correctamente, 
										pero no se pudo subir el fichero de image.");
    				
    				if(DEBUG)
    					throw new Exception($e->getMessage());
    				
    					//redirecciona al a edición de usuario (por si quiere intertar subir la foto nuevamente   					
    					return redirect("User/edit/$user->id");
    			}
    }
    /**
     * Muestra el formulario de edición del usuario
     *
     * @param int $id el ID único del usario a editar
     *
     * @return ViewResponse
     *
     */
    public function edit(int $id=0){
    	try{
    		Auth::check(); // autorización(solo usuarios propietario o administradores
    		if (  (!Login::role ('ROLE_ADMIN')&& user()->id!=$id)) {
    			
    			throw new AuthException("Transación no autorizada!.");
    			
    		}
    	}catch (AuthException $e){
    		if(DEBUG)
    			throw new Exception($e->getMessage());
    		
    		//Session::error(("Transación no autorizada!. "));
    		return redirect ('/');
    	}
    	// busca el usuario con ese ID
    	$user = User::findOrFail($id,'No se encontró el usuario.');
    	
    
    	//retorna una ViewResponse con la vista con el formulario de edición
    	return view('user/edit',['user'=>$user]);
    }
    
    /** Actualzia la bdd con los datos POST del formulario
     */
    public function update(){
    	Auth::check(); // debe estar loginado para cambir el perfil
    	if(!request()->has('actualizar')) //si no llega el formulario ...
    		throw new FormException ('No se recibieron datos');
    		
    		$id = intval(request()->post('id')); // recuperar el id via POST
    		try{
    			// autorización(solo usuarios propietario o administradores
    			if (  (!Login::role ('ROLE_ADMIN')&& user()->id!=$id)) {
    				
    				throw new AuthException("Transación no autorizada!.");
    				
    			}
    		}catch (AuthException $e){
    			//Session::error(("Transación no autorizada!. "));
    			if(DEBUG)
    				throw new Exception($e->getMessage());
    			return redirect ('/');
    		}
    		
    		//intenta actualizar el usuario
    		try{
    			//$user->update(); No es necesario en la 1.8.0
    			// ya el metodo create ya actualiza si manda el 2ºparametro
    			$user= User::create(request()->posts() ,$id);
    			
    			Session::success("Actualización del usuario $user->displayname correctamente.");
    			return redirect(request()->previousUrl);
    			
    			// Si se produce un error al guardar el usuario..
    		}catch (SQLException $e){
    			// prepara el mensaje de error
    			$mensaje = "No se pudo actualizar el usuario";
    			
    			if(str_contains($e->errorMessage(),'Duplicate entry'))
    				$mensaje.="<br>Ya existe un usuario con ese <b>ID</b>.";
    				Session::error($mensaje);
    				
    				if(DEBUG)
    					throw new SQLException($e->getMessage());
    					
    					return redirect("/user/edit/$id");
    		}
    }
    
    /**
     * Muestra el formulario de confirmación de eliminación
     *
     * @param int $id identificador único del usuario a eliminar
     *
     * @return ViewResponse
     */
    public function delete(int $id=0){
    	Auth::check(); // debe estar loginado para eliminar el perfil
    	
    	//	$id = intval(request()->post('id')); // recuperar el id via POST
    		try{
    			
    			// autorización(solo usuarios propietario o administradores
    			if (!Login::role ('ROLE_ADMIN')&& user()->id!=$id) {
    				throw new AuthException("Transación no autorizada!. 
							Intento borrar usuario ".$id." por el usuario ".user()->id);
    				
    			}
    		}catch (AuthException $e){
    			Session::error(("Transación no autorizada!. "));
    			if(DEBUG)
    				throw new Exception($e->getMessage());
    			return redirect ('/');
    		}
    		
    	$user = User::findOrFail($id, "No existe el usuario.");
    	
    	return view('user/delete',['user'=> $user]);
    }
    
    /** Elimina el usuario de la base de datos
     * @return RedirectResponse
     */
    public function destroy(){
    	try{
    	//comprueba que le llega el formulario de confirmación
    	if(!request()->has('borrar'))
    		throw new FormException("No se recibió la confirmación");
    		
    		$id 	=intval(request()->post('id')); //Recupera el identiicador
    		$user	=User::findOrFail($id);
    		
    		if (  (!Login::role ('ROLE_ADMIN') &&  Login::user()->id!=$id)) {
    			//Session::error(("Transación no autorizada!. "));
    			throw new AuthException("Transación no autorizada!.
							Intento borrar usuario ".$user->id." por el usuario ".user()->id);
    			return redirect ('/');
    		}
    	
    			//intenta borrar el usuario
    			
    				$user->deleteObject();
    				//si hay imagen de la perfil, hay que borrarla
    				if($user->picture){
    					File::remove('../public/'.USER_IMAGE_FOLDER.'/'.$user->picture,true);
    					
    				}
    				
    				Session::success("Se ha borrado el usuario $user->displayname.");
    				if(Login::isAdmin())
    						return redirect("/User/list");
    				else 
    					return redirect('/Logout');
    				//si se produce un error en la operación con la bdd..
    			}catch (AuthException $e){
    				Session::error($e->getMessage());
    				return redirect ('/');
    			}catch (SQLException $e){
    				
    				Session::error("No se pudo borrar el usuario $user->displayname.");
    				
    				if(DEBUG)
    					throw new SQLException($e->getMessage());
    					
    					return redirect("/User/delete/$id");
    			}catch(FileException $e){
    				Session::error ("Se eliminó el usuario $user->displayname pero no se pudo eliminar el fichero del disco.");
    				if(DEBUG)
    					throw new SQLException($e->getMessage());
    					//No podemos redirigir al usuario porque ya no existe
    					//volvemos al listado de usuarios
    					if(Login::isAdmin())
    						return redirect("/User");
    						else
    							Session::success("Se ha borrado el usuario $user->displayname.");
    							return redirect('/Logout');
	//si se produce un error en la operación con la bdd..
    			}
    }
    
    /**
     * Elimina la imagen de perfil
     *
     * @return RedirectResponse
     */
    public function changeuserfoto(){
    	//Auth::check(); // autorización(solo usuarios registrados)
    	//Comprueba que la petición venga del formulario
    	if((!request()->has('borrar'))
    			&& (!request()->has('cambiar')))
    		throw new FormException('No se recibió el formulario');
    			
    		//recupera el idtema del desplegable
    		$id = intval(request()->post('id'));
    		try{
    			// autorización(solo usuarios propietario o administradores
    			if (  (!Login::role ('ROLE_ADMIN')&& user()->id!=$id)) {
    				
    				throw new AuthException("Transación no autorizada!.
							Intento cambiar foto del usuario $id por el usuario".user()->id);
    				
    			}
    		}catch (AuthException $e){
    			Session::error(("Transación no autorizada!. "));
    			return redirect ('/');
    		}
    		
    		$user = User::findOrFail($id, "no se ha encontrado el usuario.");
    		
    		$tmp = $user->picture; //recordatemos el nombre para poder borrarlo luego
    		
    		//en el caso de que se haya pulsado Eliminar
    		if(request()->has('borrar'))
    			$user->picture = NULL; //marca la foto perfil a NULL
    			
    			try{
    				//En el caso de querer cambiar la foto, adjunto fichero, guardaremos el fichero subido
    				//recupera la foto de perfil como objeto UploadedFile (o null si no llega)
    				if($file = request()->file(
    						'picture', 	// nombre del input
    						8000000, 	//tamaño maximo del fichero
    						['image/png','image/jpeg','image/gif','image/webp'] //tipos aceptados
    						)){
    							$user->picture=$file->store('../public/'.USER_IMAGE_FOLDER, 'user_');
    							
    				} else {
    					if(request()->has('cambiar')){
    						Session::error("Debes seleccionar la foto que deseas subir.");
    						return redirect("/User/edit/$user->id");
    					}
    				}
    				$user->update();
    				Session::success("Se ha sustituido o eliminado la foto de perfil de $user->displayname correctamente.");
    				
    				//si ya existia la foto, tratara de eliminarla primero
    				if($tmp)
    					File::remove('../public/'.USER_IMAGE_FOLDER.'/'.$tmp, true);
    					
    					return redirect("/User/edit/$user->id");
    					
    			}  catch(SQLException $e){
    				Session::error("No se pudo eliminar la foto de perfil.");
    				if(DEBUG)
    					throw new SQLException($e->getMessage());
    					
    					return redirect("/User/edit/$id");
    			} catch(FileException $e){
    				Session::error ("No se pudo eliminar el fichero del disco.");
    				if(DEBUG)
    					throw new SQLException($e->getMessage());
    					
    					return redirect("/User/edit/$id");
    			}catch (UploadException $e){
    				$mensaje.="Cambios guardados, pero no se modificó la foto de perfil.";
    				Session::error($mensaje);
    				
    				if(DEBUG)
    					throw new SQLException($e->getMessage());
    					
    					return redirect("/User/edit/$user->id");
    			}
    }
    /** Agrega nuevos roles a los usuairos
     */
    public function agregarrol(){
    	Auth::admin(); // autorización(solo administradores)
    	if(!request()->has('agregarrol')) //si no llega el formulario ...
    		throw new FormException ('No se recibieron datos');
    		
    		$id = intval(request()->post('id')); // recuperar el id via POST
    		$user=User::findOrFail($id ,"No se ha encontrado el usuario.");
    		
    		$rolnuevo=request()->post('roles');
    		$user->addRole($rolnuevo);
    		
    		//intenta actualizar el usuario
    		try{
    			$user->update(); 
    			
    			Session::success("Agregado nuevo rol $rolnuevo  usuario $user->displayname correctamente.");
    			return redirect("/User/edit/$id#roles");
    			
    			// Si se produce un error al guardar el usuario..
    		}catch (SQLException $e){
    			// prepara el mensaje de error
    			$mensaje = "No se pudo actualizar el usuario";
    			
    			if(str_contains($e->errorMessage(),'Duplicate entry'))
    				$mensaje.="<br>Ya existe un usuario con ese <b>ID</b>.";
    				Session::error($mensaje);
    				
    				if(DEBUG)
    					throw new SQLException($e->getMessage());
    					
    					return redirect("/user/edit/$id");
    		}
    }
    /** Elimina roles a los usuarios
     */
    public function quitarol(){
    	Auth::admin(); // autorización(solo administradores)
    	if(!request()->has('quitarrol')) //si no llega el formulario ...
    		throw new FormException ('No se recibieron datos');
    		
    		$id = intval(request()->post('id')); // recuperar el id via POST
    		$user=User::findOrFail($id ,"No se ha encontrado el usuario.");
    		
    		$rolaquitar=request()->post('role');
    		$user->removeRole($rolaquitar);
    		
    		//intenta actualizar el usuario
    		try{
    			$user->update();
    			
    			Session::success("ELiminado  rol $rolnuevo  usuario $user->displayname correctamente.");
    			return redirect("/User/edit/$id#roles");
    			
    			// Si se produce un error al guardar el usuario..
    		}catch (SQLException $e){
    			// prepara el mensaje de error
    			$mensaje = "No se pudo quitar el rol del usuario";
    			
    			if(str_contains($e->errorMessage(),'Duplicate entry'))
    				$mensaje.="<br>Ya existe un usuario con ese <b>ID</b>.";
    				Session::error($mensaje);
    				
    				if(DEBUG)
    					throw new SQLException($e->getMessage());
    					
    					return redirect("/user/edit/$id");
    		}
    }
    
    /** Agrega nuevos roles a los usuarios
     * 
     * @return ViewResponse
     */
    public function cambiaContrasenya(){
    	
    	
    	
    	Auth::check(); // autorización(solo usuarios identificados
    	
    	//carga la vista home y le pasa el usuario idenntificado
    	// el usuario se puede recuperar mediante el metodo Login::user()
    	return view('user/changePassword', ['user'=>Login::user()]);
    
    	
    }
    
    /** Agrega nuevos roles a los usuarios
     */
    public function changePassword(){
    	Auth::check(); // autorización(solo usuarios identificados 
    	
    	if(!request()->has('cambiar')) //si no llega el formulario ...
    		throw new FormException ('No se recibieron datos');
    		
    		$id = intval(request()->post('id')); // recuperar el id via POST
    		$user=User::findOrFail($id ,"No se ha encontrado el usuario.");
    		
    		//recupera el password y lo encriptaa
    		//en este caso no lo cogemos de la Request, poruqe el saneamiento
    		//podria provocar que el password cambiara(y el usuario no podria  hacer login)
    		//no es peligroso porque el encriptarlo no afectarán los caracteres especiales
    		$oldpassword=md5($_POST['oldpassword']);
    		$newpass =md5($_POST['newpassword']); 
    		$repeatpass =md5($_POST['repeatpassword']);
    		
    		//Comprueba que los dos passwords nuevos coinciden
    		if ($user->password != $oldpassword){
    			Session::error ("Las contraseña antigua no es correcta.");
    			return  view("/user/changePassword");
    		}
    		
    		//Comprueba que los dos passwords nuevos coinciden
    		if ($newpass != $repeatpass){
    			Session::error ("Las claves nuevas no coinciden.");
    			return redirect("history.back()");
    		}
    		
    		$user->password = $newpass;
    		
    		//intenta actualizar el usuario 
    		try{
    			$user->update();
    			
    			Session::success("Cambiada la contraseña del usuario $user->displayname correctamente.");
    			return redirect("/User/home");
    			
    			// Si se produce un error al guardar el usuario..
    		}catch (SQLException $e){
    			// prepara el mensaje de error
    			$mensaje = "No se pudo cambiar la contraseña.";
    			
    			if(str_contains($e->errorMessage(),'Duplicate entry'))
    				$mensaje.="<br>Ya existe un usuario con ese <b>ID</b>.";
    				Session::error($mensaje);
    				
    				if(DEBUG)
    					throw new SQLException($e->getMessage());
    					
    					return redirect("/user/home");
    		}
    }
    
    /**
     * Bloquea un usuarios 
     * Solo puede realizarla los Administradores y moderadores
     * 
     */
    public function blocked(int $id=0,$retorno=''){
    	Auth::check(); // autorización(solo usuarios registrados)
    	$atras= request()->previousUrl;
    	
    		try{
    			// autorización(solo usuarios propietario o administradores
    			if(!Login::oneRole(['ROLE_ADMIN','ROLE_MODERADOR'])){
    				throw new AuthException("Transación no autorizada! Intento de bloqueo del usuario $id por el usuario Login::user()->id");
    				
    				if(DEBUG)
    					throw new AuthException("Transación no autorizada! Intento de bloqueo del usuario $id por el usuario".Login::user()->id);
    					
    			}
    		} catch (AuthException $e){
    			Session::error(("Transación no autorizada!. "));
    			return redirect('/');
     		}
     		$user=User::findOrFail($id, "No se ha encontrado el usuario-");
     		
     		if($user->hasRole('ROLE_BLOCKED')){
     				Session::warning("EL usuario ya esta bloqueado");
     				return redirect();
     		}
     		if(!$user->oneRole(['ROLE_ADMIN','ROLE_MODERADOR'])){
     			$user->addRole('ROLE_BLOCKED');
     			if($user->update()){
     				Session::success("Se ha bloqueado el usuarios $user->displayname");
     				return redirect($atras.'#'.$retorno);
     			}
     			return redirect($atras.'#'.$retorno);
     			
     		}else { 
     			Session::warning("No se puede bloquear un administrador/moderador.");
     			throw new AuthException("No se puede bloquear un administrador/moderador.");
     		}
     		
     	return redirect(request()->previousUrl.'#'.$retorno);
    }
    
    /**
     *  Configura la variable aspecto que tiene configurada el usuario para el aspeto
     *
     * @return string variable aspecto de la bbd
     */
    public function cambiaAspecto(){
    	$atras= request()->previousUrl;
    	Auth::check(); //Solo usuarios autenticados

    	try{
    		//Comprueba que la petición venga del formulario
    		
    		if(!request()->has('cambiar') )
	    		throw new FormException('No se recibió el formulario');
	    		$id = intval(request()->post('id')); // recuperar el id via POST
	    		
	    		$user=User::findOrFail($id ,"No se ha encontrado el usuario.");
	    		
	    		$consulta = trim(request()->post('aspecto'));
    			if(user()->id!=$id )
    				throw new AuthException("No autorizado para cambiar el aspecto,");
    			
    			
    		}  catch (AuthException $e){
    			Session::error($e->getMessage());
    			return redirect($atras);
    		} catch (FormException $e){
    			Session::error($e->getMessage());
    			return redirect($atras);
    		}
    	//Hacemos un filtrado con un switch (se podria hacer de otra forma, 
    	// por ejemplo DEFINIR un listado de variables en el config y comprobar si esta o definir por defecto
    	// de esa forma evitas injección y/o errores..
    	switch($consulta){
    		case "Base" : $aspecto = "Base"; break;
    		case "Neon"   : $aspecto = "Neon"; break;
    		case "Retro"  : $aspecto = "Retro"; break;
    		// En el caso de no tener el aspecto (No informa del error) se establece por defecto el Dark
    		default       : $aspecto = "Dark";
    	}
    	
    	try{
    	
    		//$user->aspeto=$aspecto;
    		$user=$user->setAspecto($aspecto);
    		return redirect($atras);
    	}catch (Exception $e){
    		Session::error("Error inesperado. ".$e->getMessage());
    		return redirect($atras);
    	}
    	
    	
    	
    }
    
  
    
}


