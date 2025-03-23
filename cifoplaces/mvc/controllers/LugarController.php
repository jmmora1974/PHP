<?php
/**
* LugarController
* 
* Operaciones con los lugares
* 
* @autor Jose Miguel Mora Perez ® CIFO Valles 2025®
*/
#[AllowDynamicProperties] 
class LugarController extends Controller{
	
	/**
	 * Mérodo por defecto
	 * 
	 * Redirige al método list() de este mismo controlador.
	 * 
	 * @return ViewResponse
	 */
	public function index(){
			return $this->list();
	}
	
	/** 
	 * Listado de lugares
	 * 
	 * @return ViewResponse
	 * 
	 */
	public function list(int $page=1){
		
   
		//analiza si hay filtros, pone uno nuevo o quit el existente
		$filtro = Filter::apply('lugares');
		
		$limit = RESULTS_PER_PAGE; //Numer de resultados por pagina
		
		//si hay filtro
		if($filtro){
			//recupera el total de lugares que cumplen los criterios del filtro
			$total = V_place::filteredResults($filtro);
			
			//crea el objeto paginador
			$paginator = new Paginator('/Lugar/list', $page, $limit, $total,'es');
			
			//recupera los lugares que cumplen los criteros del filtro
			$lugares= V_place::filter($filtro, $limit, $paginator->getOffset());

					

			// recupera los lugares junto la información extra (fotos y comentarios)
		} else {
			
			$total = V_place::total(); //total del lugar
			
			//crea el objeto paginador
			$paginator = new Paginator('/Lugar/list', $page, $limit, $total,'es');
			
			
			$lugares= V_place::orderBy('created_at', 'DESC', $limit, $paginator->getOffset()); // recupera los lugares junto la información extra (fotso y comentarios)
			
			
		}
		//	carga la vista que los muestra
		return view('lugar/list',['lugares'=>$lugares,'paginator'=>$paginator,'filtro' => $filtro]);
		
	}
	
	/**
	 * Muestra los detalles del un lugar
	 * @param int $id identificador del lugar a mostrar
	 * @return ViewResponse
	 */
	public function show(int $id=0) {
			
			$lugar = V_place::findOrFail($id, 'No se encontró el lugar indicado'); //tb comprueba si no le ha llegado el ID
			$lugarcomments = V_comment::getFiltered('idplace', $id,'created_at','DESC' );
			
			$fotoslugar = Photo::getFiltered('idplace', $id,'created_at','DESC'  );
			
			// carga la vista y le pasa el lugar recuperado
			return view ('lugar/show',['lugar'=>$lugar,'lugarcomments'=>$lugarcomments, 'fotoslugar'=>$fotoslugar]);

	}
	
	/**
	 * Muestra el formulario de nuevo lugar
	 * @return ViewResponse
	 */
	public function create(){
		
		//Usuarios autenticados
		Auth::check();
			return view('lugar/create');
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
			
				if(!$file = request()->file(
						'imagen', 	// nombre del input
						8000000, 	//tamaño maximo del fichero
						['image/png','image/jpeg','image/gif','image/webp'] //tipos aceptados
						)) {
							
							Session::warning("Es obligatorio establecer la foto del lugar.");
							return redirect(request()->previousUrl);
						}

		$lugar=new Lugar(); //crea el nuevo lugar
			
		//OPCION AUTOMATICA
				try{
					
					//Recuperamos el fomulario, saneamos y validamos antes de guardar en BDD
					$phototemp=new Lugar(); //crea el nuevo libro temporal para crear y validar
					
					//guarda el lugar en la base de datos a partir de los datos POST
					foreach( request()->posts() as $campo=>$valor) //pasamos a objeto Lugar
						$phototemp ->$campo=$valor;
						
						//Validaremos que los datos sean correctos
						if($errores = $phototemp->validate()){
							Session::warning("Errores de validación");
							throw new ValidationException(
									"<br>".arrayToString($errores, false, false,".<br>")
									);
						}
							
					//guarda el lugar en la base de datos a partir de los datos POST
					
					$lugar = Lugar::create((array)$phototemp); //mo es necesario en la  1.8.0
					
					//En el caso de querer cambiar la foto, adjunto fichero, guardaremos el fichero subido
					//recupera la foto del lugarcomo objeto UploadedFile (o null si no llega)

					if($file ){
								$lugar->mainpicture=$file->store('../public/'.LUGAR_IMAGE_FOLDER, 'lugar_');
								
					} 

					//$lugar->saneate(); //sanea las entradas.
					$lugar->update();
					
					//flashea un mensaje de exito en sesion
					Session::success("Guardado del lugar $lugar->name correcto.");
					
					//redirecciona a los detalles del nuevo lugar
					return redirect("/Lugar/show/$lugar->id");
				}  catch (ValidationException $e){
    				if(DEBUG)
    					throw new ValidationException($e->getMessage());
    					
    				Session::error($e->getMessage());
    				return redirect (request()->previousUrl);
    			}catch(SQLException $e){
					//prepara el mensaje de error
					$mensaje = "No se pudo guardar el lugar $lugar->titulo.";
					
					if(str_contains($e->errorMessage(),'Duplicate entry'))
							$mensaje.="<br>Ya existe un lugar con ese <b>ID</b>.";
					
					//flashe un mensaje de error en session
					Session::error($mensaje);
					
					//Si esta en modo DEBUG vuelve a lanzar la excepcion
					//esto hara qie acabemos en la pagina de error
					if(DEBUG)
					throw new SQLException($e->getMessage());
					
					//regresa al formulario de creación de lugar
					return redirect("/Lugar/create");
				}
		
	}
	
