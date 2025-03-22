<?php


/**
 * ComentarioController
 *
 * Operaciones con los  comentarios de lugar
 *
 * @autor Jose Miguel Mora Perez ® CIFO Valles 2025®
 */

class ComentarioController extends Controller{
	
	/**
	 * Mérodo por defecto
	 *
	 * Redirige al método list() de este mismo controlado.
	 *
	 * @return ViewResponse
	 */
	public function index(){
		if( Login::role('ROLE_MODERADOR' ))// autorización(solo MODERADOR)
				return $this->list();
		//Si no es moderador, redirige a la home
		return redirect('/');
	}
	
	/**
	 * Listado de lugars
	 *
	 * @return ViewResponse
	 *
	 */
	public function list(){
		
		if( Login::role('ROLE_MODERADOR' )) {// autorización(solo moderadors)
			
			$comentarios= Comentario::all(); // recupera los comentarios del lugar
			//	carga la vista que los muestra
			return view('comentario/list',['comentarios'=>$comentarios]);
		}
		//Si no es moderador, redirige a la home
		return redirect('/');
	}
	
	/**
	 * Muestra los detalles del un lugar
	 * @param int $id identificador del lugar a mostrar
	 * @return ViewResponse
	 */
	public function show(int $id=0) {
		
	  	if( Login::role('ROLE_MODERADOR' )) {// autorización(solo moderadors)
			// Recupera el lugar
			$lugar = Comentario::findOrFail($id, 'No se encontró el comentario indicado'); //tb comprueba si no le ha llegado el ID
			
			//recupera los comentarios del lugar
			$comentarios= $lugar->hasMany('Comentario');
			
			// carga la vista y le pasa el lugar recuperado
			return view ('comentario/show',['lugar'=>$lugar,'comentarios'=>$comentarios]);
	  	}
	  	//Si no es moderador, redirige a la home
	  	return redirect('/');
		
	}
	
	/**
	 * Muestra el formulario de nuevo comentario 
	 * @return ViewResponse
	 */
	public function create(int $idlugar=-1){
		
		AutH::check(); // Solo usuarios autenticados
		
			$lugar = Lugar::findOrFail($idlugar,'No se encontró el lugar.');
			//retorna una ViewResponse con la vista con el formulario de creacion
			return view('comentario/create',['lugar'=>$lugar]);
	
		
	}
	
