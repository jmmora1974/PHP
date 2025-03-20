<?php
/**
* AnuncioController
* 
* Operaciones con los anuncios
* 
* @autor Jose Miguel Mora Perez ® CIFO Valles 2025®
*/

class AnuncioController extends Controller{
	
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
	 * Listado de anuncios
	 * 
	 * @return ViewResponse
	 * 
	 */
	public function list(int $page=1){
		
   
		//analiza si hay filtros, pone uno nuevo o quit el existente
		$filtro = Filter::apply('anuncios');
		
		$limit = RESULTS_PER_PAGE; //Numer de resultados por pagina
		
		//si hay filtro
		if($filtro){
			//recupera el total de anuncios que cumplen los criterios del filtro
			$total = Anuncio::filteredResults($filtro);
			
			//crea el objeto paginador
			$paginator = new Paginator('/Anuncio/list', $page, $limit, $total,'es');
			
			//recupera los anuncios que cumplen los criteros del filtro
			$anuncios= Anuncio::filter($filtro, $limit, $paginator->getOffset());
			// recupera los anuncios junto la información extra (prestamos)
		} else {
			
			$total = Anuncio::total(); //total del anuncio
			
			//crea el objeto paginador
			$paginator = new Paginator('/Anuncio/list', $page, $limit, $total,'es');
			
			
			$anuncios= Anuncio::orderBy('fecha', 'DESC', $limit, $paginator->getOffset()); // recupera los anuncios junto la información extra (prestamos)
			
			
		}
		//	carga la vista que los muestra
		return view('anuncio/list',['anuncios'=>$anuncios,'paginator'=>$paginator,'filtro' => $filtro]);
		
	}
	
	/**
	 * Muestra los detalles del un anuncio
	 * @param int $id identificador del anuncio a mostrar
	 * @return ViewResponse
	 */
	public function show(int $id=0) {
			
			$anuncio = Anuncio::findOrFail($id, 'No se encontró el anuncio indicado'); //tb comprueba si no le ha llegado el ID
			
			
			// carga la vista y le pasa el anuncio recuperado
			return view ('anuncio/show',['anuncio'=>$anuncio]);
	}
	
	/**
	 * Muestra el formulario de nuevo anuncio
	 * @return ViewResponse
	 */
	public function create(){
		
		//Usuarios autenticados
		Auth::check();
			return view('anuncio/create');
	//	En caso de no estar loginaddo, 
	// redirige a la pantalla de login, de no tener usurios puede crearlo.
		
	}
	