	/** 
	 * Muestra el formulario de edición del lugar
	 * 
	 * @param int $id el ID único del lugar a editar
	 * 
	 * @return ViewResponse
	 * 
	 */
	public function edit(int $id=0){
		
		// busca el lugar con ese ID
		$lugar = Lugar::findOrFail($id,'No se encontró el lugar.');
		
		
	
	  if( user()->id != $lugar->iduser && !Login::oneRole(['ROLE_ADMIN','ROLE_MODERADOR'])) {// autorización(solo propietario) ?
		 		Session::warning("Si deseas realizar cambios, contacta con el vendedor.");
		 	  	return redirect('/Lugar');
		 }
			
			
			
			//retorna una ViewResponse con la vista con el formulario de edición
			return view('lugar/edit',['lugar'=>$lugar]);
	
		
	}
	
	/** Actualzia la bdd con los datos POST del formulario
	*/
	public function update(){
		
	    	
			if(!request()->has('actualizar')) //si no llega el formulario ...
				throw new FormException ('No se recibieron datos');
			$id = intval(request()->post('id')); // recuperar el id via POST
			$iduser = intval(request()->post('iduser')); // recuperar el iduser via POST
			// autorización(solo propietario)
			if( Login::user()->id != $iduser && !Login::oneRole(['ROLE_ADMIN','ROLE_MODERADOR']) ) {// autorización(solo propietario)
				Session::warning("Si deseas realizar cambios, contacta con el vendedor.");
				return ('/Lugar');
			}
		
		
			//intenta actualizar el lugar
			try{
				
				//Recuperamos el fomulario, saneamos y validamos antes de guardar en BDD
				$phototemp=new Lugar(); //crea el nuevo libro temporal para crear y validar
				
				//guarda el lugar en la base de datos a partir de los datos POST
				foreach( request()->posts() as $campo=>$valor) //pasamos a objeto Lugar
					$phototemp ->$campo=$valor;
					$phototemp->id=$id;
					
					//Validaremos que los datos sean correctos
					if($errores = $phototemp->validate(true))
						throw new ValidationException(
								"<br>".arrayToString($errores, false, false,".<br>")
								);
						
			
				$lugar= Lugar::create((array)$phototemp,$id);
				
				Session::success("Actualización del lugar $lugar->titulo correcta.");
				return redirect("/Lugar");
				
			// Si se produce un error al guardar el lugar..
			}catch (SQLException $e){
				// prepara el mensaje de error
				$mensaje = "No se pudo actualizar el lugar";
				
			if(str_contains($e->errorMessage(),'Duplicate entry'))
					$mensaje.="<br>Ya existe un lugar con ese <b>ID</b>.";
				Session::error($mensaje);
				
				if(DEBUG)
					throw new SQLException($e->getMessage());
				
					return redirect("/Lugar/edit/$id");
			}
		
	}
	
