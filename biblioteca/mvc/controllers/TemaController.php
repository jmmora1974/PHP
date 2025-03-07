<?php
/**
* TemaController
* 
* Operaciones con los temas
* 
* @autor Jose Miguel Mora Perez ® CIFO Valles 2025®
*/

class TemaController extends Controller{
	
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
	 * Listado de temas
	 * 
	 * @return ViewResponse
	 * 
	 */
	public function list(int $page=1){
	 
	 		//analiza si hay filtros, pone uno nuevo o quit el existente
		$filtro = Filter::apply('temas');
		
		$limit = RESULTS_PER_PAGE; //Numer de resultados por pagina
		
		//si hay filtro
		if($filtro){
			//recupera el total de libros que cumplen los criterios del filtro
			$total = Tema::filteredResults($filtro);
			
			//crea el objeto paginador
			$paginator = new Paginator('/Tema/list', $page, $limit, $total,'es');
			
			//recupera los libros que cumplen los criteros del filtro
			$temas= Tema::filter($filtro, $limit, $paginator->getOffset());
			// recupera los libros junto la información extra (ejemplares)
		} else {
			
			$total = Tema::total(); //total del libro
			
			//crea el objeto paginador
			$paginator = new Paginator('/Tema/list', $page, $limit, $total,'es');
			
			
			$temas= Tema::orderBy('tema', 'ASC', $limit, $paginator->getOffset()); // recupera los libros junto la información extra (ejemplares)
			
			
		}
		
		
		
		//	carga la vista que los muestra
	return view('tema/list',['temas'=>$temas,'paginator'=>$paginator,'filtro' => $filtro]);
	}
	
	/**
	 * Muestra los detalles del un tema
	 * @param int $id identificador del tema a mostrar
	 * @return ViewResponse
	 */
	public function show(int $id=0) {
		
	
		$tema = Tema::findOrFail($id, 'No se enontró el tema indicado'); //tb comprueba si no le ha llegado el ID
		
		//recueramos los libros del tema
		$libros=$tema->getLibrosTema();
		
		// carga la vista y le pasa el tema recuperado
		return view ('tema/show',['tema'=>$tema,'libros'=>$libros]);
		
	}
	
	/**
	 * Muestra el formulario de nuevo tema
	 * @return ViewResponse
	 */
	public function create(){
		return view('tema/create');
	}
	
	/**
	 * Guarda los datos que llegan del formulario en la bdd
	 * 
	 * @ redirect Viewresponse
	 */
	public function store(){
		//Comprueba que la petición venga del formulario
		if(!request()->has('guardar'))
			throw new FormException('No se recibió el formulario');
		$tema=new Tema(); //crea el nuevo tema
		
	//OPCION AUTOMATICA
			try{
				//guarda el tema en la base de datos a partir de los datosPOST
				$tema = Tema::create(request()->posts()); //mo es necesario en la  1.8.0
				
				
				//flashea un mensaje de exito en sesion
				Session::success("Guardado del tema $tema->tema  correcto.");
				
				//redirecciona a los detalles del nuevo tema
				return redirect("/Tema/show/$tema->id");
			}  catch(SQLException $e){
				//prepara el mensaje de error
				$mensaje = "No se pudo guardar el tema $tema->tema.";
				
				if(str_contains($e->errorMessage(),'Duplicate entry'))
						$mensaje.="<br>Ya existe el tema</b>.";
				
				//flashe un mensaje de error en session
				Session::error($mensaje);
				
				//Si esta en modo DEBUG vuelve a lanzar la excepcion
				//esto hara qie acabemos en la pagina de error
				if(DEBUG)
				throw new SQLException($e->getMessage());
				
				//regresa al formulario de creación de tema
				return redirect("/Tema/create");
			}
	
	}
	
	/** 
	 * Muestra el formulario de edición del tema
	 * 
	 * @param int $id el ID único del tema a editar
	 * 
	 * @return ViewResponse
	 * 
	 */
	public function edit(int $id=0){
		
		// busca el tema con ese ID
		$tema = Tema::findOrFail($id,'No se encontró el tema.');
		
		//retorna una ViewResponse con la vista con el formulario de edición
		return view('tema/edit',['tema'=>$tema]);
	}
	
	/** Actualzia la bdd con los datos POST del formulario
	*/
	public function update(){
		
		if(!request()->has('actualizar')) //si no llega el formulario ...
			throw new FormException ('No se recibieron datos');
		
		$id = intval(request()->post('id')); // recuperar el id via POST
	
	
		//intenta actualizar el tema
		try{
			//$tema->update(); No es necesario en la 1.8.0 
			// ya el metodo create ya actualiza si manda el 2ºparametro
			$tema= Tema::create(request()->posts() ,$id);
			
			Session::success("Actualización del tema $tema->tema   correcta.");
			return redirect("/Tema/edit/$id");
			
		// Si se produce un error al guardar el tema..
		}catch (SQLException $e){
			// prepara el mensaje de error
			$mensaje = "No se pudo actualizar el tema";
			
		if(str_contains($e->errorMessage(),'Duplicate entry'))
				$mensaje.="<br>Ya existe un tema con ese <b>DNI</b>.";
			Session::error($mensaje);
			
			if(DEBUG)
				throw new SQLException($e->getMessage());
			
				return redirect("/Tema/edit/$id");
		}
	}
	
	/** 
	 * Muestra el formulario de confirmación de eliminación
	 * 
	 * @param int $id identificador único del tema a eliminar
	 * 
	 * @return ViewResponse
	 */	
	public function delete(int $id){
		
		$tema = Tema::findOrFail($id, "No existe el tema.");
		
		return view('tema/delete',['tema'=> $tema]);
	}
	
	/** Elimina el tema de la base de datos
	 * @return RedirectResponse
	 */
	public function destroy(){
		//comprueba que le llega el formulario de confirmación
		if(!request()->has('borrar'))
			throw new FormException("No se recibió la confirmación");
		
			$id 	=intval(request()->post('id')); //Recupera el identiicador
			$tema	=Tema::findOrFail($id);
			
			//si hay libros de ese tema, no permitiremos su borrado
			//mas adelante ocultaeremos el boton de "borrar" en estos casos 
			// para que no el usuario no llegue al formulario de confirmación
			if($tema->hasAny('TemaLibro'))
				throw new Exception("No se puede borrar el tema mientras haya libros con el tema $tema->tema.");
			
				//intenta borrar el tema
				try{
					$tema->deleteObject();
					Session::success("Se ha borrado el tema $tema->tema.");
					return redirect("/Tema/list");
				//si se produce un error en la operación con la bdd..
				} catch (SQLException $e){
					
					Session::error("No se pudo borrar el tema $tema->tema.");
					
					if(DEBUG)
						throw new SQLException($e->getMessage());
						
						return redirect("/Tema/delete/$id");
				}
	}
}	
	 