	/**
	 * Guarda los datos que llegan del formulario en la bdd
	 * 
	 * @ redirect Viewresponse
	 */
	public function store(){
		 
		//Usuarios autenticados
		Auth::check();
		
			//Comprueba que la petición venga del formulario
			if(!request()->has('guardar'))
				throw new FormException('No se recibió el formulario');

		$anuncio=new Anuncio(); //crea el nuevo anuncio
			
		//OPCION AUTOMATICA
				try{
					
					//Recuperamos el fomulario, saneamos y validamos antes de guardar en BDD
					$anunciotemp=new Anuncio(); //crea el nuevo libro temporal para crear y validar
					
					//guarda el anuncio en la base de datos a partir de los datos POST
					foreach( request()->posts() as $campo=>$valor) //pasamos a objeto Anuncio
						$anunciotemp ->$campo=$valor;
						
						//Validaremos que los datos sean correctos
						if($errores = $anunciotemp->validate()){
							Session:warning("Errores de validación");
							throw new ValidationException(
									"<br>".arrayToString($errores, false, false,".<br>")
									);
						}
							
					//guarda el anuncio en la base de datos a partir de los datos POST
					
					$anuncio = Anuncio::create((array)$anunciotemp); //mo es necesario en la  1.8.0
					
					//En el caso de querer cambiar la foto, adjunto fichero, guardaremos el fichero subido
					//recupera la foto del anunciocomo objeto UploadedFile (o null si no llega)
					if($file = request()->file(
							'imagen', 	// nombre del input
							8000000, 	//tamaño maximo del fichero
							['image/png','image/jpeg','image/gif','image/webp'] //tipos aceptados
							)){
<<<<<<< HEAD
								$anuncio->imagen=$file->store('../public/'.ANUNCIO_IMAGE_FOLDER, 'anuncio_');
=======
								$anuncio->imagen=$file->store('../public'.ANUNCIO_IMAGE_FOLDER, 'anuncio_');
>>>>>>> b641c60dc8de95b84b3e4e24f56fd938cd1e845a
								
					}
					//$anuncio->saneate(); //sanea las entradas.
					$anuncio->update();
					
					//flashea un mensaje de exito en sesion
					Session::success("Guardado del anuncio $anuncio->titulo correcto.");
					
					//redirecciona a los detalles del nuevo anuncio
					return redirect("/Anuncio/show/$anuncio->id");
				}  catch(SQLException $e){
					//prepara el mensaje de error
					$mensaje = "No se pudo guardar el anuncio $anuncio->titulo.";
<<<<<<< HEAD
					
=======
					// si está activado el LOG de errores, añadimos el mensaje al fichero de LOG
					
					if(LOG_ERRORS)
						Log::addMessage(ERROR_LOG_FILE, get_class($e), $e->getMessage());
						
						// Si está activada la opción de guardar errores en BDD, lo guardamos.
						if(DB_ERRORS)
							AppError::new(get_class($e), $e->getMessage());
							
							
>>>>>>> b641c60dc8de95b84b3e4e24f56fd938cd1e845a
					if(str_contains($e->errorMessage(),'Duplicate entry'))
							$mensaje.="<br>Ya existe un anuncio con ese <b>ID</b>.";
					
					//flashe un mensaje de error en session
					Session::error($mensaje);
					
<<<<<<< HEAD
=======
					
>>>>>>> b641c60dc8de95b84b3e4e24f56fd938cd1e845a
					//Si esta en modo DEBUG vuelve a lanzar la excepcion
					//esto hara qie acabemos en la pagina de error
					if(DEBUG)
					throw new SQLException($e->getMessage());
					
					//regresa al formulario de creación de anuncio
					return redirect("/Anuncio/create");
				}
		
	}
	
	/** 
	 * Muestra el formulario de edición del anuncio
	 * 
	 * @param int $id el ID único del anuncio a editar
	 * 
	 * @return ViewResponse
	 * 
	 */
	public function edit(int $id=0){
		
		// busca el anuncio con ese ID
		$anuncio = Anuncio::findOrFail($id,'No se encontró el anuncio.');
		
		
	
	  if( user()->id != $anuncio->iduser) {// autorización(solo propietario) ?
		 		Session::warning("Si deseas realizar cambios, contacta con el vendedor.");
		 	  	return redirect('/Anuncio');
		 }
			
			
			
			//retorna una ViewResponse con la vista con el formulario de edición
			return view('anuncio/edit',['anuncio'=>$anuncio]);
	
		
	}
	
	/** Actualzia la bdd con los datos POST del formulario
	*/
	public function update(){
		
	    	
			if(!request()->has('actualizar')) //si no llega el formulario ...
				throw new FormException ('No se recibieron datos');
			
			$id = intval(request()->post('id')); // recuperar el id via POST
			// autorización(solo propietario)
			if( Login::user()->id == $id) {// autorización(solo propietario)
				Session::warning("Si deseas realizar cambios, contacta con el vendedor.");
				return ('/Anuncio');
			}
		
		
			//intenta actualizar el anuncio
			try{
				
				//Recuperamos el fomulario, saneamos y validamos antes de guardar en BDD
				$anunciotemp=new Anuncio(); //crea el nuevo libro temporal para crear y validar
				
				//guarda el anuncio en la base de datos a partir de los datos POST
				foreach( request()->posts() as $campo=>$valor) //pasamos a objeto Anuncio
					$anunciotemp ->$campo=$valor;
					$anunciotemp->id=$id;
					
					//Validaremos que los datos sean correctos
					if($errores = $anunciotemp->validate(true))
						throw new ValidationException(
								"<br>".arrayToString($errores, false, false,".<br>")
								);
						
			
				$anuncio= Anuncio::create((array)$anunciotemp,$id);
				
				Session::success("Actualización del anuncio $anuncio->titulo correcta.");
				return redirect("/Anuncio");
				
			// Si se produce un error al guardar el anuncio..
			}catch (SQLException $e){
				// prepara el mensaje de error
				$mensaje = "No se pudo actualizar el anuncio";
				
			if(str_contains($e->errorMessage(),'Duplicate entry'))
					$mensaje.="<br>Ya existe un anuncio con ese <b>ID</b>.";
				Session::error($mensaje);
				
<<<<<<< HEAD
=======
				// si está activado el LOG de errores, añadimos el mensaje al fichero de LOG
				if(LOG_ERRORS)
					Log::addMessage(ERROR_LOG_FILE, get_class($e), $e->getMessage());
					
					// Si está activada la opción de guardar errores en BDD, lo guardamos.
					if(DB_ERRORS)
						AppError::new(get_class($e), $e->getMessage());
						
						
				
>>>>>>> b641c60dc8de95b84b3e4e24f56fd938cd1e845a
				if(DEBUG)
					throw new SQLException($e->getMessage());
				
					return redirect("/Anuncio/edit/$id");
			}
		
	}
	