	/** 
	 * Muestra el formulario de confirmación de eliminación
	 * 
	 * @param int $id identificador único del lugar a eliminar
	 * 
	 * @return ViewResponse
	 */	
	public function delete(int $id=0){
		
			//Buscamos el lugar
			$lugar = Lugar::findOrFail($id, "No existe el lugar.");
			
			if( user()->id != $lugar->iduser) {// autorización(solo propietario) ?
				Session::warning("Si deseas realizar cambios, contacta con el vendedor.");
				return redirect('/Lugar');
			}
			
			
			return view('lugar/delete',['lugar'=> $lugar]);
		
	}
	
	/** Elimina el lugar de la base de datos
	 * @return RedirectResponse
	 */
	public function destroy(){
		
		//comprueba que le llega el formulario de confirmación
		if(!request()->has('borrar'))
			throw new FormException("No se recibió la confirmación");
		
			$id 	=intval(request()->post('id')); //Recupera el identiicador
			$lugar	=Lugar::findOrFail($id);
			
					//intenta borrar el lugar
				try{
					$lugar->deleteObject();
					//si hay imagen de la perfil, hay que borrarla
					if($lugar->mainpicture){
						File::remove('../public/'.LUGAR_IMAGE_FOLDER.'/'.$lugar->mainpicture,true);
					
					}
						
					Session::success("Se ha borrado el lugar $lugar->titulo.");
					return redirect("/Lugar/list");
				//si se produce un error en la operación con la bdd..
				} catch (SQLException $e){
					
					Session::error("No se pudo borrar el lugar $lugar->titulo.");
					
					if(DEBUG)
						throw new SQLException($e->getMessage());
						
						return redirect("/Lugar/delete/$id");
				}catch(FileException $e){
					Session::warning ("Se eliminó el lugar $lugar->titulo pero no se pudo eliminar el fichero del disco.");
					if(DEBUG)
						throw new SQLException($e->getMessage());
						//No podemos redirigir al lugar porque ya no existe
						//volvemos al listado de lugares
						return redirect("/Lugar");
				}
	}
		
	
	/**
	 * Cambia/Elimina la imagen del lugar
	 *
	 * @return RedirectResponse
	 */
	public function changefotolugar(){
		// autorización(solo bibliotecarios
		if( Login::role('ROLE_USER')) { 
			//Comprueba que la petición venga del formulario
			if((!request()->has('borrar')) 
					&& (!request()->has('cambiar')))
				throw new FormException('No se recibió el formulario');
			
				//recupera el idtema del desplegable
				$id = intval(request()->post('id'));
				$lugar = Lugar::findOrFail($id, "no se ha encontrado el lugar.");
				
				$tmp = $lugar->mainpicture; //recordatemos el nombre para poder borrarlo luego
				
				//en el caso de que se haya pulsado Eliminar
				if(request()->has('borrar'))
					$lugar->mainpicture = NULL; //marca la foto perfil a NULL
				
				try{
					//En el caso de querer cambiar la foto, adjunto fichero, guardaremos el fichero subido
					//recupera la foto del lugarcomo objeto UploadedFile (o null si no llega)
					if($file = request()->file(
								'imagen', 	// nombre del input
								8000000, 	//tamaño maximo del fichero
								['image/png','image/jpeg','image/gif','image/webp'] //tipos aceptados
							)){
						$lugar->mainpicture=$file->store('../public/'.LUGAR_IMAGE_FOLDER, 'profile_');
						
					} else {
						if(request()->has('cambiar')){
							 Session::warning("Debes seleccionar la foto que deseas subir.");
						return redirect("/Lugar/edit/$lugar->id");
					 }
					}
					//$lugar->saneate(); //sanea las entradas.
					$lugar->update();
					Session::success("Se ha sustituido o eliminado la foto del lugar de $lugar->titulo correctamente.");
					
					//si ya existia la foto, tratara de eliminarla primero
					if($tmp)
						File::remove('../public/'.LUGAR_IMAGE_FOLDER.'/'.$tmp, true);
						
					return redirect("/Lugar/edit/$lugar->id");
					
				}  catch(SQLException $e){
					Session::error("No se pudo eliminar la foto del lugar.");
					if(DEBUG)
						throw new SQLException($e->getMessage());
						
						return redirect("/Lugar/edit/$id");
				} catch(FileException $e){
					Session::warning ("No se pudo eliminar el fichero del disco.");
					if(DEBUG)
						throw new SQLException($e->getMessage());
						
						return redirect("/Lugar/edit/$id");
				}catch (UploadException $e){
					$mensaje.="Cambios guardados, pero no se modificó la foto del lugar.";
					Session::error($mensaje);
					
					if(DEBUG)
						throw new SQLException($e->getMessage());
						
						return redirect("/Lugar/edit/$lugar->id");
				}
		}
		//En caso de no se bibliotecario, redirige al inicio
		return redirect('/');
	}
	