	/**
	 * Guarda los datos que llegan del formulario en la bdd
	 * 
	 * @ redirect Viewresponse
	 */
	public function store(){
		Auth::check(); //Solo usuarios autenticados
			//Comprueba que la petición venga del formulario
		if(!request()->has('nuevocomentario') && !request()->has('nuevofotocomentario') )
				throw new FormException('No se recibió el formulario');
			$retorno= request()->post('retorno')??'';
			
			$comentario=new Comentario(); //crea el nuevo comentario
			
		//OPCION AUTOMATICA
			try{
				
				//Recuperamos el fomulario, saneamos y validamos antes de guardar en BDD
				$comentariotemp=new Comentario(); //crea el nuevo comentario temporal para crear y validar
					
				//guarda el lugar en la base de datos a partir de los datos POST
				foreach( request()->posts() as $campo=>$valor) //pasamos a objeto Lugar
					$comentariotemp ->$campo=$valor;
					
					//Validaremos que los datos sean correctos
					if($errores = $comentariotemp->validate()){
						Session::warning("Errores de validación");
						throw new ValidationException(
								"<br>".arrayToString($errores, false, false,".<br>"));
						return redirect(request()->previousUrl.$retorno);
						//return redirect("/Lugar/show/$comentario->idplace#seccomentarios");
					}
						
				//guarda el lugar en la base de datos a partir de los datos POST
				
				$comentario = Comentario::create((array)$comentariotemp); //mo es necesario en la  1.8.0
				
			
				//flashea un mensaje de exito en sesion
				Session::success("Guardado del comentario  $comentario->id - '$comentario' correctamente.");
				
				//redirecciona a los detalles del nuevo lugar
				return redirect(request()->previousUrl.$retorno);
				//return redirect("/Lugar/show/$comentario->idplace#seccomentariosfotos");
			} catch (ValidationException $e){
				if(DEBUG)
					throw new ValidationException($e->getMessage());
					
				Session::error($e->getMessage());
				return redirect("/Lugar/show/".$comentario->idplace.'#'.$retorno);
				//return redirect ("$request->previousUrl");
			}catch (FormException $e){
				if(DEBUG)
					throw new FormException($e->getMessage());
					
				Session::error($e->getMessage());
				return redirect("/Lugar/show/".$comentario->idplace.'#'.$retorno);
				//return redirect ("$request->previousUrl");
			}catch(SQLException $e){
				//prepara el mensaje de error
				$mensaje = "No se pudo guardar el comentario del lugar ".$comentario->text;
				
				if(str_contains($e->errorMessage(),'Duplicate entry'))
						$mensaje.="<br>Ya existe un comentario con ese <b>ID</b>.";
				
				//flashe un mensaje de error en session
				Session::error($mensaje);
				
				//Si esta en modo DEBUG vuelve a lanzar la excepcion
				//esto hara qie acabemos en la pagina de error
				if(DEBUG)
				throw new SQLException($e->getMessage());
				
				//regresa al formulario de creación de lugar
				return redirect($request->previousUrl.$retorno);
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
		if(Login::user()->id == $id || Login::oneRole(['ROLE_ADMIN','ROLE_MODERADOR' ])) {// autorización(solo ppropietario o moderadors)
		
			$comentario = Comentario::findOrFail($id, "No existe el comentario.");
			
			return view('comentario/delete',['comentario'=> $comentario]);
		}
		//Si no es moderador, redirige a la home
		return redirect('/');
	
	}
	
	/** Elimina el comentario de la base de datos
	 * @return RedirectResponse
	 */
	public function destroy(int $id=0, $retorno){
	
			Auth::check(); //verificamos que el usuario este logineado
			
		  //	if(!request()->has('borrar')) //si no llega el formulario ...
			//	throw new FormException ('No se recibieron datos');
			//$id = intval(request()->post('id')); // recuperar el id via POST
		
				//Recupera el comentario de la BDD		
				$comentario= Comentario::findOrFail($id,"No se encontró el comentario.");
				$idplace = $comentario->idplace;
				$idphoto = $comentario->idphoto;
				
				
			
			// autorización(solo propietario o moderadors)
		
		if(Login::user()->id == $comentario->iduser || Login::oneRole(['ROLE_ADMIN','ROLE_MODERADOR'] )) {
			
			
			
				//intenta borrar el comentario
			try{
					$comentario->deleteObject();
					
					if($idplace){
						$lugar=Lugar::findOrFail($idplace,"No se ha encontrado el lugar");
						Session::success("Se ha borrado el comentario 
								$comentario->id - $comentario->text  del lugar $lugar->name.");
						return redirect("/Lugar/show/".$lugar->id.'#'.$retorno);
					}
					
					if($idphoto){
						$photo=V_picture::findOrFail($idphoto,"No se ha encontrado la foto");
						Session::success("Se ha borrado el comentario 
								$comentario->id - $comentario->text de la foto $photo->name.");
						return redirect("/Lugar/show/".$photo->idplace.'#'.$retorno);
						}
					
				return redirect("/"); // por si no ha podido redirigir.
					//si se produce un error en la operació con la bdd..
			} catch (Exception $e){
				
				Session::error("No se pudo borrar el comentario $comentario->id de  $lugar->name.");
				
				if ($comentario->idplace)
					return redirect("/Lugar/show/".$comentario->idplace.$retorno);
					else {
						$photo=V_picture::findOrFail($idphoto,"No se ha encontrado la foto");
						return redirect("/Lugar/show/".$photo->idplace.'#'.$retorno);
					}
					
					
			}
		}
		//Si no es moderador, redirige a la home
		return redirect('/');
		
	}
	
	/**
	 * Muestra el formulario de edición del comentario del lugar
	 *
	 * @param int $id el ID único del comentario a editar
	 *
	 * @return ViewResponse
	 *
	 */
	public function edit(int $id=0){
		if( Login::role('ROLE_MODERADOR' )) {// autorización(solo moderadors)
			// busca el lugar con ese ID
			$comentario = Comentario::findOrFail($id,'No se encontró el comentario.');
			
			//recupera los comentarios del lugar
			 $lugar= $comentario->belongsTo('Lugar');
			
			//retorna una ViewResponse con la vista con el formulario de edición
			 return view('comentario/edit',['comentario'=>$comentario, 'lugar'=>$lugar]);
	
		}
		//Si no es moderador, redirige a la home
		return redirect('/');
	}
	
	/** Actualzia la bdd con los datos POST del formulario
	 */
	public function update(){
		if( Login::role('ROLE_MODERADOR' )) {// autorización(solo moderadors)
			if(!request()->has('actualizar')) //si no llega el formulario ...
				throw new FormException ('No se recibieron datos');
				
				$id = intval(request()->post('id')); // recuperar el id via POST
				
				
				$lugar=Lugar::findOrFail(intval(request()->post('idlugar')));
				//intenta actualizar el lugar
				try{
				
					$comentario->saneate(); //sanea las entradas.
					$comentario= Comentario::create(request()->posts() ,$id);
					
					Session::success("Actualización del comentario $comentario->id del lugar $lugar->name  ha sido correcta.");
					return redirect("/Lugar/edit/$comentario->idlugar");
					
					// Si se produce un error al guardar el lugar..
				}catch (SQLException $e){
					// prepara el mensaje de error
					$mensaje = "No se pudo actualizar el comentario";
					
					if(str_contains($e->errorMessage(),'Duplicate entry'))
						$mensaje.="<br>Ya existe un comentario con ese <b>ID</b>.";
						Session::error($mensaje);
						
						if(DEBUG)
							throw new SQLException($e->getMessage());
							
							return redirect("/Lugar/edit/$comentario->idplace");
				}
			}
		
		//Si no es moderador, redirige a la home
		//return redirect($request->previousUrl );
		return redirect("/Lugar/edit/$comentario->idlugar");
	}
}