	/** 
	 * Muestra el formulario de confirmación de eliminación
	 * 
	 * @param int $id identificador único del anuncio a eliminar
	 * 
	 * @return ViewResponse
	 */	
	public function delete(int $id=0){
		
			//Buscamos el anuncio
			$anuncio = Anuncio::findOrFail($id, "No existe el anuncio.");
			
			if( user()->id != $anuncio->iduser) {// autorización(solo propietario) ?
				Session::warning("Si deseas realizar cambios, contacta con el vendedor.");
				return redirect('/Anuncio');
			}
			
			
			return view('anuncio/delete',['anuncio'=> $anuncio]);
		
	}
	
	/** Elimina el anuncio de la base de datos
	 * @return RedirectResponse
	 */
	public function destroy(){
		
		//comprueba que le llega el formulario de confirmación
		if(!request()->has('borrar'))
			throw new FormException("No se recibió la confirmación");
		
			$id 	=intval(request()->post('id')); //Recupera el identiicador
			$anuncio	=Anuncio::findOrFail($id);
			
					//intenta borrar el anuncio
				try{
					$anuncio->deleteObject();
					//si hay imagen de la perfil, hay que borrarla
					if($anuncio->imagen){
						File::remove('../public/'.ANUNCIO_IMAGE_FOLDER.'/'.$anuncio->imagen,true);
					
					}
						
					Session::success("Se ha borrado el anuncio $anuncio->titulo.");
					return redirect("/Anuncio/list");
				//si se produce un error en la operación con la bdd..
				} catch (SQLException $e){
					
					Session::error("No se pudo borrar el anuncio $anuncio->titulo.");
<<<<<<< HEAD
					
=======
				
					// si está activado el LOG de errores, añadimos el mensaje al fichero de LOG
					if(LOG_ERRORS)
						Log::addMessage(ERROR_LOG_FILE, get_class($e), $e->getMessage());
						
						// Si está activada la opción de guardar errores en BDD, lo guardamos.
						if(DB_ERRORS)
							AppError::new(get_class($e), $e->getMessage());
						
>>>>>>> b641c60dc8de95b84b3e4e24f56fd938cd1e845a
					if(DEBUG)
						throw new SQLException($e->getMessage());
						
						return redirect("/Anuncio/delete/$id");
				}catch(FileException $e){
					Session::warning ("Se eliminó el anuncio $anuncio->titulo pero no se pudo eliminar el fichero del disco.");
<<<<<<< HEAD
=======
					
					// si está activado el LOG de errores, añadimos el mensaje al fichero de LOG
					if(LOG_ERRORS)
						Log::addMessage(ERROR_LOG_FILE, get_class($e), $e->getMessage());
						
						// Si está activada la opción de guardar errores en BDD, lo guardamos.
						if(DB_ERRORS)
							AppError::new(get_class($e), $e->getMessage());
							
							
>>>>>>> b641c60dc8de95b84b3e4e24f56fd938cd1e845a
					if(DEBUG)
						throw new SQLException($e->getMessage());
						//No podemos redirigir al anuncio porque ya no existe
						//volvemos al listado de anuncios
						return redirect("/Anuncio");
				}
	}
		
	
	/**
	 * Cambia/Elimina la imagen del anuncio
	 *
	 * @return RedirectResponse
	 */
	public function changefotoanuncio(){
		// autorización(solo bibliotecarios
		if( Login::role('ROLE_USER')) { 
			//Comprueba que la petición venga del formulario
			if((!request()->has('borrar')) 
					&& (!request()->has('cambiar')))
				throw new FormException('No se recibió el formulario');
			
				//recupera el idtema del desplegable
				$id = intval(request()->post('id'));
				$anuncio = Anuncio::findOrFail($id, "no se ha encontrado el anuncio.");
				
				$tmp = $anuncio->imagen; //recordatemos el nombre para poder borrarlo luego
				
				//en el caso de que se haya pulsado Eliminar
				if(request()->has('borrar'))
					$anuncio->imagen = NULL; //marca la foto perfil a NULL
				
				try{
					//En el caso de querer cambiar la foto, adjunto fichero, guardaremos el fichero subido
					//recupera la foto del anunciocomo objeto UploadedFile (o null si no llega)
					if($file = request()->file(
								'imagen', 	// nombre del input
								8000000, 	//tamaño maximo del fichero
								['image/png','image/jpeg','image/gif','image/webp'] //tipos aceptados
							)){
						$anuncio->imagen=$file->store('../public/'.ANUNCIO_IMAGE_FOLDER, 'profile_');
						
					} else {
						if(request()->has('cambiar')){
							 Session::warning("Debes seleccionar la foto que deseas subir.");
						return redirect("/Anuncio/edit/$anuncio->id");
					 }
					}
					//$anuncio->saneate(); //sanea las entradas.
					$anuncio->update();
					Session::success("Se ha sustituido o eliminado la foto del anuncio de $anuncio->titulo correctamente.");
					
					//si ya existia la foto, tratara de eliminarla primero
					if($tmp)
						File::remove('../public/'.ANUNCIO_IMAGE_FOLDER.'/'.$tmp, true);
						
					return redirect("/Anuncio/edit/$anuncio->id");
					
				}  catch(SQLException $e){
					Session::error("No se pudo eliminar la foto del anuncio.");
<<<<<<< HEAD
=======
					// si está activado el LOG de errores, añadimos el mensaje al fichero de LOG
					if(LOG_ERRORS)
						Log::addMessage(ERROR_LOG_FILE, get_class($e), $e->getMessage());
						
						// Si está activada la opción de guardar errores en BDD, lo guardamos.
						if(DB_ERRORS)
							AppError::new(get_class($e), $e->getMessage());
							
>>>>>>> b641c60dc8de95b84b3e4e24f56fd938cd1e845a
					if(DEBUG)
						throw new SQLException($e->getMessage());
						
						return redirect("/Anuncio/edit/$id");
				} catch(FileException $e){
					Session::warning ("No se pudo eliminar el fichero del disco.");
					if(DEBUG)
						throw new SQLException($e->getMessage());
						
						return redirect("/Anuncio/edit/$id");
				}catch (UploadException $e){
					$mensaje.="Cambios guardados, pero no se modificó la foto del anuncio.";
					Session::error($mensaje);
					
<<<<<<< HEAD
=======
					// si está activado el LOG de errores, añadimos el mensaje al fichero de LOG
					if(LOG_ERRORS)
						Log::addMessage(ERROR_LOG_FILE, get_class($e), $e->getMessage());
						
						// Si está activada la opción de guardar errores en BDD, lo guardamos.
						if(DB_ERRORS)
							AppError::new(get_class($e), $e->getMessage());
							
					
>>>>>>> b641c60dc8de95b84b3e4e24f56fd938cd1e845a
					if(DEBUG)
						throw new SQLException($e->getMessage());
						
						return redirect("/Anuncio/edit/$anuncio->id");
				}
		}
		//En caso de no se bibliotecario, redirige al inicio
		return redirect('/');
	}
	
}	
	 