	/**
	 * Muestra el formulario de nuevo lugar
	 * @return ViewResponse
	 */
	public function nuevafoto(int $idplace=0){
		//Usuarios autenticados
		Auth::check();
		//Buscamos el lugar
		$lugar = Lugar::findOrFail($idplace, "No existe el lugar.");
			

			return view('lugar/createphotoplace',['lugar'=> $lugar]);
	//	En caso de no estar loginaddo, 
	// redirige a la pantalla de login, de no tener usurios puede crearlo.
		
	}
	
	/**
	 * Guarda los datos que llegan del formulario en la bdd
	 * 
	 * @ redirect Viewresponse
	 */
	public function storephotoplace(){
		 
		//Usuarios autenticados
		Auth::check();
		
			//Comprueba que la petición venga del formulario
			if(!request()->has('guardar'))
				throw new FormException('No se recibió el formulario');
			
				if(!$file = request()->file(
						'imagen', 	// nombre del input
						8000000, 	//tamaño maximo del fichero
						['image/png','image/jpeg','image/gif','image/webp'] //tipos aceptados
						)) {
							
							Session::warning("Es obligatorio establecer la foto del lugar.");
							return redirect(request()->previousUrl);
						}

		$photo=new Photo(); //crea la nueva foto
			
		//OPCION AUTOMATICA
				try{
					
					//Recuperamos el fomulario, saneamos y validamos antes de guardar en BDD
					$phototemp=new Photo(); //crea la nueva foto temporal para crear y validar
					
					//guarda el lugar en la base de datos a partir de los datos POST
					foreach( request()->posts() as $campo=>$valor) //pasamos a objeto Photo
						$phototemp ->$campo=$valor;
						
						//Validaremos que los datos sean correctos
						if($errores = $phototemp->validate()){
							Session::warning("Errores de validación");
							throw new ValidationException(
									"<br>".arrayToString($errores, false, false,".<br>")
									);
						}
							
					//guarda el lugar en la base de datos a partir de los datos POST
					
					$photo = Photo::create((array)$phototemp); //mo es necesario en la  1.8.0
					
					//En el caso de querer cambiar la foto, adjunto fichero, guardaremos el fichero subido
					//recupera la foto del lugarcomo objeto UploadedFile (o null si no llega)

					if($file ){
								$photo->file=$file->store('../public/'.LUGAR_IMAGE_FOLDER, 'lugar_');
								
					} 

					
					$photo->update();
					
					//flashea un mensaje de exito en sesion
					Session::success("Guardado nueva foto $photo->name correctamente.");
					
					//redirecciona a los detalles del nuevo lugar
					return redirect("/Lugar/show/".$photo->idplace);
				}  catch(SQLException $e){
					//prepara el mensaje de error
					$mensaje = "No se pudo guardar el lugar $lugar->name.";
					
					if(str_contains($e->errorMessage(),'Duplicate entry'))
							$mensaje.="<br>Ya existe un lugar con ese <b>ID</b>.";
					
					//flashe un mensaje de error en session
					Session::error($mensaje);
					
					//Si esta en modo DEBUG vuelve a lanzar la excepcion
					//esto hara qie acabemos en la pagina de error
					if(DEBUG)
					throw new SQLException($e->getMessage());
					
					//regresa al formulario de creación de lugar
					return redirect("/Lugar/create");
				}
		
	}
	
}	
	 
